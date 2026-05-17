<?php

class Student extends Controller
{
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
            'judul' => 'Dashboard Siswa',
            'profile' => $this->model('Student_model')->getStudentProfile($uid),
            'sessions' => $this->model('Student_model')->getStudentSessions($uid),
        ]);
    }

    public function questionnaire()
    {
        $this->render('student/questionnaire', ['judul' => 'Kuesioner Minat Bakat']);
    }

    public function submit_questionnaire()
    {
        if (!$this->isPost())
            return;

        $interest = 'Tertarik pada: ' . $_POST['q1'] . ' dan ' . $_POST['q2'];
        $this->model('Student_model')->updateInterest($_SESSION['user']['id'], $interest);

        $recommended = '';
        if ($_POST['q1'] === 'tech') {
            $recommended = 'Web Development';
        } elseif ($_POST['q1'] === 'creative') {
            $recommended = 'Desain Grafis';
        } elseif ($_POST['q1'] === 'speaking') {
            $recommended = 'Public Speaking';
        } else {
            $recommended = 'Desain Grafis'; // fallback
        }
        $this->redirect('student/select_skill?recommended=' . urlencode($recommended));
    }

    public function select_skill()
    {
        $all_skills = $this->model('Skill_model')->getAllSkills();
        $filtered_skills = array_filter($all_skills, function ($skill) {
            return !in_array($skill['name'], ['Bahasa Inggris', 'Digital Marketing']);
        });

        $major = $_GET['recommended'] ?? $_GET['major'] ?? null;
        $selectedApp = $_GET['app'] ?? null;
        $apps = [];
        if ($major) {
            $apps = $this->model('Skill_model')->getAppsByMajor($major);
        }

        $this->render('student/select_skill', [
            'judul' => 'Pilih Keterampilan',
            'skills' => $filtered_skills,
            'recommended' => $_GET['recommended'] ?? null,
            'major' => $major,
            'apps' => $apps,
            'selectedApp' => $selectedApp,
        ]);
    }

    public function gacha()
    {
        if (!$this->isPost() || empty($_POST['skill_id'])) {
            return $this->redirect('student/select_skill');
        }

        $skill_id = $_POST['skill_id'];
        $mentor_id = $_POST['mentor_id'] ?? null;
        $major = $_POST['major'] ?? null;
        $app = $_POST['app'] ?? null;

        // If returning from comments page, use the specific mentor. Otherwise, randomize.
        $mentor = $mentor_id
            ? $this->model('Student_model')->getMentorById($mentor_id, $skill_id)
            : $this->model('Student_model')->gachaMentor($skill_id);

        $this->render('student/gacha_result', [
            'judul' => 'Hasil Pencarian Mentor',
            'skill' => $this->model('Skill_model')->getSkillById($skill_id),
            'mentor' => $mentor,
            'major' => $major,
            'app' => $app,
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

    public function update_mentor_comment()
    {
        if (!$this->isPost()) return $this->redirect('student');

        $id = $_POST['comment_id'];
        $mentor_id = $_POST['mentor_id'];
        $skill_id = $_POST['skill_id'];
        $comment = trim($_POST['comment']);
        $student_id = $_SESSION['user']['id'];

        if (!empty($comment)) {
            $this->model('Student_model')->updateMentorComment($id, $student_id, htmlspecialchars($comment));
            Flasher::setFlash('Komentar', 'Berhasil diperbarui', 'success');
        }

        $this->redirect('student/mentor_comments/' . $mentor_id . '/' . $skill_id);
    }

    public function delete_mentor_comment($id, $mentor_id, $skill_id)
    {
        $student_id = $_SESSION['user']['id'];
        $ok = $this->model('Student_model')->deleteMentorComment($id, $student_id);
        
        $ok > 0
            ? Flasher::setFlash('Komentar', 'Berhasil dihapus', 'success')
            : Flasher::setFlash('Komentar', 'Gagal dihapus', 'danger');

        $this->redirect('student/mentor_comments/' . $mentor_id . '/' . $skill_id);
    }

    public function schedule()
    {
        if (!$this->isPost())
            return;

        $ok = $this->model('Student_model')->requestSession([
            'student_id' => $_SESSION['user']['id'],
            'mentor_id' => $_POST['mentor_user_id'],
            'skill_id' => $_POST['skill_id'],
            'session_date' => $_POST['session_date'],
            'notes' => $_POST['notes'],
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

    // ─── Profile Management ──────────────────────────────────────────────────────

    public function profile()
    {
        $uid = $_SESSION['user']['id'];
        
        $this->render('student/student_profile', [
            'judul'   => 'Pengaturan Profil',
            'user'    => $this->model('User_model')->getUserById($uid),
            'profile' => $this->model('Student_model')->getStudentProfile($uid)
        ]);
    }

    public function update_profile()
    {
        if (!$this->isPost()) {
            return $this->redirect('student/profile');
        }

        $uid = $_SESSION['user']['id'];

        // Update Biodata
        $this->model('Student_model')->updateProfile([
            'user_id'   => $uid,
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'address'   => trim($_POST['address'] ?? '')
        ]);

        // Update password if provided
        $current_pw = $_POST['current_password'] ?? '';
        $new_pw     = $_POST['new_password'] ?? '';
        $confirm_pw = $_POST['confirm_password'] ?? '';

        if (!empty($new_pw)) {
            if (empty($current_pw)) {
                Flasher::setFlash('Profil', 'Harap masukkan password saat ini untuk mengganti password', 'danger');
                return $this->redirect('student/profile');
            }
            if ($new_pw !== $confirm_pw) {
                Flasher::setFlash('Profil', 'Konfirmasi password baru tidak cocok', 'danger');
                return $this->redirect('student/profile');
            }

            $user = $this->model('User_model')->getUserById($uid);
            if (!password_verify($current_pw, $user['password'])) {
                Flasher::setFlash('Profil', 'Password saat ini salah', 'danger');
                return $this->redirect('student/profile');
            }

            $hashed = password_hash($new_pw, PASSWORD_DEFAULT);
            $this->model('User_model')->updatePassword($uid, $hashed);
            Flasher::setFlash('Profil', 'Biodata & Password Berhasil Diperbarui', 'success');
            return $this->redirect('student/profile');
        }

        Flasher::setFlash('Profil', 'Berhasil Diperbarui', 'success');
        $this->redirect('student/profile');
    }
}
