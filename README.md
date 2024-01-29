## Czysty projekt Laravel

## Instalacja:

composer create-project laravel/laravel example-app

## Dodanie do projektu pliku 'docker-compose.yml' by uruchamiać projket na WSL'u

# 1. Pakiet 'laravel/sail' powinien byc już zainstalowany

# 2. Utwóż plik 'docker-compose.yml'. Wyjasnienie niekturych opcji: 

context - zawiera lokalizację pliku Dockerfile
image - chyba musi mieć wersje jak z context

## Instalacja laravel-permission i usunięcie laravel/sanctum:

# 1. Instalacja laravel-permission:

composer require spatie/laravel-permission

# 2. Dodanie do config/app.php w 'providers': 

Spatie\Permission\PermissionServiceProvider::class

# 3. Upublicznienie ustawień permission w configu i migracji:

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# 4. Jesli zamiast ID chcemy UUID to musimy zmodyfikować migracje, konfiguracje i model:

https://spatie.be/index.php/docs/laravel-permission/v6/advanced-usage/uuid

# 5. Uruchamiamy polecenie:

php artisan config:clear

 


