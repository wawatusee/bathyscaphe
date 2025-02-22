document.getElementById("submitEvent").addEventListener("click", function() {
    // Remplir le modèle JSON
    let eventModel = {
        event: {
            id: document.querySelector('input[name="id"]').value,
            time: {
                date: document.querySelector('input[name="date"]').value,
                horaire: {
                    fr: document.querySelector('input[name="horaire"]').value,
                    en: document.querySelector('input[name="horaire"]').value, // Adapter pour les autres langues si nécessaire
                    nl: document.querySelector('input[name="horaire"]').value
                }
            },
            title: document.querySelector('input[name="title"]').value,
            description_event: {
                fr: document.querySelector('textarea[name="description"]').value,
                en: document.querySelector('textarea[name="description"]').value, // Adapter pour les autres langues si nécessaire
                nl: document.querySelector('textarea[name="description"]').value
            },
            infospratiques: {
                necessitedbook: document.querySelector('input[name="booking"]').checked,
                price: document.querySelector('input[name="price"]').value,
                // Ajoute les autres champs nécessaires ici...
            }
        }
    };

    // Envoi en AJAX
    fetch('save_event.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventModel)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // Gérer l'affichage ou redirection après sauvegarde
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
