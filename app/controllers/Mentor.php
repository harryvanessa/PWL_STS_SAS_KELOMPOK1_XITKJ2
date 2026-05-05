<?php

class Mentor extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mentor') {
            $this->redirect('auth');
        }
    }

    public function index()
    {
        $uid     = $_SESSION['user']['id'];
        $profile = $this->model('Mentor_model')->getMentorProfile($uid);
        $data    = ['judul' => 'Dashboard Mentor', 'profile' => $profile];

        if ($profile['status'] !== 'approved') {
            return $this->render('mentor/pending_approval', $data);
        }

        $data['requests'] = $this->model('Mentor_model')->getSessionRequests($uid);
        $data['comments'] = $this->model('Mentor_model')->getMentorComments($uid);
        $this->render('mentor/index', $data);
    }

    public function confirm_session_with_link()
    {
        if ($this->isPost() && isset($_POST['id'])) {
            $ok = $this->model('Mentor_model')->confirmSessionWithLink(
                $_POST['id'],
                $_POST['meeting_link'] ?? null
            );
            $ok > 0
                ? Flasher::setFlash('Sesi Bimbingan', 'Berhasil Dikonfirmasi', 'success')
                : Flasher::setFlash('Sesi', 'Gagal Dikonfirmasi', 'danger');
        }
        $this->redirect('mentor');
    }

    public function reject_session($id)
    {
        $this->updateSession($id, 'rejected', 'Sesi Bimbingan', 'Telah Ditolak', 'Gagal Ditolak');
    }

    public function complete_session($id)
    {
        $this->updateSession($id, 'completed', 'Sesi Bimbingan', 'Ditandai Selesai', 'Gagal Diselesaikan');
    }

    public function chat($session_id)
    {
        $this->redirect('chat/session/' . $session_id);
    }

    private function updateSession($id, $status, $title, $successMsg, $failMsg)
    {
        $ok = $this->model('Mentor_model')->updateSessionStatus($id, $status);
        $ok > 0
            ? Flasher::setFlash($title, $successMsg, 'success')
            : Flasher::setFlash($title, $failMsg, 'danger');
        $this->redirect('mentor');
    }

    public function comments()
    {
        $uid = $_SESSION['user']['id'];
        $data = [
            'judul' => 'Semua Ulasan Siswa',
            'comments' => $this->model('Mentor_model')->getMentorComments($uid)
        ];
        $this->render('mentor/comments', $data);
    }
}
