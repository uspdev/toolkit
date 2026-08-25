<script>
  document.querySelectorAll('[data-copy-target]').forEach((button) => {
    button.addEventListener('click', async () => {
      const input = document.getElementById(button.dataset.copyTarget);

      if (!input || !navigator.clipboard) return;

      await navigator.clipboard.writeText(input.value);
      const label = button.textContent;
      button.textContent = 'Copiada';
      window.setTimeout(() => button.textContent = label, 1500);
    });
  });

  const helpModal = document.querySelector('[data-api-help-modal]');
  const helpOpen = document.querySelector('[data-api-help-open]');

  const closeHelp = () => {
    if (!helpModal) return;

    helpModal.style.display = 'none';
    helpModal.classList.remove('show');
    helpModal.setAttribute('aria-hidden', 'true');
    document.querySelectorAll('[data-api-help-backdrop]').forEach((backdrop) => backdrop.remove());
    document.body.classList.remove('modal-open');
  };

  const openHelp = () => {
    if (!helpModal) return;

    helpModal.style.display = 'block';
    helpModal.classList.add('show');
    helpModal.setAttribute('aria-hidden', 'false');

    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.dataset.apiHelpBackdrop = 'true';
    backdrop.addEventListener('click', closeHelp);
    document.body.appendChild(backdrop);
    document.body.classList.add('modal-open');
  };

  helpOpen?.addEventListener('click', openHelp);
  helpModal?.querySelectorAll('[data-api-help-close]').forEach((button) => {
    button.addEventListener('click', closeHelp);
  });
</script>
