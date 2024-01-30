<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $domain = 'http://localhost:8000/api/';

    return [
        'Laravel version' => app()->version(),
        'API version' => '1.0.0',
        'API clients' => [
            'Angular' => [
                'name' => 'project-app',
                'status' => 'Progress'
            ],
            'React' => [
                'name' => 'project-next',
                'status' => 'Future'
            ],
            'Mobile' => [
                'name' => 'project-native',
                'status' => 'Future'
            ],
        ],
        'Routs' => [
            'basic-tests' => [
                'example-page-with-auth' => [
                    'method' => 'GET',
                    'url' => $domain . 'page',
                    'body' => []
                ],
                'example-page-with-auth-and-permission' => [
                    'method' => 'GET',
                    'url' => $domain . 'page/subpage',
                    'body' => []
                ]
            ],
            'auth' => [
                'register' => [
                    'method' => 'POST',
                    'url' => $domain . 'auth/register',
                    'body' => [
                        'name' => 'Test2',
                        'email' => 'test2@mail.com',
                        'password' => 'root12',
                        'password_confirmation' => 'root12'
                    ]
                ],
                'login' => [
                    'method' => 'POST',
                    'url' => $domain . 'auth/login',
                    'body' => [
                        'email' => 'superadmin@mail.com',
                        'password' => 'root12'
                    ]
                ],
                'logout' => [
                    'method' => 'GET',
                    'url' => $domain . 'auth/logout',
                    'body' => []
                ],
                'send-reset-password-email' => [
                    'method' => 'POST',
                    'url' => $domain . 'auth/send-reset-password-email',
                    'body' => [
                        'email' => 'test1@mail.com',
                        'gatewayUrl' => null
                    ]
                ],
                'reset-password' => [
                    'method' => 'POST',
                    'url' => $domain . 'auth/reset-password',
                    'body' => [
                        'email' => 'test1@mail.com',
                        'password' => 'root21',
                        'password_confirmation' => 'root21',
                        'token' => 'TOKEN_FROM_EMAIL'
                    ]
                ],
            ],
            'role' => [
                'getAll' => [
                    'method' => 'GET',
                    'url' => $domain . 'role/get-all',
                    'body' => []
                ],
                'query' => [
                    'method' => 'GET',
                    'url' => $domain . 'role?filter[name]=ADMIN',
                    'body' => []
                ],
                'getById' => [
                    'method' => 'GET',
                    'url' => $domain . 'role/5',
                    'body' => []
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => $domain . 'role',
                    'body' => [
                        'name' => 'NewRole2',
                        'guardName' => 'web',
                        'permissionIds' => [1,2,3,4,5]
                    ]
                ],
                'update' => [
                    'method' => 'PATCH',
                    'url' => $domain . 'role',
                    'body' => [
                        'id"' => '4',
                        'name' => 'NewRole3',
                        'guardName' => 'web',
                        'permissionIds' => [5,6]
                    ]
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url' => $domain . 'role/5',
                    'body' => []
                ],
            ],
            'user' => [
                'getAll' => [
                    'method' => 'GET',
                    'url' => $domain . 'user/get-all',
                    'body' => []
                ],
                'query' => [
                    'method' => 'GET',
                    'url' => $domain . 'user?filter[confirmed]=false',
                    'body' => []
                ],
                'queryDeleted' => [
                    'method' => 'GET',
                    'url' => $domain . 'user/deleted',
                    'body' => []
                ],
                'getById' => [
                    'method' => 'GET',
                    'url' => $domain . 'user/3',
                    'body' => []
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => $domain . 'user',
                    'body' => [
                        'name' => 'Test3',
                        'email' => 'test3@mail.com',
                        'confirmed' => true,
                        'roles' => [3]
                    ]
                ],
                'update' => [
                    'method' => 'PATCH',
                    'url' => $domain . 'user',
                    'body' => [
                        'id"' => '4',
                        'name' => 'Test3B',
                        'email' => 'test3@mail.com',
                        'confirmed' => true,
                        'roles' => [3]
                    ]
                ],
                'changePassword' => [
                    'method' => 'PATCH',
                    'url' => $domain . 'user/3/change-password',
                    'body' => [
                        'password' => 'root21',
                        'password_confirmation' => 'root21'
                    ]
                ],
                'delete' => [
                    'method' => 'DELETE',
                    'url' => $domain . 'user/5',
                    'body' => []
                ],
                'restore' => [
                    'method' => 'POST',
                    'url' => $domain . 'user/5/restore',
                    'body' => []
                ],
            ]
        ]
    ];
});
