<?php

namespace App\Enums\Auth;

/**
 * Dostępne uprawnienia
 */
abstract class PermissionNamesEnum
{
    // Uprawnienia podstawowe
    const SUPER_ADMIN = 'SUPER_ADMIN';
    const ADMIN = 'ADMIN';
    const USER = 'USER';

    // Uprawnienia związane z zarzązaniem uprawnieniami
    const PERMISSION_ACCESS = 'PERMISSION_ACCESS';

    // Uprawnienia związane z zarządzaniem użytkownikami
    const USER_ACCESS = 'USER_ACCESS';
    const USER_MANAGE = 'USER_MANAGE';

    // Uprawnienia związane z zarządzaniem rolami
    const ROLE_ACCESS = 'ROLE_ACCESS';
    const ROLE_MANAGE = 'ROLE_MANAGE';

    // Nowe przykładowe uprawnienie dla nowej grupy, dodawane z konsoli 
    // 'sail composer refresh-permissions'
    const TEST_PERMISSION_ACCESS = 'TEST_PERMISSION_ACCESS';
    const TEST_PERMISSION_MANAGE = 'TEST_PERMISSION_MANAGE';
}
