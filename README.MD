# Prerequisites
php ext-zip composer mysql yarn 
# Setup

```cp .env.example .env```

 Configure your environment file 

```composer install```

```yarn install && yarn build```

```vendor/bin/phinx migrate && vendor/bin/phinx seeds:run```

```php -S localhost:8080 ```