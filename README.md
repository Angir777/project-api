Czysty projekt Laravel

GITHUB: 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

## Instalacja:

composer create-project laravel/laravel example-app

## Uruchomić docker projekt na WSL'u

1. Pakiet 'laravel/sail' powinien być już zainstalowany.

2. Utwóż plik 'docker-compose.yml'. 

Wyjaśnienie niektórych opcji: 
context - zawiera lokalizację pliku Dockerfile
image - chyba musi mieć wersje jak z context

3. Wrzuć projekt np. na github'a.

4. W swoim WSL'u pobierz projekt i w głównym folderze projektu:

docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs

5. Uruchaom polecenie: sail up

6. Zakończ: ctrl+c

## Uruchomienie dev (WSL2 + Docker)
<ol>
    <li><code>docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs</code></li>
    <li><code>cp .env.example .env</code></li>
    <li><code>sail up -d</code></li>
    <li><code>sail artisan key:generate</code></li>
    <li><code>sail artisan storage:link</code></li>
    <li><code>sail composer fresh-db</code> - to potem</li>
    <li><code>sail down -v</code> - usówanie zapisanych danych</li>
</ol>

## Uruchomienie prod
Zobacz na dokumentacje (<code>https://laravel.com/docs/10.x/deployment</code>)
<ol>
    <li><code>composer install --optimize-autoloader --no-dev</code></li>
    <li><code>php artisan config:cache</code></li>
    <li><code>php artisan route:cache</code></li>
    <li><code>php artisan view:cache</code></li>
</ol>

## Przydatne polecenia
<ol>
    <li>Wersja Laravela <code>sail artisan --version</code></li>
</ol>

## Przydatne informacje
<ol>
    <li>Podpięta baza to <code>MariaDB</code> na adresie <code>http://localhost:8081/</code></li>
    <li>Maile obsługuje <code>Mailpit</code> na adresie <code>http://localhost:8025/</code></li>
    <li>Stworzenie nowego projektu Laravel pod Docker'a <code>curl -s "https://laravel.build/example-app?with=mysql,mailpit,redis" | bash</code></li>
    <li>Permissions <code>https://shouts.dev/snippets/target-class-spatiepermissionmiddlewarerolemiddleware-does-not-exist</code></li>
</ol>

## Instalacja laravel-permission i usunięcie laravel/sanctum:

1. Instalacja laravel-permission: composer require spatie/laravel-permission

2. Dodanie do config/app.php w 'providers': 

Spatie\Permission\PermissionServiceProvider::class

3. Upublicznienie ustawień permission w configu i migracji:

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

4. Jeśli zamiast ID chcemy UUID to musimy zmodyfikować migracje, konfiguracje i model:

https://spatie.be/index.php/docs/laravel-permission/v6/advanced-usage/uuid

5. Uruchamiamy polecenie: php artisan config:clear

6. Dodaj do modelu usera: HasRoles

7. Urochum migrację: php artisan migrate



