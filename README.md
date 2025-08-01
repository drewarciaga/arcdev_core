# Comments

Package for creating and managing landing pages.

## Installation

# Step 1: add this to the projects composer.json between the 'license' and ‘require’ key value pairs
    in PROD
          	"repositories": [
          		{
          			"type": "vcs",
          			"url": "https://github.com/drewarciaga/core"
          		}
          	],
    in DEV
            "repositories": [
                {
                    "type": "path",
                    "url": "../arcdev_core",
                    "options": {
                        "symlink": true
                    }
                },
            ],

# Step 2: run this command to install the package ( this will install the latest version )
```bash
    composer require arcdev-packages/core:@dev --prefer-source
 ```     

# Step 3: run this command to publish all publishable files
```bash
    php artisan vendor:publish --provider="ArcdevPackages\Core\CoreServiceProvider"
    php artisan vendor:publish --tag=arcdev-core-config
    php artisan vendor:publish --tag=arcdev-core-vue-components
    php artisan vendor:publish --tag=migrations
```
    OR publish them all at once with this command:
```bash
    php artisan vendor:publish --tag=arcdev-packages/publishable-files
```

# To apply package changes:
```bash
composer dump-autoload
```
# Clear Laravel and Composer caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```
## Usage

## Configuration


## Component Usage


## License
MIT
