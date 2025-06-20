<?php

namespace App\Controllers;

use App\Models\ConversationModel;

class Dashboard extends BaseController
{
    public function index() {
        $data['username'] = session()->get('username') ?? 'Invitado';
        $data['email'] = session()->get('email') ?? '';
        $data['profile_picture'] = session()->get('profile_picture');
        $data['user_id'] = session()->get('user_id');

        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->where('user_id', $data['user_id'])
            ->orderBy('date', 'DESC')
            ->findAll();

        $data['conversations'] = $conversations;
        
        return view('dashboard', $data);
    }
}