<?php

class Mentor extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mentor') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard Mentor';
        $data['profile'] = $this->model('Mentor_model')->getMentorProfile($_SESSION['user']['id']);
        
        if ($data['profile']['status'] !== 'approved') {
            $this->view('templates/header', $data);
            $this->view('mentor/pending_approval', $data);
            $this->view('templates/footer');
            return;
        }

        $data['requests'] = $this->model('Mentor_model')->getSessionRequests($_SESSION['user']['id']);

        $this->view('templates/header', $data);
        $this->view('mentor/index', $data);
        $this->view('templates/footer');
    }

    public function confirm_session_with_link()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $session_id = $_POST['id'];
            $meeting_link = $_POST['meeting_link'] ?? null;
            
            if ($this->model('Mentor_model')->confirmSessionWithLink($session_id, $meeting_link) > 0) {
                Flasher::setFlash('Sesi Bimbingan', 'Berhasil Dikonfirmasi', 'success');
            } else {
                Flasher::setFlash('Sesi', 'Gagal Dikonfirmasi', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/mentor');
        exit;
    }

    public function reject_session($session_id)
    {
        if ($this->model('Mentor_model')->updateSessionStatus($session_id, 'rejected') > 0) {
            Flasher::setFlash('Sesi Bimbingan', 'Telah Ditolak', 'success');
        } else {
            Flasher::setFlash('Sesi', 'Gagal Ditolak', 'danger');
        }
        header('Location: ' . BASEURL . '/mentor');
        exit;
    }

    public function complete_session($session_id)
    {
        if ($this->model('Mentor_model')->updateSessionStatus($session_id, 'completed') > 0) {
            Flasher::setFlash('Sesi Bimbingan', 'Ditandai Sebagai Selesai', 'success');
        } else {
            Flasher::setFlash('Sesi', 'Gagal Diselesaikan', 'danger');
        }
        header('Location: ' . BASEURL . '/mentor');
        exit;
    }

    public function chat($session_id)
    {
        header('Location: ' . BASEURL . '/chat/session/' . $session_id);
        exit;
    }
}
