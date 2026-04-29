<div class="container" style="padding-bottom: 4rem;">
    <!-- Header -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Catatan Jurusan</h1>
            <p style="color: var(--text-muted);">Kelola catatan belajar Anda berdasarkan jurusan. Maksimal 5 catatan per jurusan.</p>
        </div>
    </div>

    <!-- Controls -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 250px;">
            <select id="majorSelect" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid var(--border-color, rgba(255,255,255,0.1)); color: inherit; font-family: inherit; font-size: 1rem; outline: none; cursor: pointer;">
                <option value="Web Development" style="color: #000;">Web Development</option>
                <option value="Desain Grafis" style="color: #000;">Desain Grafis</option>
                <option value="Digital Marketing" style="color: #000;">Digital Marketing</option>
                <option value="Bahasa Inggris" style="color: #000;">Bahasa Inggris</option>
                <option value="Public Speaking" style="color: #000;">Public Speaking</option>
            </select>
        </div>
        <button id="addNoteBtn" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;">
            <i class="fa-solid fa-plus"></i> Tambah Catatan
        </button>
    </div>

    <div id="notesStatus" style="margin-bottom: 1.5rem; font-size: 0.95rem; color: var(--text-muted);">
        Menampilkan catatan untuk jurusan <strong id="currentMajorLabel" style="color: inherit;">Web Development</strong> (<span id="noteCount">0</span>/5)
    </div>

    <!-- Notes Grid -->
    <div id="notesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Notes will be injected here via JS -->
    </div>
</div>

<!-- Modal Add/Edit Note -->
<div id="noteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 5000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="glass-card" style="width: 100%; max-width: 500px; margin: 0; position: relative;">
        <button onclick="closeModal()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='inherit'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 id="modalTitle" class="card-title" style="font-size: 1.5rem; margin-bottom: 1.5rem;">Tambah Catatan</h2>
        
        <input type="hidden" id="noteId">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Judul Catatan</label>
            <input type="text" id="noteTitle" placeholder="Misal: Rangkuman Jaringan Dasar" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='rgba(255,255,255,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'" required>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Isi Catatan</label>
            <textarea id="noteContent" rows="6" placeholder="Tulis detail catatan Anda di sini..." style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; resize: vertical; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='rgba(255,255,255,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'" required></textarea>
        </div>
        
        <button onclick="saveNote()" class="btn-primary" style="width: 100%; padding: 0.75rem; border: none; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
            <i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> Simpan Catatan
        </button>
    </div>
</div>
