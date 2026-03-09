<div class="container auth-container">
    <div class="glass-card" style="max-width: 600px;">
        <h2 class="card-title">Kuesioner Minat & Bakat</h2>
        <p class="text-center text-muted" style="margin-bottom: 2rem;">Jawab dua pertanyaan simpel ini agar kami bisa merekomendasikan bidang yang sesuai untukmu.</p>

        <form action="<?= BASEURL; ?>/student/submit_questionnaire" method="post">
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem;">1. Apa yang lebih kamu suka lakukan di waktu luang?</label>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 1rem;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q1" value="tech" required> Membongkar gadget atau belajar coding
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q1" value="creative" required> Menggambar, mendesain, atau membuat karya visual
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q1" value="speaking" required> Berdebat, presentasi, atau public speaking
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem;">2. Jika kamu diminta memecahkan masalah, bagaimana caramu?</label>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 1rem;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q2" value="logical" required> Melalui pendekatan logika dan data
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q2" value="intuitive" required> Melalui intuisi dan pendekatan visual
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;">
                        <input type="radio" name="q2" value="communication" required> Berkomunikasi dengan orang lain
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary btn-block" style="font-size: 1.1rem; padding: 1rem;">Kirim & Lihat Hasil</button>
        </form>
    </div>
</div>
