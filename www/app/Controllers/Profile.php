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
            return redirect()->to('/logout');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[30]',
            'age' => 'permit_empty|numeric|greater_than[0]|less_than[120]',
            'profile_pic' => 'uploaded[profile_pic]|max_size[profile_pic,2048]|is_image[profile_pic]|ext_in[profile_pic,jpg,jpeg,png]',
            'password' => 'permit_empty|min_length[8]|matches[password_confirmation]'
        ];

        $data = [
            'username' => $this->request->getPost('username'),
            'age' => $this->request->getPost('age'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
            $newName = $profilePic->getRandomName();
            $profilePic->move(WRITEPATH . 'uploads/profile_pics', $newName);
            $data['profile_pic'] = 'uploads/profile_pics/' . $newName;

            if (!empty($user['profile_pic']) && strpos($user['profile_pic'], 'default') === false) {
                @unlink(WRITEPATH . $user['profile_pic']);
            }
        }

        
        if ($userModel->update($userId, $data)) {
            return redirect()->to('/profile')->with('success', 'Perfil actualizado correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil');
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