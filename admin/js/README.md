# Interface admin

### defintions:
Rôles
  - Utilisateur
  - Gestionaire
  - Administrateur

Page d'édition
  - Activité



### Proposition 01 - I18n

Lors de la saisie des pages d'édition, le gestionaire peut basculer entre les langues diponibles et ainsi renseigner les différentes traductions.

Le "changement" de langue ne doit pas provoquer le rechargement de la page.

Pour l'algorithmie: si un champ est un tableau et si il y a un élément de ce tableau qui a comme clé la clé de langue alors il s'agit d'un champ à traduire.

### Proposition 02 - Menu
La partie haute des pages d'édition sont un menu de commande... (langue, enregistrement, etc.)
Pour rendre ce menu accesible à tout moment, le fixer en haut de la fenêtre.
Par CSS { position: fixed; }



## Algorithmie
- sur base du tableau des élément HTML data-field, générer les zones de saisie correspondantes
- choix du composant:
  - si "input-componan
  - par défaut: label + inputbox