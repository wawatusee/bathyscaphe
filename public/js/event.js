document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.read-more-btn');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const bio = button.previousElementSibling;
            const isCollapsed = bio.classList.contains('collapsed');

            if (isCollapsed) {
                bio.classList.remove('collapsed');
                bio.style.maxHeight = bio.scrollHeight + "px"; // auto-déploiement
                button.textContent = "Lire moins";
            } else {
                bio.classList.add('collapsed');
                bio.style.maxHeight = ""; // retour à la classe CSS
                button.textContent = "Lire plus";
            }
        });
    });
});
