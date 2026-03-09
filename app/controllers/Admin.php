<?php

class Admin extends Controller {
    public function __construct()
    {
        parent::__construct();
        // Auth check
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard Admin';
        $data['mentors'] = $this->model('Admin_model')->getPendingMentors();
        $data['skills'] = $this->model('Skill_model')->getAllSkills();

        $this->view('templates/header', $data);
        $this->view('admin/index', $data);
        $this->view('templates/footer');
    }

    public function approve_mentor($id)
    {
        if ($this->model('Admin_model')->approveMentor($id) > 0) {
            Flasher::setFlash('Mentor Berhasil', 'Disetujui', 'success');
        } else {
            Flasher::setFlash('Mentor Gagal', 'Disetujui', 'danger');
        }
        header('Location: ' . BASEURL . '/admin');
        exit;
    }

    public function reject_mentor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['feedback'])) {
            $this->validateCsrf();
            $id = $_POST['id'];
            $feedback = $_POST['feedback'];
            
            if ($this->model('Admin_model')->rejectMentor($id, $feedback) > 0) {
                Flasher::setFlash('Mentor', 'Berhasil Ditolak dan Diberi Masukan', 'success');
            } else {
                Flasher::setFlash('Mentor', 'Gagal Ditolak', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/admin');
        exit;
    }

    public function add_skill()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            if ($this->model('Admin_model')->addSkill($_POST) > 0) {
                Flasher::setFlash('Keterampilan Baru', 'Berhasil Ditambahkan', 'success');
            } else {
                Flasher::setFlash('Keterampilan', 'Gagal Ditambahkan', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/admin');
        exit;
    }

    public function delete_skill($id)
    {
        if ($this->model('Admin_model')->deleteSkill($id) > 0) {
            Flasher::setFlash('Keterampilan', 'Berhasil Dihapus', 'success');
        } else {
            Flasher::setFlash('Keterampilan', 'Gagal Dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/admin');
        exit;
    }
}
