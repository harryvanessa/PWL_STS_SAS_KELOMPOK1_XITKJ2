<?php
$username  = htmlspecialchars($data['user']['username'] ?? '');
$fullName  = htmlspecialchars($data['profile']['full_name'] ?? '');
$email     = htmlspecialchars($data['profile']['email'] ?? '');
$phone     = htmlspecialchars($data['profile']['phone'] ?? '');
$address   = htmlspecialchars($data['profile']['address'] ?? '');
$initials  = strtoupper(substr($data['profile']['full_name'] ?? 'S', 0, 1));
?>

<div style="min-height: 100vh; padding: 2rem 1rem; display: flex; align-items: flex-start; justify-content: center;">
    <div style="width: 100%; max-width: 680px;">

        <!-- Page Title -->
        <div style="margin-bottom: 2rem;">
            <a href="<?= BASEURL ?>/student" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; margin-bottom: 1rem; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94a3b8'">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <h1 style="font-size: 1.75rem; font-weight: 700; color: #f1f5f9; margin: 0 0 0.25rem;">Profil Saya</h1>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Kelola informasi akun dan keamanan Anda</p>
        </div>

        <?php Flasher::flash(); ?>

        <form action="<?= BASEURL ?>/student/update_profile" method="post">

            <!-- ── KARTU: Identitas ────────────────────────────────── -->
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 1.25rem;">

                <!-- Avatar + Badge -->
                <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.75rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg,#3b82f6,#8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 700; color: #fff; flex-shrink: 0; box-shadow: 0 4px 16px rgba(59,130,246,0.3);">
                        <?= $initials ?>
                    </div>
                    <div>
                        <p style="font-size: 1.15rem; font-weight: 600; color: #f1f5f9; margin: 0 0 0.4rem;"><?= $fullName ?: 'Nama belum diisi' ?></p>
                        <span style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.35); color: #60a5fa; font-size: 0.8rem; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem;">
                            <i class="fa-solid fa-graduation-cap" style="font-size: 0.75rem;"></i> Siswa
                        </span>
                    </div>
                </div>

                <!-- Username (readonly) -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Username</label>
                    <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        <i class="fa-solid fa-at" style="color: #475569; font-size: 0.9rem;"></i>
                        <span style="color: #64748b; font-size: 0.95rem;"><?= $username ?></span>
                        <span style="margin-left: auto; font-size: 0.75rem; color: #475569; display: flex; align-items: center; gap: 0.3rem;"><i class="fa-solid fa-lock" style="font-size: 0.7rem;"></i> Tidak dapat diubah</span>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="full_name" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="<?= $fullName ?>" required placeholder="Masukkan nama lengkap..."
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                </div>

                <!-- Grid: Email + Telepon -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;" class="sp-grid">
                    <div>
                        <label for="email" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?>" required placeholder="email@contoh.com"
                            style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.15)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label for="phone" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">No. Telepon</label>
                        <input type="text" name="phone" id="phone" value="<?= $phone ?>" placeholder="08xxxxxxxxxx"
                            style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.15)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                    </div>
                </div>

                <!-- Alamat/Biodata -->
                <div>
                    <label for="address" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Alamat / Biodata</label>
                    <textarea name="address" id="address" rows="3" placeholder="Ceritakan tentang dirimu atau tulis alamat Anda..."
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; resize: vertical; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box; font-family: inherit;"
                        onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'"><?= $address ?></textarea>
                </div>
            </div>

            <!-- ── KARTU: Keamanan ─────────────────────────────────── -->
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-shield-halved" style="color: #f59e0b; font-size: 1.1rem;"></i>
                    <h3 style="margin: 0; font-size: 1.05rem; font-weight: 600; color: #f1f5f9;">Ganti Password</h3>
                </div>
                <p style="color: #64748b; font-size: 0.88rem; margin: 0 0 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.06);">Abaikan bagian ini jika Anda tidak ingin mengganti password.</p>

                <!-- Password Saat Ini -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="current_password" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" placeholder="Masukkan password yang sedang aktif..."
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                </div>

                <!-- Password Baru -->
                <div style="margin-bottom: 0.75rem;">
                    <label for="new_password" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" placeholder="Min. 8 karakter, huruf kapital, angka, simbol..."
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                </div>

                <!-- Strength Meter -->
                <div id="strength-wrapper" style="display: none; margin-bottom: 1.25rem;">
                    <div style="display: flex; gap: 5px; height: 5px; margin-bottom: 0.5rem;">
                        <div id="s1" style="flex:1; border-radius:3px; background:rgba(255,255,255,0.08); transition:0.3s;"></div>
                        <div id="s2" style="flex:1; border-radius:3px; background:rgba(255,255,255,0.08); transition:0.3s;"></div>
                        <div id="s3" style="flex:1; border-radius:3px; background:rgba(255,255,255,0.08); transition:0.3s;"></div>
                        <div id="s4" style="flex:1; border-radius:3px; background:rgba(255,255,255,0.08); transition:0.3s;"></div>
                    </div>
                    <p id="strength-label" style="font-size:0.82rem; color:#64748b; margin:0;"></p>
                </div>

                <!-- Konfirmasi Password Baru -->
                <div>
                    <label for="confirm_password" style="display: block; font-size: 0.82rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Ketik ulang password baru Anda..."
                        style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem 1rem; color: #f1f5f9; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)';this.style.boxShadow='none'">
                    <!-- Match feedback -->
                    <div id="match-ok"   style="display:none; margin-top:0.6rem; font-size:0.85rem; color:#10b981;"><i class="fa-solid fa-circle-check"></i> Password cocok</div>
                    <div id="match-fail" style="display:none; margin-top:0.6rem; font-size:0.85rem; color:#ef4444;"><i class="fa-solid fa-circle-xmark"></i> Password tidak cocok</div>
                </div>
            </div>

            <!-- ── TOMBOL AKSI ──────────────────────────────────────── -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="<?= BASEURL ?>/student"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.75rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.12); color: #94a3b8; text-decoration: none; font-size: 0.95rem; transition: 0.2s; background: transparent;"
                    onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.color='#fff'"
                    onmouseout="this.style.background='transparent';this.style.color='#94a3b8'">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" id="submit-btn"
                    style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.75rem 2rem; border-radius: 0.75rem; border: none; background: linear-gradient(135deg,#3b82f6,#2563eb); color: #fff; font-size: 0.95rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 15px rgba(59,130,246,0.35); transition: 0.2s;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@media (max-width: 600px) {
    .sp-grid { grid-template-columns: 1fr !important; }
}
</style>

<script>
const newPw  = document.getElementById('new_password');
const conPw  = document.getElementById('confirm_password');
const curPw  = document.getElementById('current_password');
const bars   = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
const label  = document.getElementById('strength-label');
const wrap   = document.getElementById('strength-wrapper');
const matchOk   = document.getElementById('match-ok');
const matchFail = document.getElementById('match-fail');

const LEVELS = [
    { color: '#ef4444', text: '🔴 Sangat Lemah — tambahkan lebih banyak karakter' },
    { color: '#f97316', text: '🟠 Lemah — gunakan huruf kapital atau angka' },
    { color: '#eab308', text: '🟡 Sedang — tambahkan simbol agar lebih kuat' },
    { color: '#22c55e', text: '🟢 Kuat — password sudah aman!' }
];

function getScore(pw) {
    let s = 0;
    if (pw.length >= 8) s++;
    if (/[A-Z]/.test(pw)) s++;
    if (/[0-9]/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw)) s++;
    return s;
}

newPw.addEventListener('input', function() {
    const val = this.value;
    if (!val) { wrap.style.display = 'none'; checkMatch(); return; }
    wrap.style.display = 'block';
    const score = getScore(val) - 1;
    const safe  = Math.max(0, Math.min(score, 3));
    bars.forEach((b, i) => {
        b.style.background = i <= safe ? LEVELS[safe].color : 'rgba(255,255,255,0.08)';
    });
    label.textContent = LEVELS[safe].text;
    label.style.color = LEVELS[safe].color;
    checkMatch();
});

conPw.addEventListener('input', checkMatch);

function checkMatch() {
    if (!conPw.value) { matchOk.style.display = 'none'; matchFail.style.display = 'none'; return; }
    if (newPw.value === conPw.value) {
        matchOk.style.display = 'block'; matchFail.style.display = 'none';
    } else {
        matchFail.style.display = 'block'; matchOk.style.display = 'none';
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    if (!newPw.value && !conPw.value && !curPw.value) return; // skip jika bagian password kosong semua
    if (!curPw.value) {
        e.preventDefault();
        alert('Masukkan password saat ini terlebih dahulu!');
        curPw.focus(); return;
    }
    if (!newPw.value) {
        e.preventDefault();
        alert('Masukkan password baru!');
        newPw.focus(); return;
    }
    if (newPw.value !== conPw.value) {
        e.preventDefault();
        alert('Konfirmasi password tidak cocok dengan password baru!');
        conPw.focus(); return;
    }
});
</script>
