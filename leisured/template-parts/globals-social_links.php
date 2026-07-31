<div class="c-social o-flex">
	<?php 
    if(have_rows('social_links', 'option')) {
        while(have_rows('social_links', 'option')) {
            the_row();
            $social_link = get_sub_field('social_link');
            $icon_code = get_sub_field('icon_code');
          
            ?>
            <a href="<?php echo $social_link['url']; ?>" target="_blank" class="c-social__item">
                <i class="c-social__icon" aria-hidden="true"><?php echo $icon_code; ?></i>
                <span class="c-social__text u-sr-text"><?php echo $social_link['title']; ?></span>
            </a>
        <?php
        }
    }
?>
</div>



 
<h2>Popups</h2>
<button class="c-button dialog-open-trigger" aria-haspopup="dialog" aria-controls="dialog-contact">
<span class="c-button__label">Contact Us</span>
</button>

<dialog class="c-dialog" id="dialog-contact">
<button class="c-button dialog-close-trigger" aria-label="Close"></button>
<div class="c-dialog__panel" role="document">
<div class="c-dialog__body" data-lenis-prevent="true">
<h2 class="e-title c-dialog__form-head">Form headline would be placed here.</h2>
Lorem ipsum dolor sit amet elit. Mauris venenatis, mi nec posuere purus ipsum posuere sapien, vitae pretium nunc ipsum eget ex. Etiam venenatis tempus urna, sed tempor arcu.

 </div> 
</div>
 
</dialog>
 

<script>
(function () {
  const root = document.documentElement;
  const focusableSelector = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [contenteditable], [tabindex]:not([tabindex="-1"])';

  let lastFocused = null;
  let activeDialog = null;

  // Helper: prevent scroll and pause Lenis
  const lockScroll = () => {
    root.classList.add('no-scroll');
    lenis.stop();
  };

  // Helper: restore scroll and resume Lenis
  const unlockScroll = () => {
    root.classList.remove('no-scroll');
    lenis.start();
  };

  // Trap focus within dialog
  function trapFocus(event) {
    if (!activeDialog) return;
    const focusables = Array.from(activeDialog.querySelectorAll(focusableSelector));
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];

    if (event.key === 'Tab') {
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    } else if (event.key === 'Escape') {
      event.preventDefault();
      closeDialog(activeDialog);
    }
  }

  function openDialog(dialog) {
    if (!(dialog instanceof HTMLDialogElement)) return;

    lastFocused = document.activeElement;
    activeDialog = dialog;
    dialog.showModal();

    lockScroll();
   
    // Focus first focusable element
    const firstFocusable = dialog.querySelector(focusableSelector);
    (firstFocusable || dialog).focus();
    
    setTimeout(() => {
      firstFocusable.focus();
    }, 900);

    document.addEventListener('keydown', trapFocus);
  }

  function closeDialog(dialog) {
    if (!(dialog instanceof HTMLDialogElement)) return;
    
    dialog.close();
    unlockScroll();

    // Restore focus
    if (lastFocused) lastFocused.focus();

    document.removeEventListener('keydown', trapFocus);
    activeDialog = null;
  }

  // Open dialog on trigger click
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.dialog-open-trigger');
    if (!trigger) return;

    const dialogId = trigger.getAttribute('aria-controls');
    const dialog = document.getElementById(dialogId);
    if (dialog) {
      e.preventDefault();
      openDialog(dialog);
    }
  });

  // Close dialog on .dialog-close-trigger click
  document.addEventListener('click', (e) => {
    const closeBtn = e.target.closest('.dialog-close-trigger');
    if (!closeBtn) return;

    const dialog = closeBtn.closest('.c-dialog');
    if (dialog) {
      e.preventDefault();
      closeDialog(dialog);
    }
  });

  // Close when clicking backdrop
  document.querySelectorAll('.c-dialog').forEach((dialog) => {
    dialog.addEventListener('click', (e) => {
      const panel = dialog.querySelector('.c-dialog__panel');
      if (panel && !panel.contains(e.target)) {
        closeDialog(dialog);
      }
    });
  });
})();

</script>