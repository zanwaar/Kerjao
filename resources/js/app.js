const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

const setAiWritingStatus = (targetId, message, isError = false) => {
    const statusNode = document.querySelector(`[data-ai-writing-status="${targetId}"]`);

    if (! statusNode) {
        return;
    }

    statusNode.textContent = message;
    statusNode.classList.toggle('text-red-600', isError);
    statusNode.classList.toggle('text-gray-500', ! isError);
};

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-ai-writing-button]');

    if (! button) {
        return;
    }

    const context = button.dataset.context;
    const targetId = button.dataset.target;
    const url = button.dataset.url;
    const textarea = targetId ? document.getElementById(targetId) : null;

    if (! context || ! targetId || ! url || ! textarea) {
        return;
    }

    if (! textarea.value.trim()) {
        setAiWritingStatus(targetId, 'Isi teks terlebih dahulu sebelum memakai bantuan AI.', true);

        return;
    }

    button.disabled = true;
    button.classList.add('cursor-not-allowed', 'opacity-60');
    setAiWritingStatus(targetId, 'Sedang memperbaiki kalimat...');

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ?? '',
            },
            body: JSON.stringify({
                context,
                text: textarea.value,
            }),
        });

        const payload = await response.json();

        if (! response.ok || ! payload.improved_text) {
            throw new Error(payload.message ?? 'Bantuan AI penulisan sedang tidak tersedia.');
        }

        textarea.value = payload.improved_text;
        textarea.dispatchEvent(new Event('input', { bubbles: true }));
        textarea.dispatchEvent(new Event('change', { bubbles: true }));

        setAiWritingStatus(targetId, payload.message ?? 'Kalimat berhasil diperbaiki.');
    } catch (error) {
        const message = error instanceof Error
            ? error.message
            : 'Bantuan AI penulisan sedang tidak tersedia.';

        setAiWritingStatus(targetId, message, true);
    } finally {
        button.disabled = false;
        button.classList.remove('cursor-not-allowed', 'opacity-60');
    }
});
