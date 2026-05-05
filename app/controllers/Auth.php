<?php

class Auth extends Controller {
    private const LOCKOUT_LIMIT   = 5;
    private const LOCKOUT_SECONDS = 60;

    public function index()
    {
        if (isset($_SESSION['user'])) $this->redirectRole($_SESSION['user']['role']);

        $this->render('auth/login', ['judul' => 'Login']);
    }

    public function login()
    {
        if (!$this->isPost()) return $this->redirect('auth');

        $this->validateCsrf();
        $this->enforceRateLimit();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $user     = $this->model('User_model')->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'role'     => $user['role'],
            ];
            $this->redirectRole($user['role']);
        }

        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        usleep(500_000);
        $this->flashRedirect('Username atau Password', 'Salah', 'danger', 'auth');
    }

    public function register_student()
    {
        if ($this->isPost()) {
            $this->validateCsrf();
            $this->checkUsernameTaken($_POST['username'], 'auth/register_student');

            $ok = $this->model('User_model')->registerStudent($_POST);
            $ok > 0
                ? $this->flashRedirect('Pendaftaran Siswa', 'Berhasil! Pilih jurusanmu sebelum login.', 'success', 'auth/major_search')
                : $this->flashRedirect('Pendaftaran Siswa', 'Gagal. Coba lagi.', 'danger', 'auth/register_student');
        }

        $this->render('auth/register_student', ['judul' => 'Daftar Sebagai Siswa']);
    }

    public function major_search()
    {
        $majors = [
            'Design Grafis' => [
                'description' => 'Pelajari desain visual untuk branding, ilustrasi, dan konten digital.',
                'apps' => ['Figma', 'Canva', 'Photoshop'],
            ],
            'Web Development' => [
                'description' => 'Kuasai pembuatan website dan aplikasi web modern.',
                'apps' => ['VS Code', 'Git', 'Chrome DevTools'],
            ],
            'Digital Marketing' => [
                'description' => 'Pelajari strategi pemasaran online dan pengelolaan kampanye digital.',
                'apps' => ['Google Ads', 'Facebook Ads', 'Canva'],
            ],
            'Public Speaking' => [
                'description' => 'Tingkatkan kemampuan berbicara di depan umum dan presentasi yang percaya diri.',
                'apps' => ['Zoom', 'PowerPoint', 'Canva'],
            ],
        ];

        $selectedMajor = $_GET['major'] ?? '';
        $selectedApp = $_GET['app'] ?? '';

        if ($this->isPost()) {
            $this->validateCsrf();
            $major = $_POST['major'] ?? '';
            $app = $_POST['app'] ?? '';

            if (!isset($majors[$major])) {
                $this->flashRedirect('Pilihan Jurusan', 'Jurusan tidak valid. Silakan pilih kembali.', 'danger', 'auth/major_search');
            }

            if ($app !== '' && !in_array($app, $majors[$major]['apps'], true)) {
                $this->flashRedirect('Pilihan Aplikasi', 'Pilihan aplikasi tidak valid. Silakan pilih kembali.', 'danger', 'auth/major_search?major=' . urlencode($major));
            }

            Flasher::setFlash('Terima Kasih', 'Jurusan dan aplikasi berhasil dipilih. Silakan login untuk melanjutkan.', 'success');
            $this->redirect('auth');
        }

        $this->render('auth/major_search', [
            'judul' => 'Pencarian Jurusan',
            'majors' => $majors,
            'selectedMajor' => $selectedMajor,
            'selectedApp' => $selectedApp,
        ]);
    }

    public function register_mentor()
    {
        if ($this->isPost()) {
            $this->validateCsrf();
            $this->checkUsernameTaken($_POST['username'], 'auth/register_mentor');

            $ok = $this->model('User_model')->registerMentor($_POST);
            $ok > 0
                ? $this->flashRedirect('Pendaftaran Mentor Berhasil!', 'Silakan tunggu persetujuan Admin.', 'success', 'auth')
                : $this->flashRedirect('Pendaftaran Mentor', 'Gagal. Periksa kembali data Anda.', 'danger', 'auth/register_mentor');
        }

        $this->render('auth/register_mentor', [
            'judul'  => 'Daftar Sebagai Mentor',
            'skills' => $this->model('Skill_model')->getAllSkills(),
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect('auth');
    }

    // ─── Private Helpers ───────────────────────────────────────────────────────

    private function redirectRole($role)
    {
        $routes = ['admin' => 'admin', 'mentor' => 'mentor', 'student' => 'student'];
        $this->redirect($routes[$role] ?? 'auth');
    }

    private function checkUsernameTaken($username, $backPath)
    {
        if ($this->model('User_model')->isUsernameTaken($username)) {
            $this->flashRedirect(
                'Username "' . htmlspecialchars($username) . '"',
                'Sudah Digunakan. Coba username lain.',
                'danger',
                $backPath
            );
        }
    }

    private function enforceRateLimit()
    {
        $_SESSION['login_attempts']    ??= 0;
        $_SESSION['last_attempt_time'] ??= time();

        if ($_SESSION['login_attempts'] >= self::LOCKOUT_LIMIT) {
            $elapsed = time() - $_SESSION['last_attempt_time'];
            if ($elapsed < self::LOCKOUT_SECONDS) {
                $wait = self::LOCKOUT_SECONDS - $elapsed;
                $this->flashRedirect('Terlalu banyak percobaan', "Tunggu {$wait} detik lagi.", 'danger', 'auth');
            }
            $_SESSION['login_attempts'] = 0;
        }
    }
}
