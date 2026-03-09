<?php

class Chat extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function session($session_id)
    {
        $data['judul'] = 'Ruang Diskusi Sesi';
        $data['session'] = $this->model('Chat_model')->getSessionDetails($session_id);
        
        // Security check: Only involved student or mentor can access
        $user_id = $_SESSION['user']['id'];
        if ($data['session']['student_id'] != $user_id && $data['session']['mentor_id'] != $user_id) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['messages'] = $this->model('Chat_model')->getMessagesBySession($session_id);
        $data['current_user_id'] = $user_id;

        // Determine recipient
        if ($_SESSION['user']['role'] == 'student') {
            $data['recipient_id'] = $data['session']['mentor_id'];
            $data['partner_name'] = $data['session']['mentor_username'];
            $data['back_url'] = BASEURL . '/student';
        } else {
            $data['recipient_id'] = $data['session']['student_id'];
            $data['partner_name'] = $data['session']['student_username'];
            $data['back_url'] = BASEURL . '/mentor';
        }

        $this->view('templates/header', $data);
        $this->view('chat/index', $data);
        $this->view('templates/footer');
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
            $data = [
                'session_id' => $_POST['session_id'],
                'sender_id' => $_SESSION['user']['id'],
                'recipient_id' => $_POST['recipient_id'],
                'message' => htmlspecialchars($_POST['message'])
            ];

            if(!empty(trim($data['message']))) {
                $this->model('Chat_model')->sendMessage($data);
            }
            
            header('Location: ' . BASEURL . '/chat/session/' . $data['session_id']);
            exit;
        }
    }
}
