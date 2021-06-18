# Phone Book
Match employees with each other by providing the right formatted csv file.

Playground: http://match-this.gasparyan.am/

## Installation and Setup

### Installation
Get repository:
```shell
git clone https://github.com/GasparyanG/match_this.git
```

Go to `match_this` directory:
```shell
cd match_this
```

Get dependencies:
```shell
composer install
```

### Apache
Configure your apache in the following directory `/etc/apache2`.
```apacheconf
<VirtualHost *:80>
        # Instead, you can use localhost
	ServerName match_this.loc
	DirectoryIndex index.html public/index.html

	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/match_this

	<Directory /var/www/match_this/>
		Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all				
	</Directory>
	
	# This complexity is for routing sake.
	<Directory /var/www/match_this/>
		RewriteEngine On
	        RewriteCond %{REQUEST_FILENAME} !-f
	        RewriteCond %{REQUEST_FILENAME} !-d
	        RewriteRule (.*) public/index.php [QSA,L]
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

```