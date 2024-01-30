<?php

namespace App\Services\User;

use App\Enums\Auth\PermissionNamesEnum;
use App\Helpers\Request\RequestHelper;
use App\Helpers\Response\ResponseHelper;
use App\Models\User\User;
use App\Notifications\Auth\AccountConfirmationNotification;
use App\QueryFilters\User\UserRolesFilter;
use App\QuerySorts\User\UserRoleSort;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    protected function allowedSorts(): array
    {
        return [
            AllowedSort::field('id', 'id'),
            AllowedSort::field('name', 'name'),
            AllowedSort::field('email', 'email'),
            AllowedSort::field('confirmed', 'confirmed'),
            AllowedSort::field('emailVerifiedAt', 'email_verified_at'),
            AllowedSort::field('createdAt', 'created_at'),
            AllowedSort::field('updatedAt', 'updated_at'),
            AllowedSort::field('deletedAt', 'deleted_at'),
            AllowedSort::custom('roles', new UserRoleSort),
        ];
    }

    protected function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id', 'id'),
            AllowedFilter::partial('name', 'name'),
            AllowedFilter::partial('email', 'email'),
            AllowedFilter::exact('confirmed', 'confirmed'),
            AllowedFilter::partial('emailVerifiedAt', 'email_verified_at'),
            AllowedFilter::partial('createdAt', 'created_at'),
            AllowedFilter::partial('updatedAt', 'updated_at'),
            AllowedFilter::partial('deletedAt', 'deleted_at'),
            AllowedFilter::custom('roles', new UserRolesFilter),
        ];
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return QueryBuilder::for(User::query())
            ->defaultSort('id')
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters())
            ->get();
    }

    /**
     * @return Paginator
     */
    public function query(): Paginator
    {
        return QueryBuilder::for(User::query())
            ->defaultSort('id')
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters())
            ->paginate(RequestHelper::pageSize());
    }

    /**
     * @return Paginator
     */
    public function queryDeleted(): Paginator
    {
        return QueryBuilder::for(User::onlyTrashed())
            ->defaultSort('id')
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters())
            ->paginate(RequestHelper::pageSize());
    }

    /**
     * @param mixed $confirmationCode
     *
     * @return User
     */
    public function confirmAccount($confirmationCode): User
    {
        $user = User::where('confirmation_code', $confirmationCode)->first();

        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CODE_INVALID'], Response::HTTP_BAD_REQUEST)
            );
        }

        if ($user->confirmed) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'ALREADY_CONFIRMED'], Response::HTTP_BAD_REQUEST)
            );
        }

        $user->email_verified_at = Carbon::now();
        $user->confirmed = true;
        $result = $user->save();

        if (!$result) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_CONFIRM'], Response::HTTP_BAD_REQUEST)
            );
        }

        return $user;
    }

    /**
     * @param mixed $data
     * @return User
     */
    public function create($data): User
    {
        return DB::transaction(function () use ($data) {

            // Jeśli konto jest zakładane przez administarcje, to zostaje wygenerowane przykładowe hasło
            if (isset($data['password'])) {
                $password = __('auth.email.account_activate.is_password');
                $passwordHash = Hash::make($data['password']);
            } else {
                $randomPassword = Str::random(12);
                $password = ': ' . $randomPassword;
                $passwordHash = Hash::make($randomPassword);
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' =>  $passwordHash,
                'confirmed' => $data['confirmed'] ?? !config('access.confirm_email'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
            ]);

            if (!$user) {
                throw new HttpResponseException(
                    response()->json(['error' => 'CANT_CREATE_USER_ACCOUNT'], Response::HTTP_UNPROCESSABLE_ENTITY)
                );
            }

            // Sprawdzenie czy zalogowany użytkownik może przypisać rolę 'SUPER_ADMIN' jeśli taka jest dodawana
            if (isset($data['roles'])) {
                foreach ($data['roles'] as $role) {
                    if ($role == config('access.roles.super_admin_role')) {
                        $this->checkPermissionToSuperAdmin(Auth::User());
                    }
                }
            }

            // Synchronizacja roli, usuniecie starych nadanie nowych
            if (isset($data['roles']) && count($data['roles']) > 0) {
                $user->syncRoles($data['roles']);
            } else {
                $user->assignRole(config('access.roles.user_role'));
            }

            // Wysłanie potwierdzenia założenia konta na email
            if (config('access.confirm_email')) {
                if (!isset($data['confirmed']) || (isset($data['confirmed']) && $data['confirmed'] == false)) {
                    // Wysyła maila z powitaniem i linkiem do potwierdzenia konta oraz z hasłem jeśli konto utworzone zostało w panelu administracyjnym
                    $user->notify(new AccountConfirmationNotification($user->confirmation_code, $password));
                } else {
                    // Wysyła tylko maila z powitaniem i hasłem bo konto jest potwierdzone
                    $user->notify(new AccountConfirmationNotification(null, $password));
                }
            } else {
                // Wysyła tylko maila z powitaniem bo nie jest wymagane potwierdzenie konta
                $user->notify(new AccountConfirmationNotification(null, $password));
            }

            return $user;
        });
    }

    /**
     * @param mixed $data
     * @return User
     */
    public function update($data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::find($data['id']);

            if ($user == null) {
                throw new HttpResponseException(
                    response()->json(['message' => 'USER_NOT_FOUND_IN_LOCAL_DB'], Response::HTTP_BAD_REQUEST)
                );
            }

            $res = $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => $data['confirmed'] ?? !config('access.confirm_email'),
            ]);

            if (!$res) {
                throw new HttpResponseException(
                    response()->json(['error' => 'CANT_UPDATE_USER_ACCOUNT'], Response::HTTP_UNPROCESSABLE_ENTITY)
                );
            }

            // Sprawdzenie czy zalogowany użytkownik może edytować użytkownika, który ma rolę 'SUPER_ADMIN'
            if ($user->can(PermissionNamesEnum::SUPER_ADMIN)) {
                $this->checkPermissionToSuperAdmin(Auth::User());
            }

            // Synchronizacja roli, usuniecie starych i nadanie nowych
            if (isset($data['roles']) && count($data['roles']) > 0) {
                $user->syncRoles($data['roles']);
            } else {
                $user->syncRoles([config('access.roles.user_role')]);
            }

            return $user;
        });
    }

    /**
     * @param User $user
     * @return User
     */
    public function delete(User $user): User
    {
        // Sprawdzenie czy zalogowany użytkownik może usunąć użytkownika, który ma rolę 'SUPER_ADMIN'
        if ($user->can(PermissionNamesEnum::SUPER_ADMIN)) {
            $this->checkPermissionToSuperAdmin(Auth::User());
        }

        // Użytkownik nie może sam siebie usunąć
        if (Auth::user()->id == $user->id) {
            throw new HttpResponseException(
                response()->json(['error' => 'CANT_DELETE_OWN_ACCOUNT'], Response::HTTP_BAD_REQUEST)
            );
        }

        $res = $user->delete();

        if (!$res) {
            throw new HttpResponseException(
                response()->json(['error' => 'CANT_DELETE'], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return $user;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function restore($id): User
    {
        $user = User::onlyTrashed()->find($id);

        if ($user == null) {
            throw new HttpResponseException(
                response()->json(['message' => 'USER_NOT_FOUND'], Response::HTTP_BAD_REQUEST)
            );
        }

        // Sprawdzenie, czy zalogowany użytkownik może przywrócić użytkownika, który ma rolę 'SUPER_ADMIN'
        if ($user->can(PermissionNamesEnum::SUPER_ADMIN)) {
            $this->checkPermissionToSuperAdmin(Auth::User());
        }

        $res = $user->restore();

        if (!$res) {
            throw new HttpResponseException(
                response()->json(['message' => 'CANT_RESTORE_USER'], Response::HTTP_BAD_REQUEST)
            );
        }

        return $user;
    }

    /**
     * @param User $user
     * @param mixed $password
     * @return User
     */
    public function changePassword(User $user, $password): User
    {
        // Sprawdzenie czy zalogowany użytkownik może zmienić hasło użytkownikowi, który ma rolę 'SUPER_ADMIN'
        if ($user->can(PermissionNamesEnum::SUPER_ADMIN)) {
            $this->checkPermissionToSuperAdmin(Auth::User());
        }

        $res = $user->update([
            'password' => Hash::make($password)
        ]);

        if (!$res) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_CHANGE_PASSWORD'], Response::HTTP_BAD_REQUEST)
            );
        }

        return $user;
    }

    /**
     * Sprawdza czy użytkownik posiada uprawnienie 'SUPER_ADMIN'
     * Jeśli nie ma, to zwraca błąd
     *
     * @param mixed $user
     */
    private function checkPermissionToSuperAdmin($user)
    {
        if ($user->cannot(PermissionNamesEnum::SUPER_ADMIN)) {
            throw new HttpResponseException(
                response()->json(['error' => 'YOU_ARE_NOT_A_SUPER_ADMIN'], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }
}
