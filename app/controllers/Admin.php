<?php

class Admin extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('auth');
        }
    }

    public function index()
    {
        $this->render('admin/index', [
            'judul'   => 'Dashboard Admin',
            'mentors' => $this->model('Admin_model')->getPendingMentors(),
            'skills'  => $this->model('Skill_model')->getAllSkills(),
        ]);
    }

    public function approve_mentor($id)
    {
        $this->model('Admin_model')->approveMentor($id) > 0
            ? Flasher::setFlash('Mentor', 'Berhasil Disetujui', 'success')
            : Flasher::setFlash('Mentor', 'Gagal Disetujui', 'danger');
        $this->redirect('admin');
    }

    public function reject_mentor()
    {
        if ($this->isPost() && isset($_POST['id'], $_POST['feedback'])) {
            $this->validateCsrf();
            $ok = $this->model('Admin_model')->rejectMentor($_POST['id'], $_POST['feedback']);
            $ok > 0
                ? Flasher::setFlash('Mentor', 'Berhasil Ditolak', 'success')
                : Flasher::setFlash('Mentor', 'Gagal Ditolak', 'danger');
        }
        $this->redirect('admin');
    }

    public function add_skill()
    {
        if ($this->isPost()) {
            $this->validateCsrf();
            $ok = $this->model('Admin_model')->addSkill($_POST);
            $ok > 0
                ? Flasher::setFlash('Keterampilan', 'Berhasil Ditambahkan', 'success')
                : Flasher::setFlash('Keterampilan', 'Gagal Ditambahkan', 'danger');
        }
        $this->redirect('admin');
    }

    public function delete_skill($id)
    {
        $this->model('Admin_model')->deleteSkill($id) > 0
            ? Flasher::setFlash('Keterampilan', 'Berhasil Dihapus', 'success')
            : Flasher::setFlash('Keterampilan', 'Gagal Dihapus', 'danger');
        $this->redirect('admin');
    }

    public function major_selections()
    {
        $this->render('admin/major_selections', [
            'judul' => 'Data Pilihan Jurusan Siswa',
            'major_selections' => $this->model('Major_model')->getAllMajorSelections(),
            'stats' => $this->model('Major_model')->getMajorSelectionStats(),
        ]);
    }
}
