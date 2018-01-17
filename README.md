# Galerie photo

Faite pour Olivier Rimbault par Jacques Rimbault.

Fichier de configuration `public.conf.ini` situé à la racine:
```ini
[SITE]
title = "Titre du site"
about = "Texte à propos du site, sans retour à ligne"
email = "mail@example.org"

; commentaire
; liste de liens à afficher dans la section "À propos"
; une url doit toujours être accompagnée d'un text
[LINK]
url[] = "https://bistrotsdeparis.blogspot.fr/"
text[] = "Cafés de Paris"
url[] = "assets/jar"
text[] = "Archives JAR"
url[] = "assets/img"
text[] = "Archives Photos"
```

Pour ajouter une galerie de photos mettre:
- un dossier nommé `vacances` dans le dossier `assets/img/`
- une image nommé `vacances.jpg` dans le dossier `assets/img/`

Sur un système linux, pour créer les miniatures de chaque image,
installer `imagemagick` et
utiliser le script `makethumbnails.sh`:
```bash
./makethumbnails.sh assets/img/vacances
```

Sur Windows utiliser un programme comme [IrfanView][0] (ou similaire), et
générer des images de 320x240 pixels maximum, placer-les dans le dossier `assets/img/thumbnails/vacances`.



[0]: http://www.irfanview.com/
