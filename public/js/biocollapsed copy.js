document.addEventListener('DOMContentLoaded', () => {
    // Pour chaque bio d'artiste
    document.querySelectorAll('[data-js-artist-bio]').forEach(bioElement => {
        const maxLines = parseInt(bioElement.dataset.maxLines) || 5; // Fallback à 5 lignes
        const seeMoreBtn = bioElement.nextElementSibling; // Le bouton "Voir plus"

        // Vérifier si le texte dépasse la limite
        if (bioElement.scrollHeight > (maxLines * parseInt(getComputedStyle(bioElement).lineHeight))) {
            bioElement.style.setProperty('--max-lines', maxLines);
            bioElement.classList.add('collapsed');
            seeMoreBtn.style.display = 'block';
        } else {
            seeMoreBtn.style.display = 'none';
        }

        // Gérer le clic sur "Voir plus"
        seeMoreBtn.addEventListener('click', () => {
            bioElement.classList.toggle('collapsed');
            seeMoreBtn.textContent = bioElement.classList.contains('collapsed') 
                ? 'Voir plus' 
                : 'Voir mouins';
        });
    });
});