<?php

class Auth extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_SESSION['user'])) {
            // Redirect based on role
            $this->redirectRole($_SESSION['user']['role']);
        }

        $data['judul'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('auth/login', $data);
        $this->view('templates/footer');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();

            // --- ANTI-CRACK / BRUTE FORCE PROTECTION ---
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_attempt_time'] = time();
            }

            // Check if locked out (5 attempts, 1 minute lockout)
            $lockout_time = 60; // 60 seconds
            if ($_SESSION['login_attempts'] >= 5) {
                $time_passed = time() - $_SESSION['last_attempt_time'];
                if ($time_passed < $lockout_time) {
                    $wait = $lockout_time - $time_passed;
                    Flasher::setFlash('Terlalu banyak percobaan', 'Silakan tunggu ' . $wait . ' detik lagi.', 'danger');
                    header('Location: ' . BASEURL . '/auth');
                    exit;
                } else {
                    // Reset after lockout time passed
                    $_SESSION['login_attempts'] = 0;
                }
            }
            // -------------------------------------------

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model('User_model')->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Success: Reset attempts
                $_SESSION['login_attempts'] = 0;
                
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $this->redirectRole($user['role']);
            } else {
                // Failure: Increment attempts and add delay
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt_time'] = time();
                
                // Slow down automated attacks
                usleep(500000); // 0.5 second delay

                Flasher::setFlash('Username atau Password', 'Salah', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            header('Location: ' . BASEURL . '/auth');
        }
    }

    public function register_student()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();

            // Cek apakah username sudah dipakai
            if ($this->model('User_model')->isUsernameTaken($_POST['username'])) {
                Flasher::setFlash('Username "' . htmlspecialchars($_POST['username']) . '"', 'Sudah Digunakan. Coba username lain.', 'danger');
                header('Location: ' . BASEURL . '/auth/register_student');
                exit;
            }

            $result = $this->model('User_model')->registerStudent($_POST);
            if ($result > 0) {
                Flasher::setFlash('Pendaftaran Siswa', 'Berhasil! Silakan login.', 'success');
                header('Location: ' . BASEURL . '/auth');
                exit;
            } else {
                Flasher::setFlash('Pendaftaran Siswa', 'Gagal. Coba lagi.', 'danger');
                header('Location: ' . BASEURL . '/auth/register_student');
                exit;
            }
        }
        $data['judul'] = 'Daftar Sebagai Siswa';
        $this->view('templates/header', $data);
        $this->view('auth/register_student', $data);
        $this->view('templates/footer');
    }

    public function register_mentor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();

            // Cek apakah username sudah dipakai
            if ($this->model('User_model')->isUsernameTaken($_POST['username'])) {
                Flasher::setFlash('Username "' . htmlspecialchars($_POST['username']) . '"', 'Sudah Digunakan. Coba username lain.', 'danger');
                header('Location: ' . BASEURL . '/auth/register_mentor');
                exit;
            }

            $result = $this->model('User_model')->registerMentor($_POST);
            if ($result > 0) {
                Flasher::setFlash('Pendaftaran Mentor Berhasil!', 'Silakan tunggu persetujuan Admin.', 'success');
                header('Location: ' . BASEURL . '/auth');
                exit;
            } else {
                Flasher::setFlash('Pendaftaran Mentor', 'Gagal. Periksa kembali data Anda.', 'danger');
                header('Location: ' . BASEURL . '/auth/register_mentor');
                exit;
            }
        }
        
        $data['judul'] = 'Daftar Sebagai Mentor';
        $data['skills'] = $this->model('Skill_model')->getAllSkills();
        $this->view('templates/header', $data);
        $this->view('auth/register_mentor', $data);
        $this->view('templates/footer');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }

    private function redirectRole($role)
    {
        if ($role == 'admin') {
            header('Location: ' . BASEURL . '/admin');
            exit;
        } elseif ($role == 'mentor') {
            header('Location: ' . BASEURL . '/mentor');
            exit;
        } elseif ($role == 'student') {
            header('Location: ' . BASEURL . '/student');
            exit;
        }
    }
}
