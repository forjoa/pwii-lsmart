<?php

namespace App\Controllers;

use App\Libraries\GroqService;
use App\Models\ConversationModel;
use App\Models\MessageModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['username'] = session()->get('username') ?? 'Invitado';
        $data['email'] = session()->get('email') ?? '';
        $data['profile_picture'] = session()->get('profile_picture');
        $data['user_id'] = session()->get('user_id');

        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->where('user_id', $data['user_id'])
            ->orderBy('date', 'DESC')
            ->findAll();

        $data['conversations'] = $conversations;

        $groq = new GroqService();
        $modelsResponse = $groq->getModels();

        $data['groq_models'] = array_map(function ($model) {
            return $model['id'];
        }, $modelsResponse['data'] ?? []);

        return view('dashboard', $data);
    }

    public function chat($id)
    {
        $data['username'] = session()->get('username') ?? 'Invitado';
        $data['email'] = session()->get('email') ?? '';
        $data['profile_picture'] = session()->get('profile_picture');
        $data['user_id'] = session()->get('user_id');

        $conversationModel = new ConversationModel();
        $conversations = $conversationModel->where('user_id', $data['user_id'])
            ->orderBy('date', 'DESC')
            ->findAll();

        $data['conversations'] = $conversations;

        $messageModel = new MessageModel();
        $messages = $messageModel->where('conversation_id', $id)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $data['messages'] = $messages;
        $data['conversation_id'] = $id;

        $groq = new GroqService();
        $modelsResponse = $groq->getModels();

        $data['groq_models'] = array_map(function ($model) {
            return $model['id'];
        }, $modelsResponse['data'] ?? []);

        return view('dashboard', $data);
    }
}