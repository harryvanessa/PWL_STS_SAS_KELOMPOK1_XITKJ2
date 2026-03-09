<?php

class Student extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard Siswa';
        $data['profile'] = $this->model('Student_model')->getStudentProfile($_SESSION['user']['id']);
        $data['sessions'] = $this->model('Student_model')->getStudentSessions($_SESSION['user']['id']);

        $this->view('templates/header', $data);
        $this->view('student/index', $data);
        $this->view('templates/footer');
    }

    public function questionnaire()
    {
        $data['judul'] = 'Kuesioner Minat Bakat';
        $this->view('templates/header', $data);
        $this->view('student/questionnaire', $data);
        $this->view('templates/footer');
    }

    public function submit_questionnaire()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $interest_score = 0;
            if ($_POST['q1'] == 'tech') $interest_score += 10;
            if ($_POST['q2'] == 'creative') $interest_score -= 10;
            
            $interest = "Tertarik pada: " . $_POST['q1'] . " dan " . $_POST['q2'];
            $this->model('Student_model')->updateInterest($_SESSION['user']['id'], $interest);
            
            header('Location: ' . BASEURL . '/student/select_skill?recommended=' . ($_POST['q1'] == 'tech' ? 'Web Development' : 'Desain Grafis'));
            exit;
        }
    }

    public function select_skill()
    {
        $data['judul'] = 'Pilih Keterampilan';
        $data['skills'] = $this->model('Skill_model')->getAllSkills();
        $data['recommended'] = isset($_GET['recommended']) ? $_GET['recommended'] : null;

        $this->view('templates/header', $data);
        $this->view('student/select_skill', $data);
        $this->view('templates/footer');
    }

    public function gacha()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['skill_id'])) {
            $skill_id = $_POST['skill_id'];
            $skill = $this->model('Skill_model')->getSkillById($skill_id);
            $mentor = $this->model('Student_model')->gachaMentor($skill_id);

            $data['judul'] = 'Hasil Pencarian Mentor';
            $data['skill'] = $skill;
            $data['mentor'] = $mentor;

            $this->view('templates/header', $data);
            $this->view('student/gacha_result', $data);
            $this->view('templates/footer');
        } else {
            header('Location: ' . BASEURL . '/student/select_skill');
        }
    }

    public function schedule()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionData = [
                'student_id' => $_SESSION['user']['id'],
                'mentor_id' => $_POST['mentor_user_id'],
                'skill_id' => $_POST['skill_id'],
                'session_date' => $_POST['session_date'],
                'notes' => $_POST['notes']
            ];

            if ($this->model('Student_model')->requestSession($sessionData) > 0) {
                Flasher::setFlash('Jadwal Sesi', 'Berhasil Diajukan', 'success');
            } else {
                Flasher::setFlash('Jadwal Sesi', 'Gagal Diajukan', 'danger');
            }
            header('Location: ' . BASEURL . '/student');
            exit;
        }
    }

    public function chat($session_id)
    {
        header('Location: ' . BASEURL . '/chat/session/' . $session_id);
        exit;
    }
}
