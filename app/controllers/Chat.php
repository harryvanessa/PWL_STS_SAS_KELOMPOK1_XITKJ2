<?php

class Chat extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user'])) $this->redirect('auth');
    }

    public function session($session_id)
    {
        $session = $this->model('Chat_model')->getSessionDetails($session_id);
        $uid     = $_SESSION['user']['id'];

        // 2 orng access system
        if ($session['student_id'] != $uid && $session['mentor_id'] != $uid) {
            $this->redirect('');
        }

        $isStudent = $_SESSION['user']['role'] === 'student';
        $this->render('chat/index', [
            'judul'           => 'Ruang Diskusi Sesi',
            'session'         => $session,
            'messages'        => $this->model('Chat_model')->getMessagesBySession($session_id),
            'current_user_id' => $uid,
            'recipient_id'    => $isStudent ? $session['mentor_id'] : $session['student_id'],
            'partner_name'    => $isStudent ? $session['mentor_username'] : $session['student_username'],
            'back_url'        => BASEURL . '/' . ($isStudent ? 'student' : 'mentor'),
        ]);
    }

    public function send()
    {
        if (!$this->isPost() || empty($_POST['message'])) return;

        $msg = trim(htmlspecialchars($_POST['message']));
        if ($msg !== '') {
            $this->model('Chat_model')->sendMessage([
                'session_id'   => $_POST['session_id'],
                'sender_id'    => $_SESSION['user']['id'],
                'recipient_id' => $_POST['recipient_id'],
                'message'      => $msg,
            ]);
        }

        $this->redirect('chat/session/' . $_POST['session_id']);
    }
}
