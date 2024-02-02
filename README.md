## Czysty projekt API na Laravel 

GITHUB: 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

## Instalacja:

composer create-project laravel/laravel project-api

## Uruchomić docker projekt na WSL'u
<ol>
    <li>Pakiet 'laravel/sail' powinien być już zainstalowany.</li>
    <li>
        Utwóż plik 'docker-compose.yml'.<br>
        Wyjaśnienie niektórych opcji:<br>
        <ul>
            <li>context - zawiera lokalizację pliku Dockerfile</li>
            <li>image - chyba musi mieć wersje jak z context</li>
        </ul>
    </li>
    <li>Wrzuć projekt np. na github'a.</li>
    <li>W swoim WSL'u pobierz projekt i w głównym folderze projektu uruchom:<br>
    <code>docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs</code></li>
    <li>Uruchaom polecenie: <code>sail up</code><br>Za pierwszym razem wszystko będzie sobie konfigurował.</li>
    <li>Aby zakończyć daj: <code>ctrl+c</code></li>
    <li>Dostosuj plik env i composer.json: <code>cp .env.example .env</code></li>
</ol>

## Uruchomienie dev (WSL2 + Docker)
<ol>
    <li><code>docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs</code></li>
    <li><code>cp .env.example .env</code></li>
    <li><code>sail artisan key:generate</code></li>
    <li><code>sail artisan storage:link</code></li>
    <li><code>sail up -d</code></li>
    <li><code>sail composer fresh-db</code> - to potem</li>
    <li><code>sail down -v</code> - usówanie zapisanych danych</li>
</ol>

## Uruchomienie prod (https://laravel.com/docs/10.x/deployment)
<ol>
    <li><code>composer install --optimize-autoloader --no-dev</code></li>
    <li><code>php artisan config:cache</code></li>
    <li><code>php artisan route:cache</code></li>
    <li><code>php artisan view:cache</code></li>
</ol>

## Przydatne polecenia
<ol>
    <li>Sprawdź wersję Laravela: <code>sail artisan --version</code></li>
</ol>

## Przydatne informacje
<ol>
    <li>Podpięta baza to <code>MariaDB</code> na adresie: <code>http://localhost:8081/</code></li>
    <li>Maile obsługuje <code>Mailpit</code> na adresie: <code>http://localhost:8025/</code></li>
    <li>Stworzenie nowego projektu Laravel pod Docker'a: <code>curl -s "https://laravel.build/example-app?with=mysql,mailpit,redis" | bash</code></li>
    <li>Permissions: <code>https://shouts.dev/snippets/target-class-spatiepermissionmiddlewarerolemiddleware-does-not-exist</code></li>
</ol>

## Instalacja laravel-permission oraz laravel/passport i usunięcie laravel/sanctum:
<ol>
    <li>Instalacja laravel-permission: <code>sail composer require spatie/laravel-permission</code></li>
    <li>Dodanie do config/app.php w 'providers': <code>Spatie\Permission\PermissionServiceProvider::class</code></li>
    <li>Upublicznienie ustawień permission w configu i migracji:<br>
    <code>sail artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"</code></li>
    <li>Jeśli zamiast ID chcemy UUID to musimy zmodyfikować migracje, konfiguracje i model: https://spatie.be/index.php/docs/laravel-permission/v6/advanced-usage/uuid</li>
    <li>Uruchamiamy polecenie: <code>sail artisan config:clear</code></li>
    <li>
        Dodaj do modelu usera: <br>
        <code>use Laravel\Passport\HasApiTokens;</code><br>
        <code>use Spatie\Permission\Traits\HasRoles;</code><br>
        <code>HasRoles</code>
    </li>
    <li>Zainstaluj passport: <code>sail composer require laravel/passport</code></li>
    <li>Uruchum migrację: <code>sail artisan migrate</code></li>
    <li>Odinstaluj laravel/sanctum i usuń wystapienia w kodzie: <code>sail composer remove laravel/sanctum</code></li>
    <li>
        Zmodyfikuj Kernel.php<br>
        <code>'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,</code>
    </li>
</ol>

## Doinstaluj na poczatek
<ol>
    <li>
        spatie/laravel-query-builder<br>
        <code>sail composer require spatie/laravel-query-builder</code><br>
        <code>sail artisan vendor:publish --provider="Spatie\QueryBuilder\QueryBuilderServiceProvider"</code>
    </li>
    <li>
        laravel/telescope<br>
        <code>sail composer require laravel/telescope --dev</code><br>
        <code>sail artisan telescope:install</code><br>
        <code>sail artisan migrate</code><br>
        Dodaj do AppServiceProvider.php w register:<br>
        <code>if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }</code>
    </li>
</ol>

## Edycja plików w katalogu config

## Utworzenie jobs table
<code>sail artisan queue:table
sail artisan migrate</code>

## Szablon maili
<code>sail artisan vendor:publish --tag=laravel-notifications</code>

## Podstawowe routs, migracje, seedery, modele, controllery od logowania i widoków users i roles

## Testy
