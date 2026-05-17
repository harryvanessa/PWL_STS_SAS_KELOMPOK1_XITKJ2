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

        if (!$profile || $profile['status'] !== 'approved') {
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

    // ─── Profile Management ──────────────────────────────────────────────────────

    public function profile()
    {
        $uid = $_SESSION['user']['id'];
        $this->render('mentor/mentor_profile', [
            'judul'   => 'Profil Mentor',
            'user'    => $this->model('User_model')->getUserById($uid),
            'profile' => $this->model('Mentor_model')->getMentorProfile($uid),
        ]);
    }

    public function update_profile()
    {
        if (!$this->isPost()) {
            return $this->redirect('mentor/profile');
        }

        $uid = $_SESSION['user']['id'];

        $this->model('Mentor_model')->updateMentorProfile([
            'user_id'    => $uid,
            'full_name'  => trim($_POST['full_name']  ?? ''),
            'email'      => trim($_POST['email']       ?? ''),
            'phone'      => trim($_POST['phone']       ?? ''),
            'experience' => trim($_POST['experience']  ?? ''),
        ]);

        $current_pw = $_POST['current_password'] ?? '';
        $new_pw     = $_POST['new_password']     ?? '';
        $confirm_pw = $_POST['confirm_password'] ?? '';

        if (!empty($new_pw)) {
            if (empty($current_pw)) {
                Flasher::setFlash('Profil', 'Harap masukkan password saat ini untuk mengganti password', 'danger');
                return $this->redirect('mentor/profile');
            }
            if ($new_pw !== $confirm_pw) {
                Flasher::setFlash('Profil', 'Konfirmasi password baru tidak cocok', 'danger');
                return $this->redirect('mentor/profile');
            }
            $user = $this->model('User_model')->getUserById($uid);
            if (!password_verify($current_pw, $user['password'])) {
                Flasher::setFlash('Profil', 'Password saat ini salah', 'danger');
                return $this->redirect('mentor/profile');
            }
            $this->model('User_model')->updatePassword($uid, password_hash($new_pw, PASSWORD_DEFAULT));
            Flasher::setFlash('Profil', 'Biodata & Password Berhasil Diperbarui', 'success');
            return $this->redirect('mentor/profile');
        }

        Flasher::setFlash('Profil', 'Berhasil Diperbarui', 'success');
        $this->redirect('mentor/profile');
    }

}
