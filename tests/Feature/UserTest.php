<?php

namespace Tests\Feature;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // /**
    //  * Test zwracania listy wszystkich użytkowników.
    //  *
    //  * @return void
    //  */
    // public function test_get_all()
    // {
    //     // Przygotowanie ustawień do testu
    //     $totalCount = 13;
    //     $url = "$this->apiUrl/user/get-all";

    //     // Utworzenie dodatkowych 10 userów
    //     User::factory()->count(10)->create();

    //     // Sprawdzenie autoryzacji do endpointu
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie, czy zwrotka ma status 200, oraz czy posiada odpowiednie pola
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($totalCount) {
    //         return $json->count($totalCount);
    //     });
    // }

    // /**
    //  * Test zwracania listy użytkowników z podziałem na strony.
    //  */
    // public function test_query(): void
    // {
    //     // Przygotowanie ustawień do testu
    //     $totalCount = 13;
    //     $currentPage = 1;
    //     $pageSize = 3;
    //     $queryString = "?sort=id&pageSize=$pageSize";
    //     $url = "$this->apiUrl/user" . $queryString;

    //     // Utworzenie dodatkowych 10 userów
    //     User::factory()->count(10)->create();

    //     // Sprawdzenie autoryzacji do endpointu
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie, czy zwrotka ma status 200, oraz czy posiada odpowiednie pola
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($totalCount, $currentPage, $pageSize) {
    //         return $json
    //             ->has('items')
    //             ->where('totalCount', $totalCount)
    //             ->where('currentPage', $currentPage)
    //             ->where('pageSize', $pageSize)
    //             ->has('lastPage');
    //     });
    // }

    // /**
    //  * Test zwracania użytkownika po jego ID.
    //  *
    //  * @return void
    //  */
    // public function test_get_by_id()
    // {
    //     // Utworzenie przykładowego użytkownika
    //     User::factory()->create();

    //     // Pobieranie użytkownika z bazy
    //     $newUser = User::get()->last();

    //     // Przygotowanie url do testu
    //     $url = "$this->apiUrl/user/$newUser->id";

    //     // Sprawdzenie autoryzacji endpointu
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie, czy zwrotka ma status 200, oraz czy zwrócono odpowiednie pola z odpowiednimi wartościami
    //     $response = $this->getJson($url);
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($newUser) {
    //         return $json
    //             ->where('id', $newUser->id)
    //             ->where('name', $newUser->name)
    //             ->where('email', $newUser->email)
    //             ->has('emailVerifiedAt')
    //             ->has('confirmed')
    //             ->has('createdAt')
    //             ->has('updatedAt')
    //             ->has('deletedAt')
    //             ->has('permissions')
    //             ->has('roles');
    //     });
    // }

    // /**
    //  * Test dodawania użytkownika.
    //  *
    //  * @return void
    //  */
    // public function test_create()
    // {
    //     // Przygotowanie url do testu
    //     $url = "$this->apiUrl/user";

    //     // Sprawdzenie autoryzacji endpointu
    //     $response = $this->postJson($url, []);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie czy działa walidacja (ma zawrócić błąd bo podano za mało argumentów)
    //     $response = $this->postJson($url, [
    //         'name' => 'User 4'
    //     ]);
    //     $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    //     // Utworzenie użytkownika
    //     $response = $this->postJson($url, [
    //         'name' => 'User 4',
    //         'email' => 'user4@example.com',
    //         'confirmed' => true,
    //         'roles' => [3]
    //     ]);

    //     // Pobranie utworzonego użytkownika z bazy danych
    //     $createdUser = User::get()->last();

    //     // Sprawdzenie, czy zwrotka to 200 oraz, czy zwrócone dane pokrywają się z tymi zapisanymi w bazie danych
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($createdUser) {
    //         return $json
    //             ->where('id', $createdUser->id)
    //             ->where('name', 'User 4')
    //             ->where('email', 'user4@example.com')
    //             ->has('emailVerifiedAt')
    //             ->has('confirmed')
    //             ->has('createdAt')
    //             ->has('updatedAt')
    //             ->has('deletedAt')
    //             ->has('permissions')
    //             ->has('roles');
    //     });

    //     // Wyrywkowe sprawdzenie, czy utworzony użytkownik ma takie wartości, jakie zostały przesłane w POST
    //     $this->assertEquals($createdUser->name, 'User 4');
    // }

    // /**
    //  * Test aktualizacji pracownika.
    //  *
    //  * @return void
    //  */
    // public function test_update()
    // {
    //     // Przygotowanie url do testu
    //     $url = "$this->apiUrl/user";

    //     // Utworzenie przykładowego użytkownika
    //     $exampleUser = User::factory()->create();

    //     // Sprawdzenie autoryzacji endpointu
    //     $response = $this->patchJson($url, []);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie walidacji
    //     $response = $this->patchJson($url, [
    //         'name' => 'User 5'
    //     ]);
    //     $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    //     // Aktualizacja pakietu
    //     $response = $this->patchJson($url, [
    //         'id' => $exampleUser->id,
    //         'name' => 'User 5',
    //         'email' => 'user5@example.com',
    //         'confirmed' => true,
    //         'roles' => [2]
    //     ]);

    //     // Pobranie zaktualizowanego pakietu z DB
    //     $updateUser = User::find($exampleUser->id);

    //     // Sprawdzenie, czy zwrotka to 200 oraz, czy zwrócone dane pokrywają się z tymi zapisanymi w bazie danych
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($updateUser) {
    //         return $json
    //             ->where('id', $updateUser->id)
    //             ->where('name', 'User 5')
    //             ->where('email', 'user5@example.com')
    //             ->has('emailVerifiedAt')
    //             ->has('confirmed')
    //             ->has('createdAt')
    //             ->has('updatedAt')
    //             ->has('deletedAt')
    //             ->has('permissions')
    //             ->has('roles');
    //     });

    //     // Sprawdzenie, czy dane zostały zmienione
    //     $this->assertEquals($updateUser->name, 'User 5');
    // }

    // /**
    //  * Test usuwania użytkownika.
    //  *
    //  * @return void
    //  */
    // public function test_delete_by_id()
    // {
    //     // Utworzenie przykładowego użytkownika
    //     $exapleUser = User::factory()->create();

    //     // Pobranie utworzonego użytkownika z bazy
    //     $userToDelete = User::find($exapleUser->id);

    //     // Przygotowanie url to testu
    //     $url = "$this->apiUrl/user/$userToDelete->id";

    //     // Sprawdzenie autoryzacji endpointu
    //     $response = $this->deleteJson($url);
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    //     // Zalogowanie do aplikacji jako administartor
    //     $user = User::first();
    //     $this->actingAs($user, 'api');

    //     // Sprawdzenie, czy zwrotka to 200 oraz, czy zwrócone dane pokrywają się z tymi zapisanymi w bazie danych
    //     $response = $this->deleteJson($url);
    //     $response->assertStatus(Response::HTTP_OK)->assertJson(function (AssertableJson $json) use ($userToDelete) {
    //         return $json
    //             ->where('id', $userToDelete->id)
    //             ->where('name', $userToDelete->name)
    //             ->where('email', $userToDelete->email)
    //             ->has('emailVerifiedAt')
    //             ->has('confirmed')
    //             ->has('createdAt')
    //             ->has('updatedAt')
    //             ->has('deletedAt')
    //             ->has('permissions')
    //             ->has('roles');
    //     });

    //     // Sprawdzenie, czy użytkownik został usunięty
    //     $this->assertEquals(User::count(), 3);
    // }
}
