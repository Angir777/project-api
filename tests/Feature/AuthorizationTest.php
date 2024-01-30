<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * Test mechanizmu logowania do aplikacji
     *
     * @return void
     */
    public function test_login()
    {
        // Wykonanie zapytania do API
        $responseLogin = $this->postJson("$this->apiUrl/auth/login", [
            'email' => 'superadmin@mail.com',
            'password' => 'root12'
        ]);
        // Sprawdzenie, czy zwrotka to 200 oraz, czy response zawiera wszystkie niezbędne pola
        $responseLogin->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) {
            return $json
                ->has('id')
                ->has('name')
                ->where('email', 'superadmin@mail.com')
                ->has('confirmed')
                ->has('createdAt')
                ->has('updatedAt')
                ->has('token')
                ->where('tokenType', 'Bearer')
                ->has('permissions')
                ->has('roles');
        });

        // Wykonanie zapytania do API
        $responseWrongCredentials = $this->postJson("$this->apiUrl/auth/login", [
            'email' => 'superadmin@mail.com',
            'password' => 'root1234',
        ]);
        // Sprawdzenie, czy po podaniu błędnych danych zwrócone zostanie 401
        $responseWrongCredentials->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
