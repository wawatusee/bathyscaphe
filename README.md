# bathyscaphe
Event, Services and spirit of the bathyscaphe place
### admin artist
#### structure
projet/
├── admin/                             # Répertoire d'administration
│   ├── css/                           # CSS pour l'interface admin
│   │   └── style.css                  # Fichier CSS principal
│   ├── js/                            # JavaScript pour l'interface admin
│   │   └── artist-admin.js            # Script JavaScript pour la gestion des artistes
│   ├── admin_artist.php               # Page d'administration dédiée aux artistes
│   └── events_controller.php          # Contrôleur pour gérer les requêtes AJAX
├── json/                              # Répertoire JSON pour les données
│   ├── artists/                       # JSON spécifiques aux artistes
│   │   └── artist_1.json              # Exemple de fichier JSON d'artiste
│   └── artist-config.json             # Configuration des types de champs pour les artistes

# Event Admin – Formulaire dynamique basé sur une configuration JSON

## Présentation

Ce projet propose une interface d’administration d’événements générée dynamiquement à partir d’un fichier de configuration JSON.  
Le but est d’éditer, sauvegarder et valider des événements complexes sans modifier le code, simplement en mettant à jour la config.

## Fonctionnement général

- La **structure du formulaire** est définie dans un fichier `event-config.json` (type, label, validations, sources dynamiques…)
- Les **données de chaque événement** sont stockées séparément dans des fichiers JSON.
- L’interface d’édition (admin_event.php + event-admin.js) **génère dynamiquement** le formulaire HTML selon la config et les données à éditer.
- Les **sauvegardes** se font en JSON par POST selon la structure des objets en cours d’édition.

## Points forts

- **Évolution rapide** : pas besoin de modifier le backend ou le front pour faire évoluer les champs (ajout, retrait…).
- **Adaptable** : gestion possible de champs imbriqués, listes dynamiques (genres, activités…).
- **Aucune dépendance externe** : code vanilla JS et PHP simple à maintenir.
- **Multilingue** : support possible de labels et de contenus dans plusieurs langues.

## Exemples de structure (config)

```json
"activity_type_ids": {
  "type": "checkboxes",
  "label": "Types d'activités",
  "source": "../json/activity-types.json",
  "structure": {
    "id": "id",
    "label": "fr"
  }
}
