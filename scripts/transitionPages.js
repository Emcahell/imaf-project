// Fade in del body
document.addEventListener('DOMContentLoaded', function() {
  document.body.style.opacity = '1';
});

// Fade out antes de cambiar de página
document.querySelectorAll('a').forEach(link => {
  if (link.href && !link.hash) {
    link.addEventListener('click', function(e) {

      if (this.href.includes(window.location.hostname)) {
        e.preventDefault();
        document.body.style.opacity = '0';
        setTimeout(() => {
          window.location.href = this.href;
        }, 60);
      }
    });
  }
});