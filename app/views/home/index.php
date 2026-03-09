<style>
/* Sections styling */
.section {
    padding: 5rem 0;
}

.section-title {
    font-size: 2.25rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 1rem;
}

.section-subtitle {
    text-align: center;
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 3.5rem;
}

.gradient-text {
    background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.feature-card {
    background: var(--glass-bg);
    backdrop-filter: blur(12px);
    border: 1px solid var(--glass-border);
    border-radius: 1.25rem;
    padding: 2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.feature-icon {
    width: 56px;
    height: 56px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1.25rem;
}

.step-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    position: relative;
}

.step-card {
    text-align: center;
    padding: 2rem 1.5rem;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1.25rem;
    backdrop-filter: blur(8px);
}

.step-number {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0 auto 1.25rem;
}

.testimonial-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.testimonial-card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1.25rem;
    padding: 2rem;
    backdrop-filter: blur(8px);
    position: relative;
}

.testimonial-card::before {
    content: '"';
    font-size: 5rem;
    line-height: 0;
    position: absolute;
    top: 2rem;
    right: 1.5rem;
    color: var(--primary-color);
    opacity: 0.3;
    font-family: Georgia, serif;
}

.cta-section {
    text-align: center;
    padding: 5rem 0;
    border-top: 1px solid var(--glass-border);
}

.divider {
    border: none;
    border-top: 1px solid var(--glass-border);
}
</style>

<!-- HERO SECTION -->
<div class="hero">
    <div class="container hero-content">
        <div class="zenith-badge">
            <i class="fa-solid fa-dice"></i> Sistem Gacha Mentor Pertama di Indonesia
        </div>
        <h1 class="hero-title">Temukan Mentor Terbaik Untuk Keterampilanmu</h1>
        <p class="hero-subtitle">Platform mentorship inovatif — jawab kuesioner, dapatkan rekomendasi skill, dan hubungkan dirimu dengan mentor yang tepat secara otomatis.</p>
        <div class="hero-actions">
            <?php if(!isset($_SESSION['user'])): ?>
                <a href="<?= BASEURL; ?>/auth/register_student" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Mulai Belajar Gratis</a>
                <a href="<?= BASEURL; ?>/auth/register_mentor" class="btn-secondary" style="padding: 1rem 2rem; font-size: 1.1rem;">Jadi Mentor</a>
            <?php else: ?>
                <?php if($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="<?= BASEURL; ?>/admin" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Dashboard Admin</a>
                <?php elseif($_SESSION['user']['role'] == 'student'): ?>
                    <a href="<?= BASEURL; ?>/student" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Cari Mentor Sekarang</a>
                <?php elseif($_SESSION['user']['role'] == 'mentor'): ?>
                    <a href="<?= BASEURL; ?>/mentor" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">Lihat Jadwal Saya</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- STATS SECTION -->
<div style="padding: 2rem 0; border-top: 1px solid var(--glass-border); border-bottom: 1px solid var(--glass-border);">
    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 2rem; text-align: center;">
        <div>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color);">100+</p>
            <p class="text-muted text-sm">Keterampilan Tersedia</p>
        </div>
        <div>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--secondary-color);">50+</p>
            <p class="text-muted text-sm">Mentor Berpengalaman</p>
        </div>
        <div>
            <p style="font-size: 2.5rem; font-weight: 800; color: #f59e0b;">200+</p>
            <p class="text-muted text-sm">Sesi Bimbingan Selesai</p>
        </div>
        <div>
            <p style="font-size: 2.5rem; font-weight: 800; color: #ec4899);">98%</p>
            <p class="text-muted text-sm">Siswa Puas</p>
        </div>
    </div>
</div>

<!-- FEATURES SECTION -->
<div class="container section">
    <h2 class="section-title"><span class="gradient-text">Mengapa Mentorku?</span></h2>
    <p class="section-subtitle">Kami menggabungkan teknologi cerdas dengan keahlian manusia untuk pengalaman belajar yang tak tertandingi.</p>
    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon" style="background: rgba(79,70,229,0.2); color: #818cf8;">
                <i class="fa-solid fa-dice"></i>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.75rem;">Gacha Mentor Cerdas</h3>
            <p class="text-muted text-sm">Jawab kuesioner minat, sistem kami akan secara otomatis mencocokkan kamu dengan mentor terbaik di bidangnya.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background: rgba(16,185,129,0.2); color: #34d399;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.75rem;">Jadwal Fleksibel</h3>
            <p class="text-muted text-sm">Pilih tanggal dan waktu yang cocok untukmu. Mentor mengkonfirmasi jadwal dan memberikan link meeting langsung di platform.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background: rgba(245,158,11,0.2); color: #fbbf24;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.75rem;">Chat Real-time</h3>
            <p class="text-muted text-sm">Diskusikan materi, kirim pertanyaan, dan berikan umpan balik langsung kepada mentor melalui fitur obrolan bawaan.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background: rgba(236,72,153,0.2); color: #f472b6;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 style="font-size: 1.2rem; margin-bottom: 0.75rem;">Mentor Terverifikasi</h3>
            <p class="text-muted text-sm">Setiap mentor melewati proses persetujuan oleh Admin sebelum bisa mengajar, memastikan kualitas bimbingan terjaga.</p>
        </div>
    </div>
</div>

<!-- HOW IT WORKS SECTION -->
<hr class="divider">
<div class="container section">
    <h2 class="section-title">Bagaimana Cara Kerjanya?</h2>
    <p class="section-subtitle">Proses yang simpel dari awal hingga sesi bimbinganmu dimulai.</p>
    <div class="step-grid">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Daftar & Isi Kuesioner</h3>
            <p class="text-muted text-sm">Buat akun siswa dan jawab pertanyaan singkat tentang minat dan tujuan belajarmu.</p>
        </div>
        <div class="step-card">
            <div class="step-number" style="background: var(--secondary-color);">2</div>
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Pilih Keterampilan</h3>
            <p class="text-muted text-sm">Sistem akan merekomendasikan keterampilan. Kamu bebas memilih sesuai rekomendasinya, atau memilih yang lain.</p>
        </div>
        <div class="step-card">
            <div class="step-number" style="background: #f59e0b;">3</div>
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Gacha Mentormu!</h3>
            <p class="text-muted text-sm">Tekan tombol, dan sistem akan mencarikan 1 mentor yang spesialis di bidangmu secara otomatis.</p>
        </div>
        <div class="step-card">
            <div class="step-number" style="background: #ec4899;">4</div>
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Mulai Bimbingan</h3>
            <p class="text-muted text-sm">Ajukan jadwal, mentor konfirmasi dengan link meeting, dan mulailah sesi bimbinganmu!</p>
        </div>
    </div>
</div>

<!-- TESTIMONIALS SECTION -->
<hr class="divider">
<div class="container section">
    <h2 class="section-title">Kata Mereka</h2>
    <p class="section-subtitle">Cerita sukses dari pengguna platform Mentorku.</p>
    <div class="testimonial-grid">
        <div class="testimonial-card">
            <p class="text-sm" style="line-height: 1.7; margin-bottom: 1.25rem; color: #cbd5e1;">"Awalnya bingung mau belajar apa, tapi setelah mengisi kuesioner dan dapat rekomendasi Web Dev, saya langsung cocok sama mentor yang diberikan. Sesi pertama sangat membantu!"</p>
            <div style="display:flex; align-items: center; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4f46e5, #818cf8); display: flex; align-items: center; justify-content: center; font-weight: 700;">A</div>
                <div><p style="font-weight: 600; font-size: 0.9rem; margin: 0;">Andi Pratama</p><p class="text-muted" style="font-size: 0.75rem; margin: 0;">Siswa — Web Development</p></div>
            </div>
        </div>
        <div class="testimonial-card">
            <p class="text-sm" style="line-height: 1.7; margin-bottom: 1.25rem; color: #cbd5e1;">"Fitur gacha mentornya unik banget! Saya dapat mentor yang super sabar dan profesional. Proses dari daftar sampai sesi pertama sangat mulus dan tidak ribet."</p>
            <div style="display:flex; align-items: center; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #34d399); display: flex; align-items: center; justify-content: center; font-weight: 700;">S</div>
                <div><p style="font-weight: 600; font-size: 0.9rem; margin: 0;">Siska Ayu</p><p class="text-muted" style="font-size: 0.75rem; margin: 0;">Siswa — Desain Grafis</p></div>
            </div>
        </div>
        <div class="testimonial-card">
            <p class="text-sm" style="line-height: 1.7; margin-bottom: 1.25rem; color: #cbd5e1;">"Sebagai mentor, platform ini memudahkan saya mengatur jadwal dengan murid. Link Zoom langsung bisa saya masukkan saat konfirmasi, sangat praktis dan profesional."</p>
            <div style="display:flex; align-items: center; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #fbbf24); display: flex; align-items: center; justify-content: center; font-weight: 700;">B</div>
                <div><p style="font-weight: 600; font-size: 0.9rem; margin: 0;">Budi Santoso</p><p class="text-muted" style="font-size: 0.75rem; margin: 0;">Mentor — Public Speaking</p></div>
            </div>
        </div>
    </div>
</div>

<!-- CTA SECTION -->
<?php if(!isset($_SESSION['user'])): ?>
<div class="cta-section">
    <div class="container">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;"><span class="gradient-text">Siap Memulai Perjalananmu?</span></h2>
        <p class="text-muted" style="margin-bottom: 2rem;">Bergabung sekarang dan temukan mentor yang tepat untuk mengembangkan dirimu.</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="<?= BASEURL; ?>/auth/register_student" class="btn-primary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Daftar Sebagai Siswa</a>
            <a href="<?= BASEURL; ?>/auth/register_mentor" class="btn-secondary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">Daftar Sebagai Mentor</a>
        </div>
    </div>
</div>
<?php endif; ?>
