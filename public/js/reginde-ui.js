/**
 * Mini UI kit tipo SweetAlert (modal de confirmación + toast), sin dependencias externas.
 */
function regindeConfirm({ title, text, confirmText = 'Confirmar', danger = false }) {
  return new Promise((resolve) => {
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
      <div class="modal-card">
        <div class="modal-icon ${danger ? 'danger' : 'warn'}">${danger ? '⚠' : '✎'}</div>
        <p class="modal-title">${title}</p>
        <p class="modal-text">${text}</p>
        <div class="modal-actions">
          <button type="button" class="btn-ghost" data-act="cancel">Cancelar</button>
          <button type="button" class="${danger ? 'btn-danger' : 'btn-primary'}" data-act="confirm">${confirmText}</button>
        </div>
      </div>`;
    document.body.appendChild(overlay);
    requestAnimationFrame(() => overlay.classList.add('open'));

    function close(result) {
      overlay.classList.remove('open');
      setTimeout(() => overlay.remove(), 150);
      resolve(result);
    }

    overlay.querySelector('[data-act="cancel"]').addEventListener('click', () => close(false));
    overlay.querySelector('[data-act="confirm"]').addEventListener('click', () => close(true));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) close(false); });
  });
}

function regindeToast(message, type = 'success') {
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('show'));
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, 3200);
}
