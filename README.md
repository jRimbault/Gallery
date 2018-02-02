# Gallery

Simply display galleries of pictures.

## Install

Clone the repository:

```bash
git clone https://git.jrimbault.io/jRimbault/Gallery.git
cd Gallery
composer install
```

If necessary, install the `ext-imagick` for PHP:

```bash
# example for apt based distro
apt install php-imagick
phpenmod imagick
```

## Server

For Apache2:
- Set the document root of your host to the `public` directory
- Allow `.htaccess`
- Enable the mod `rewrite`:

```bash
a2enmod rewrite
```

Example configuration:
```apache
<VirtualHost *:80>
    # domain name
    ServerName localhost
    # path leading to the cloned repo
    Define root /path/to/Gallery
    DocumentRoot ${root}/public
    <Directory ${root}/public>
        AllowOverride All
        # "Require all granted" if not accessed from localhost
        Require local
    </Directory>
    ErrorLog ${root}/var/log/error.log
    CustomLog ${root}/var/log/apache.log combined
</VirtualHost>
```

You should check if the apache user has access to the directories.

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

## Configuration

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
