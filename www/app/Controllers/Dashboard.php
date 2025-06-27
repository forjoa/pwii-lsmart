<?php

namespace App\Controllers;

use App\Libraries\GroqService;
use App\Models\ConversationModel;
use App\Models\MessageModel;
use Config\Database;

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

    // public function sendMessage()
    // {
    //     $conversation_id = $this->request->getPost('conversation_id');
    //     $message = $this->request->getPost('message');
    //     $model = $this->request->getPost('model');
    //     $user_id = session()->get('user_id');

    //     if (empty($user_id)) {
    //         return redirect()->to('/sign-in')->with('message', 'Debes iniciar sesión.');
    //     }

    //     if (empty($message) || empty($model)) {
    //         return redirect()->back()->withInput()->with('error', 'Todos los campos son requeridos');
    //     }

    //     $db = Database::connect();
    //     $db->transStart();

    //     try {
    //         $conversationModel = new ConversationModel();
    //         $messageModel = new MessageModel();

    //         if (empty($conversation_id)) {
    //             $words = preg_split('/\s+/', trim($message));
    //             $title = implode(' ', array_slice($words, 0, 3));

    //             $conversationData = [
    //                 'user_id' => $user_id,
    //                 'title' => $title,
    //                 'date' => date('Y-m-d H:i:s'),
    //                 'model_used' => $model
    //             ];

    //             $conversation_id = $conversationModel->insert($conversationData);
    //         }

    //         $userMessageData = [
    //             'conversation_id' => $conversation_id,
    //             'is_user_message' => 1,
    //             'content' => $message,
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];
    //         $messageModel->insert($userMessageData);

    //         $groqService = new GroqService();
    //         $response = $groqService->message($model, $message);

    //         if (isset($response['error'])) {
    //             throw new \Exception($response['message']);
    //         }

    //         $aiMessageData = [
    //             'conversation_id' => $conversation_id,
    //             'is_user_message' => 0,
    //             'content' => $response['response'],
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];
    //         $messageModel->insert($aiMessageData);

    //         $db->transComplete();

    //         return redirect()->to("/chat/$conversation_id")->with('success', 'Mensaje enviado');

    //     } catch (\Exception $e) {
    //         $db->transRollback();
    //         log_message('error', 'Error en sendMessage: ' . $e->getMessage());
    //         return redirect()->back()->withInput()->with('error', 'Error al procesar el mensaje: ' . $e->getMessage());
    //     }
    // }
    public function sendMessage()
    {
        $conversation_id = $this->request->getPost('conversation_id');
        $message = $this->request->getPost('message');
        $model = $this->request->getPost('model');
        $user_id = session()->get('user_id');

        if (empty($user_id)) {
            return redirect()->to('/sign-in')->with('message', 'Debes iniciar sesión.');
        }

        if (empty($message) || empty($model)) {
            return redirect()->back()->withInput()->with('error', 'Todos los campos son requeridos');
        }

        $db = Database::connect();
        $db->transStart();

        try {
            $conversationModel = new ConversationModel();
            $messageModel = new MessageModel();
            $isNewConversation = empty($conversation_id);

            // 1. Manejo de nueva conversación
            if ($isNewConversation) {
                // Primero enviamos el mensaje para generar un título
                $titlePrompt = "Genera un título corto (máximo 4 palabras) para esta conversación sobre: " . substr($message, 0, 100);

                $titleResponse = $this->generateConversationTitle($model, $titlePrompt);
                $title = $titleResponse['success'] ? $titleResponse['response'] : implode(' ', array_slice(explode(' ', $message), 0, 3));

                $conversationData = [
                    'user_id' => $user_id,
                    'title' => $title,
                    'date' => date('Y-m-d H:i:s'),
                    'model_used' => $model
                ];

                $conversation_id = $conversationModel->insert($conversationData);
            }

            // 2. Guardar mensaje del usuario
            $userMessageData = [
                'conversation_id' => $conversation_id,
                'is_user_message' => 1,
                'content' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $messageModel->insert($userMessageData);

            // 3. Obtener últimos 20 mensajes para contexto
            $contextMessages = $messageModel->where('conversation_id', $conversation_id)
                ->orderBy('created_at', 'DESC')
                ->limit(20)
                ->findAll();

            // Ordenar cronológicamente y formatear para la API
            $contextMessages = array_reverse($contextMessages);
            $formattedMessages = array_map(function ($msg) {
                return [
                    'role' => $msg['is_user_message'] ? 'user' : 'assistant',
                    'content' => $msg['content']
                ];
            }, $contextMessages);

            // 4. Obtener respuesta de Groq con contexto
            $groqService = new GroqService();
            $response = $groqService->messageWithContext($model, $formattedMessages);

            if (isset($response['error'])) {
                throw new \Exception($response['message']);
            }

            // 5. Guardar respuesta de la IA
            $aiMessageData = [
                'conversation_id' => $conversation_id,
                'is_user_message' => 0,
                'content' => $response['response'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            $messageModel->insert($aiMessageData);

            $db->transComplete();

            return redirect()->to("/chat/$conversation_id")->with('success', 'Mensaje enviado');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error en sendMessage: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al procesar el mensaje: ' . $e->getMessage());
        }
    }

    private function generateConversationTitle($model, $prompt)
    {
        $groqService = new GroqService();
        $response = $groqService->message($model, 'Solo debes devolver el título lo más corto posible en español sobre la siguiente pregunta: '.$prompt);

        if ($response['success']) {
            $title = trim($response['response']);
            $title = preg_replace('/^"|"$/', '', $title); 
            $title = substr($title, 0, 50); 
            return ['success' => true, 'response' => $title];
        }

        return ['success' => false];
    }
}