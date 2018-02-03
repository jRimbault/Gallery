
- [README][0]
- [CONFIG][1]

# Install


## Setup

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

[0]: README.md
[1]: CONFIG.md
