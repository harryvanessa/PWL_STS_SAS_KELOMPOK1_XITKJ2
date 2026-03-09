<style>
.chat-wrapper {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 12rem);
}

.chat-header-box {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    backdrop-filter: blur(12px);
}

.chat-body {
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.5rem;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 1rem;
    backdrop-filter: blur(12px);
    margin-bottom: 1rem;
}

.chat-bubble {
    display: flex;
    flex-direction: column;
    max-width: 70%;
}

.chat-bubble.me {
    align-self: flex-end;
    align-items: flex-end;
}

.chat-bubble.other {
    align-self: flex-start;
    align-items: flex-start;
}

.bubble-name {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.bubble-text {
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    font-size: 0.9rem;
    line-height: 1.5;
    word-wrap: break-word;
    max-width: 100%;
}

.me .bubble-text {
    background: var(--primary-color);
    color: white;
    border-bottom-right-radius: 0.25rem;
}

.other .bubble-text {
    background: rgba(255,255,255,0.08);
    color: var(--text-main);
    border-bottom-left-radius: 0.25rem;
}

.bubble-time {
    font-size: 0.65rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.chat-input-form {
    display: flex;
    gap: 0.75rem;
    align-items: flex-end;
}

.chat-input-form textarea {
    flex: 1;
    resize: none;
    min-height: 50px;
}

.chat-input-form button {
    padding: 0.75rem 1.25rem;
    flex-shrink: 0;
    align-self: flex-end;
}
</style>

<div class="container" style="padding-top: 1rem;">
    <div class="chat-wrapper">
        <!-- Header -->
        <div class="chat-header-box">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">
                    <i class="fa-regular fa-comment-dots" style="color: var(--primary-color);"></i>
                    Diskusi Sesi — <?= htmlspecialchars($data['session']['skill_name']); ?>
                </h2>
                <p class="text-sm text-muted" style="margin-top: 0.25rem;">
                    <?= date('d M Y, H:i', strtotime($data['session']['session_date'])); ?> · dengan @<?= htmlspecialchars($data['partner_name']); ?>
                </p>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <?php if(!empty($data['session']['meeting_link']) && $data['session']['status'] == 'confirmed'): ?>
                    <a href="<?= htmlspecialchars($data['session']['meeting_link']); ?>" target="_blank" class="btn-small btn-success" style="white-space: nowrap;">
                        <i class="fa-solid fa-video"></i> Masuk Meeting
                    </a>
                <?php endif; ?>
                <a href="<?= $data['back_url']; ?>" class="btn-small btn-secondary">← Kembali</a>
            </div>
        </div>

        <!-- Chat Body -->
        <div class="chat-body" id="chatBody">
            <?php if(empty($data['messages'])): ?>
                <div style="text-align: center; margin: auto;">
                    <p style="font-size: 2rem;">💬</p>
                    <p class="text-muted text-sm">Belum ada pesan. Mulai diskusi sekarang!</p>
                </div>
            <?php endif; ?>
            <?php foreach($data['messages'] as $msg): ?>
                <div class="chat-bubble <?= ($msg['sender_id'] == $data['current_user_id']) ? 'me' : 'other'; ?>">
                    <span class="bubble-name">
                        <?= ($msg['sender_id'] == $data['current_user_id']) ? 'Kamu' : '@' . htmlspecialchars($msg['username']); ?>
                    </span>
                    <div class="bubble-text"><?= nl2br(htmlspecialchars($msg['message'])); ?></div>
                    <span class="bubble-time"><?= date('d M, H:i', strtotime($msg['created_at'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Input Box -->
        <form action="<?= BASEURL; ?>/chat/send" method="post" class="chat-input-form">
            <input type="hidden" name="session_id" value="<?= $data['session']['id']; ?>">
            <input type="hidden" name="recipient_id" value="<?= $data['recipient_id']; ?>">
            <textarea name="message" class="form-control" placeholder="Ketik pesan diskusi Anda..." rows="2" required></textarea>
            <button type="submit" class="btn-primary btn-block" style="border-radius: 0.75rem; padding: 0.75rem 1.25rem; width: auto;">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // Auto-scroll to bottom of chat
    const chatBody = document.getElementById('chatBody');
    if(chatBody) chatBody.scrollTop = chatBody.scrollHeight;
</script>
