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
        $this->render('student/select_skill', [
            'judul'       => 'Pilih Keterampilan',
            'skills'      => $this->model('Skill_model')->getAllSkills(),
            'recommended' => $_GET['recommended'] ?? null,
        ]);
    }

    public function gacha()
    {
        if (!$this->isPost() || empty($_POST['skill_id'])) {
            return $this->redirect('student/select_skill');
        }

        $skill_id = $_POST['skill_id'];
        $this->render('student/gacha_result', [
            'judul'  => 'Hasil Pencarian Mentor',
            'skill'  => $this->model('Skill_model')->getSkillById($skill_id),
            'mentor' => $this->model('Student_model')->gachaMentor($skill_id),
        ]);
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
}
