
- [README][0]
- [INSTALL][1]

# Configuration


## Add a Gallery

In the `public/gallery`:
- add a folder named `example` with your pictures in it
- add a `.jpg` named `example.jpg`

```
public/gallery
├── example
│   └── ...
├── album
│   └── ...
├── example.jpg
└── album.jpg
```

Run the script to generate the thumbnails:

```bash
php bin/console makethumb
```

## App preferences

After installation a file `config/app.ini` should have been made.  
You can change the available options there.

Options overview:

```ini
[SITE]
title = "your website name"
about = "Some text about you, your website, can be long or short."
email = "contact@email.com"

[COLOR]
; website background color
background = "131618"
; picture viewer background color
lightbox = "090b0c"

; use this section to set links
[LINK]
url[] = "https://www.example.org"
text[] = "A website example"
url[] = "https://www.google.com"
text[] = "Google"
url[] = "https://you.can-set.an-url.without/a-text"

[SWITCH]
; turn on/off the picture viewer
theater = true
; makes the website single page or multiple pages
singlepage = false
; toggle on/off the ribbon signaling work is in progress
dev = true
```

[0]: README.md
[1]: INSTALL.md
