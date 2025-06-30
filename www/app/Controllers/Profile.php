<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Por favor inicia sesión primero');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        if (!$user) {
            return redirect()->to('/logout');
        }

        return view('profile', ['user' => $user]);
    }

    public function update()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Por favor inicia sesión primero');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/logout')->with('error', 'Usuario no encontrado');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[30]',
            'age' => 'permit_empty|numeric|greater_than[0]|less_than[120]',
            'profile_pic' => [
                'uploaded[profile_pic]',
                'max_size[profile_pic,2048]',
                'mime_in[profile_pic,image/jpg,image/jpeg,image/png]',
                'ext_in[profile_pic,jpg,jpeg,png]'
            ],
            'password' => 'permit_empty|min_length[8]|matches[password_confirmation]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => esc($this->request->getPost('username')),
            'age' => $this->request->getPost('age'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($password = $this->request->getPost('password')) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic && $profilePic->isValid()) {
            $newName = $profilePic->getRandomName();
            $uploadPath = FCPATH . 'uploads/profiles'; 

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($profilePic->move($uploadPath, $newName)) {
                $data['profile_pic'] = 'uploads/profiles/' . $newName;

                if (
                    !empty($user['profile_pic']) &&
                    strpos($user['profile_pic'], 'default') === false &&
                    file_exists(FCPATH . $user['profile_pic'])
                ) {
                    unlink(FCPATH . $user['profile_pic']);
                }
            }
        }

        try {
            $userModel->update($userId, $data);
            return redirect()->to('/profile')->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            if (isset($newName)) {
                @unlink(FCPATH . 'uploads/profiles/' . $newName);
            }
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Por favor inicia sesión primero');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/logout');
        }

        if (!empty($user['profile_pic']) && strpos($user['profile_pic'], 'default') === false) {
            @unlink(WRITEPATH . $user['profile_pic']);
        }

        if ($userModel->delete($userId)) {
            session()->destroy();
            return redirect()->to('/')->with('success', 'Tu cuenta ha sido eliminada correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la cuenta');
        }
    }
}