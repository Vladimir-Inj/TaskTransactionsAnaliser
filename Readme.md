I can learn quickly. Just give me a chance)

### Initialisation
```
docker compose run --rm composer install
```

### Run tests
```
docker compose run --rm phpunit
```

### Run application
```
docker compose run --rm php -f public/app.php file=public/input.txt config=public/config.ini
```