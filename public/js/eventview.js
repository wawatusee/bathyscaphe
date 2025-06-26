// js/eventView.js
function initEventView() {
    // 1. Gestion de la fermeture de l'événement
    const eventSection = document.querySelector(".core");
    const closeButton = document.getElementById("closeEvent");

    function closeEvent() {
        eventSection.setAttribute("hidden", "");
    }

    closeButton.addEventListener("click", closeEvent);
    eventSection.addEventListener("click", function (e) {
        if (e.target === eventSection) closeEvent();
    });

    // 2. Gestion des bios d'artistes
    function initBioCollapse() {
        document.querySelectorAll('[data-js-artist-bio]').forEach(bioElement => {
            const maxLines = 5;
            const seeMoreBtn = bioElement.nextElementSibling;

            // Fallback pour lineHeight
            let lineHeight = parseFloat(getComputedStyle(bioElement).lineHeight) || 24;
            const collapsedHeight = lineHeight * maxLines;

            // Supprimez toute logique de display: block/none
            if (bioElement.scrollHeight > collapsedHeight) {
                // Bouton toujours visible
                seeMoreBtn.style.display = 'block';

                // Initialisation
                bioElement.classList.add('collapsed');
                seeMoreBtn.setAttribute('aria-expanded', 'false');

                // Gestion du clic
                seeMoreBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const wasCollapsed = bioElement.classList.toggle('collapsed');

                    // Mise à jour des états
                    seeMoreBtn.setAttribute('aria-expanded', !wasCollapsed);
                    bioElement.style.maxHeight = wasCollapsed
                        ? `${collapsedHeight}px`
                        : 'none';
                });
            }
        });
    }

    // Initialisation
    initBioCollapse();
    // Dans le initBioCollapse
    seeMoreBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const wasCollapsed = bioElement.classList.toggle('collapsed');
        seeMoreBtn.setAttribute('aria-expanded', !wasCollapsed);
    });

}

// Lance au chargement + si le DOM est modifié dynamiquement
document.addEventListener("DOMContentLoaded", initEventView);