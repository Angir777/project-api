<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * INFO 1
     * Przy pierwszym uruchaomieniu testów może być błąd "Your XML configuration validates against a deprecated schema. Migrate your XML configuration using "--migrate-configuration"!"
     * Uruchaom w cmd: vendor/bin/phpunit --migrate-configuration
     * Jeśli w env od testów nie mamy klucza aplikacji, musimy go wygenerować: php artisan key:generate --env=testing
     * Następnie uruchom testy ./vendor/bin/phpunit lub php artisan test
     */

    /**
     * INFO 2
     * Ogólne ustawienia naszych testów.
     * Ustawiamy stałe zmienne potrzebne dla testów.
     * Określamy też co ma się dziać na początku i końcu testów.
     * Teraz należy napisać konkretne testy umieszczone w "Feature" lub "Unit".
     */

    /**
     * INFO 3
     * Każdy test wykonuje się jakby osobno od nowa i na bazie zostają informacje z ostatniego testu.
     */

    /**
     * INFO 4
     * Dostępne twierdzenia do testowania: https://laravel.com/docs/10.x/http-tests#available-assertions
     */

    // Adres do API
    protected $apiUrl = "/api/v1";

    // Wywoływane przed każdym testem
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
        Artisan::call('passport:install --force');
    }

    // Wywoływane na koniec każdego testu
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
