<?php

namespace App\Controllers;

use App\Libraries\RecaptchaService;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('login');
    }

    public function register(): string
    {
        return view('register');
    }

    public function signup()
    {
        // data validation
        $rules = [
            'username' => 'permit_empty|min_length[3]|max_length[20]',
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'valid_email' => 'The email address is not valid.',
                    'is_unique' => 'The email address is already registered.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'min_length' => 'The password must contain at least 8 characters.',
                    'regex_match' => 'The password must contain both upper and lower case letters and numbers.'
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => 'Passwords do not match.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // email validation
        $email = $this->request->getPost('email');
        $allowedDomains = ['@students.salle.url.edu', '@ext.salle.url.edu', '@salle.url.edu'];
        $validDomain = false;

        foreach ($allowedDomains as $domain) {
            if (strpos($email, $domain) !== false) {
                $validDomain = true;
                break;
            }
        }

        if (!$validDomain) {
            return redirect()->back()->withInput()->with('error', 'Only emails from the domain @students.salle.url.edu, @ext.salle.url.edu or @salle.url.edu are accepted.');
        }

        // reCAPTCHA validation
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
        $recaptcha = new RecaptchaService();
        $recaptchaResult = $recaptcha->verify($recaptchaResponse);

        if (!$recaptchaResult) {
            return redirect()->back()->withInput()->with('error', 'Captcha test failed. Please try again.');
        }

        // profile pic
        $profilePicture = $this->request->getFile('profile_picture');
        $profilePath = 'default-profile.jpg';

        if ($profilePicture->isValid() && !$profilePicture->hasMoved()) {
            $newName = $profilePicture->getRandomName();
            $profilePicture->move(FCPATH . 'uploads/profiles', $newName);
            $profilePath = 'uploads/profiles/' . $newName;
        }

        // generate username if not provided
        $username = $this->request->getPost('username');
        if (empty($username)) {
            $username = strtok($email, '@');
        }

        // insert user
        $userModel = new UserModel();
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'profile_pic' => $profilePath,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $userModel->insert($data);
            return redirect()->to('/sign-in')->with('message', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    public function signin()
    {
        // data validation
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'valid_email' => 'The email address is not valid.'
                ]
            ],
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // email validation
        $email = $this->request->getPost('email');
        $allowedDomains = ['@students.salle.url.edu', '@ext.salle.url.edu', '@salle.url.edu'];
        $validDomain = false;

        foreach ($allowedDomains as $domain) {
            if (strpos($email, $domain) !== false) {
                $validDomain = true;
                break;
            }
        }

        if (!$validDomain) {
            return redirect()->back()->withInput()->with('error', 'The email address is not valid.');
        }

        // user auth
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Your email and/or password are incorrect.');
        }

        // create session
        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
            'profile_pic' => $user['profile_pic'] ?? 'default-profile.jpg',
            'logged_in' => true
        ]);

        // redirect to chats
        return redirect()->to('/');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/sign-in');
    }
}