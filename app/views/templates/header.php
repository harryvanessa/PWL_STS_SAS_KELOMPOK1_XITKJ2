<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - PWL Mentorship</title>
    <!-- Google Fonts for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <a href="<?= BASEURL; ?>" class="brand-logo">
            <i class="fa-solid fa-graduation-cap"></i> <span class="brand-text">Mentorku</span>
        </a>
        <div class="nav-links">
            <?php if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="<?= BASEURL; ?>/admin" class="nav-link">Dashboard Admin</a>
                <?php elseif($_SESSION['user']['role'] == 'student'): ?>
                    <a href="<?= BASEURL; ?>/student" class="nav-link">Dashboard Siswa</a>
                <?php elseif($_SESSION['user']['role'] == 'mentor'): ?>
                    <a href="<?= BASEURL; ?>/mentor" class="nav-link">Dashboard Mentor</a>
                <?php endif; ?>
                <a href="<?= BASEURL; ?>/auth/logout" class="nav-link btn-logout">Logout</a>
            <?php else: ?>
                <a href="<?= BASEURL; ?>/auth" class="nav-link btn-login">Login</a>
                <a href="<?= BASEURL; ?>/auth/register_student" class="nav-link btn-primary">Daftar Siswa</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="main-content">
