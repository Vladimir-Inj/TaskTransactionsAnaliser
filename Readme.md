# Initialisation
```
docker compose run --rm composer install
```

# Run tests
```
docker compose run --rm phpunit
```

# Run application
```
docker compose run --rm php -f public/app.php public/input.txt
```