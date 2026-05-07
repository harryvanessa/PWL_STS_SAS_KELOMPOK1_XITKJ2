<?php

class Admin extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('auth');
        }
    }

    // ─── Dashboard ──────────────────────────────────────────────
    public function index()
    {
        $this->render('admin/index', [
            'judul'           => 'Dashboard Admin',
            'mentors'         => $this->model('Admin_model')->getPendingMentors(),
            'approved_mentors'=> $this->model('Admin_model')->getApprovedMentors(),
            'skills'          => $this->model('Skill_model')->getAllSkills(),
            'csrf_token'      => $_SESSION['csrf_token'] ?? '',
        ]);
    }

    // ─── Approve / Reject ───────────────────────────────────────
    public function approve_mentor($id)
    {
        $this->model('Admin_model')->approveMentor($id) > 0
            ? Flasher::setFlash('Mentor', 'Berhasil Disetujui — Mentor kini aktif', 'success')
            : Flasher::setFlash('Mentor', 'Gagal Disetujui', 'danger');
        $this->redirect('admin');
    }

    public function reject_mentor()
    {
        if ($this->isPost() && isset($_POST['id'], $_POST['feedback'])) {
            $this->validateCsrf();
            $this->model('Admin_model')->rejectMentor($_POST['id'], $_POST['feedback']) > 0
                ? Flasher::setFlash('Mentor', 'Berhasil Ditolak', 'success')
                : Flasher::setFlash('Mentor', 'Gagal Ditolak', 'danger');
        }
        $this->redirect('admin');
    }

    // ─── Skill Management ───────────────────────────────────────
    public function add_skill()
    {
        if ($this->isPost()) {
            $this->validateCsrf();
            $this->model('Admin_model')->addSkill($_POST) > 0
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

    // ─── Mentor Profile (Full Admin Control) ────────────────────
    public function mentor_profile($id)
    {
        $mentor = $this->model('Admin_model')->getMentorById($id);
        if (!$mentor) {
            Flasher::setFlash('Mentor', 'Profil tidak ditemukan', 'danger');
            $this->redirect('admin');
        }

        $this->render('admin/mentor_profile', [
            'judul'    => 'Profil Mentor — ' . $mentor['full_name'],
            'mentor'   => $mentor,
            'comments' => $this->model('Admin_model')->getMentorComments($mentor['user_id']),
            'skills'   => $this->model('Skill_model')->getAllSkills(),
        ]);
    }

    public function dismiss_mentor($id)
    {
        $this->model('Admin_model')->deleteMentor($id) > 0
            ? Flasher::setFlash('Mentor', 'Mentor berhasil diberhentikan', 'success')
            : Flasher::setFlash('Mentor', 'Gagal memberhentikan mentor', 'danger');
        $this->redirect('admin');
    }

    public function update_mentor_skill()
    {
        if ($this->isPost() && isset($_POST['id'], $_POST['skill_id'])) {
            $this->model('Admin_model')->updateMentorSkill($_POST['id'], $_POST['skill_id']) > 0
                ? Flasher::setFlash('Keahlian', 'Keahlian mentor berhasil diubah', 'success')
                : Flasher::setFlash('Keahlian', 'Gagal mengubah keahlian', 'danger');
            $this->redirect('admin/mentor_profile/' . $_POST['id']);
            return;
        }
        $this->redirect('admin');
    }

    // ─── Comment Management ─────────────────────────────────────
    public function add_mentor_comment()
    {
        if ($this->isPost() && isset($_POST['mentor_user_id'], $_POST['comment'], $_POST['mentor_profile_id'])) {
            $admin_id = $_SESSION['user']['id'];
            $this->model('Admin_model')->addMentorComment(
                $_POST['mentor_user_id'],
                $admin_id,
                trim($_POST['comment'])
            ) > 0
                ? Flasher::setFlash('Komentar', 'Komentar admin berhasil ditambahkan', 'success')
                : Flasher::setFlash('Komentar', 'Gagal menambahkan komentar', 'danger');
            $this->redirect('admin/mentor_profile/' . $_POST['mentor_profile_id']);
            return;
        }
        $this->redirect('admin');
    }

    public function edit_mentor_comment()
    {
        if ($this->isPost() && isset($_POST['comment_id'], $_POST['comment'], $_POST['mentor_profile_id'])) {
            $this->model('Admin_model')->updateMentorComment($_POST['comment_id'], trim($_POST['comment'])) > 0
                ? Flasher::setFlash('Komentar', 'Komentar berhasil diperbarui', 'success')
                : Flasher::setFlash('Komentar', 'Gagal memperbarui komentar', 'danger');
            $this->redirect('admin/mentor_profile/' . $_POST['mentor_profile_id']);
            return;
        }
        $this->redirect('admin');
    }

    public function delete_mentor_comment($comment_id, $mentor_profile_id)
    {
        $this->model('Admin_model')->deleteMentorComment($comment_id) > 0
            ? Flasher::setFlash('Komentar', 'Komentar berhasil dihapus', 'success')
            : Flasher::setFlash('Komentar', 'Gagal menghapus komentar', 'danger');
        $this->redirect('admin/mentor_profile/' . $mentor_profile_id);
    }

    // ─── Major Selections ───────────────────────────────────────
    public function major_selections()
    {
        $this->render('admin/major_selections', [
            'judul'            => 'Data Pilihan Jurusan Siswa',
            'major_selections' => $this->model('Major_model')->getAllMajorSelections(),
            'stats'            => $this->model('Major_model')->getMajorSelectionStats(),
        ]);
    }

}
