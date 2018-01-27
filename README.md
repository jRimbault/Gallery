# Gallery

Made for Olivier Rimbault by Jacques Rimbault.

## Install

Clone the repository:

```bash
git clone https://git.jrimbault.io/jRimbault/rimbault.eu.git
cd rimbault.eu
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
```conf
[...]
ServerName localhost
DocumentRoot /path/rimbault.eu/public
<Directory /path/rimbault.eu/public>
    AllowOverride All
</Directory>
ErrorLog /path/rimbault.eu/var/log/error.log
CustomLog /path/rimbault.eu/var/log/apache.log combined
[...]
```

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
