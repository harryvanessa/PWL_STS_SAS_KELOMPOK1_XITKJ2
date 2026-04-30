<?php

class Student extends Controller {
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
            $this->redirect('auth');
        }
    }

    public function index()
    {
        $uid = $_SESSION['user']['id'];
        $this->render('student/index', [
            'judul'    => 'Dashboard Siswa',
            'profile'  => $this->model('Student_model')->getStudentProfile($uid),
            'sessions' => $this->model('Student_model')->getStudentSessions($uid),
        ]);
    }

    public function questionnaire()
    {
        $this->render('student/questionnaire', ['judul' => 'Kuesioner Minat Bakat']);
    }

    public function submit_questionnaire()
    {
        if (!$this->isPost()) return;

        $interest = 'Tertarik pada: ' . $_POST['q1'] . ' dan ' . $_POST['q2'];
        $this->model('Student_model')->updateInterest($_SESSION['user']['id'], $interest);

        $recommended = $_POST['q1'] === 'tech' ? 'Web Development' : 'Desain Grafis';
        $this->redirect('student/select_skill?recommended=' . urlencode($recommended));
    }

    public function select_skill()
    {
        $all_skills = $this->model('Skill_model')->getAllSkills();
        $filtered_skills = array_filter($all_skills, function($skill) {
            return !in_array($skill['name'], ['Bahasa Inggris', 'Digital Marketing']);
        });

        $this->render('student/select_skill', [
            'judul'       => 'Pilih Keterampilan',
            'skills'      => $filtered_skills,
            'recommended' => $_GET['recommended'] ?? null,
        ]);
    }

    public function gacha()
    {
        if (!$this->isPost() || empty($_POST['skill_id'])) {
            return $this->redirect('student/select_skill');
        }

        $skill_id = $_POST['skill_id'];
        $mentor_id = $_POST['mentor_id'] ?? null;

        // If returning from comments page, use the specific mentor. Otherwise, randomize.
        $mentor = $mentor_id 
            ? $this->model('Student_model')->getMentorById($mentor_id, $skill_id)
            : $this->model('Student_model')->gachaMentor($skill_id);

        $this->render('student/gacha_result', [
            'judul'  => 'Hasil Pencarian Mentor',
            'skill'  => $this->model('Skill_model')->getSkillById($skill_id),
            'mentor' => $mentor,
        ]);
    }

    public function mentor_comments($mentor_id, $skill_id)
    {
        $mentor = $this->model('Student_model')->getMentorById($mentor_id, $skill_id);
        if (!$mentor) return $this->redirect('student/select_skill');

        $this->render('student/mentor_comments', [
            'judul'    => 'Komentar Mentor',
            'mentor'   => $mentor,
            'skill_id' => $skill_id,
            'comments' => $this->model('Student_model')->getMentorComments($mentor_id),
        ]);
    }

    public function post_mentor_comment()
    {
        if (!$this->isPost()) {
            return $this->redirect('student');
        }

        $mentor_id = $_POST['mentor_id'];
        $skill_id  = $_POST['skill_id'];
        $comment   = trim($_POST['comment']);

        if (!empty($comment)) {
            $this->model('Student_model')->addMentorComment([
                'mentor_user_id'  => $mentor_id,
                'student_user_id' => $_SESSION['user']['id'],
                'comment'         => htmlspecialchars($comment)
            ]);
        }
        
        $this->redirect('student/mentor_comments/' . $mentor_id . '/' . $skill_id);
    }

    public function schedule()
    {
        if (!$this->isPost()) return;

        $ok = $this->model('Student_model')->requestSession([
            'student_id'   => $_SESSION['user']['id'],
            'mentor_id'    => $_POST['mentor_user_id'],
            'skill_id'     => $_POST['skill_id'],
            'session_date' => $_POST['session_date'],
            'notes'        => $_POST['notes'],
        ]);

        $ok > 0
            ? Flasher::setFlash('Jadwal Sesi', 'Berhasil Diajukan', 'success')
            : Flasher::setFlash('Jadwal Sesi', 'Gagal Diajukan', 'danger');
        $this->redirect('student');
    }

    public function chat($session_id)
    {
        $this->redirect('chat/session/' . $session_id);
    }

    // ─── Skill Exchange ────────────────────────────────────────────────────────

    public function skill_exchange()
    {
        $uid = $_SESSION['user']['id'];
        $em  = $this->model('Exchange_model');

        $this->render('student/skill_exchange', [
            'judul'    => 'Pertukaran Keterampilan',
            'skills'   => $this->model('Skill_model')->getAllSkills(),
            'listings' => $em->getAllStudentSkills($uid),
            'my_skills'=> $em->getMySkills($uid),
            'incoming' => $em->getIncomingRequests($uid),
            'outgoing' => $em->getOutgoingRequests($uid),
        ]);
    }

    public function skill_detail($id)
    {
        $skill = $this->model('Exchange_model')->getStudentSkillDetail($id);
        if (!$skill) return $this->redirect('student/skill_exchange');

        $this->render('student/skill_detail', [
            'judul' => 'Detail Keterampilan',
            'skill' => $skill,
        ]);
    }

    public function add_skill()
    {
        if (!$this->isPost()) return $this->redirect('student/skill_exchange');
        $this->validateCsrf();

        $ok = $this->model('Exchange_model')->addStudentSkill([
            'student_id'  => $_SESSION['user']['id'],
            'skill_id'    => $_POST['skill_id'],
            'level'       => $_POST['level'],
            'description' => $_POST['description'],
        ]);

        $ok > 0
            ? $this->flashRedirect('Keterampilan', 'Berhasil Ditambahkan!', 'success', 'student/skill_exchange')
            : $this->flashRedirect('Keterampilan', 'Gagal Ditambahkan.', 'danger', 'student/skill_exchange');
    }

    public function delete_skill($id)
    {
        $ok = $this->model('Exchange_model')->deleteStudentSkill($id, $_SESSION['user']['id']);
        $ok > 0
            ? Flasher::setFlash('Keterampilan', 'Berhasil Dihapus', 'success')
            : Flasher::setFlash('Keterampilan', 'Gagal Dihapus', 'danger');
        $this->redirect('student/skill_exchange');
    }

    public function request_exchange()
    {
        if (!$this->isPost()) return $this->redirect('student/skill_exchange');
        $this->validateCsrf();

        $uid = $_SESSION['user']['id'];
        $em  = $this->model('Exchange_model');

        // Prevent duplicate requests
        if ($em->hasExistingRequest($uid, $_POST['student_skill_id'])) {
            return $this->flashRedirect('Permintaan', 'Sudah ada permintaan yang sedang menunggu untuk skill ini.', 'danger', 'student/skill_detail/' . $_POST['student_skill_id']);
        }

        $ok = $em->requestExchange([
            'requester_id'     => $uid,
            'provider_id'      => $_POST['provider_id'],
            'student_skill_id' => $_POST['student_skill_id'],
            'message'          => $_POST['message'] ?? '',
        ]);

        $ok > 0
            ? $this->flashRedirect('Permintaan Pertukaran', 'Berhasil Dikirim!', 'success', 'student/skill_exchange')
            : $this->flashRedirect('Permintaan Pertukaran', 'Gagal Dikirim.', 'danger', 'student/skill_exchange');
    }

    public function respond_exchange()
    {
        if (!$this->isPost()) return $this->redirect('student/skill_exchange');
        $this->validateCsrf();

        $status = $_POST['action'] === 'accept' ? 'accepted' : 'rejected';
        $ok = $this->model('Exchange_model')->updateExchangeStatus($_POST['id'], $_SESSION['user']['id'], $status);

        $ok > 0
            ? Flasher::setFlash('Permintaan', $status === 'accepted' ? 'Diterima!' : 'Ditolak.', 'success')
            : Flasher::setFlash('Permintaan', 'Gagal diperbarui.', 'danger');
        $this->redirect('student/skill_exchange');
    }
}
