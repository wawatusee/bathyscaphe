const boutonPartager = document.getElementById('btnPartager');

boutonPartager.addEventListener('click', function() {
    // Obtenez l'URL de la page en cours
    const urlPageEnCours = window.location.href;

    // Copiez l'URL dans le presse-papiers
    if (navigator.clipboard) {
        navigator.clipboard.writeText(urlPageEnCours)
            .then(() => {
                console.log('L\'URL de la page a été copiée dans le presse-papiers.');
            })
            .catch(err => {
                console.error('Erreur lors de la copie dans le presse-papiers : ', err);
            });
    } else {
        // Si l'API Clipboard n'est pas disponible, utilisez document.execCommand
        const inputTemporaire = document.createElement('input');
        inputTemporaire.value = urlPageEnCours;
        document.body.appendChild(inputTemporaire);
        inputTemporaire.select();
        document.execCommand('copy');
        document.body.removeChild(inputTemporaire);
        console.log('L\'URL de la page a été copiée dans le presse-papiers (solution de secours).');
    }

    // Partagez l'URL via la fonction de partage intégrée du navigateur
    if (navigator.share) {
        navigator.share({
            title: 'Titre de la page',
            text: 'Description de la page',
            url: urlPageEnCours
        })
        .then(() => {
            console.log('Page partagée avec succès');
        })
        .catch(error => {
            console.error('Erreur lors de la partage de la page : ', error);
        });
    } else {
        console.log('La fonction de partage intégrée n\'est pas prise en charge par votre navigateur.');
    }
});
