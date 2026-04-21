<?php

use Src\Route;

//методичка
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\User::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\User::class, 'login']);
Route::add('GET', '/logout', [Controller\User::class, 'logout']);
// Маршруты Администратора
Route::add(['GET', 'POST'], '/admin/add-hr', [Controller\Admin::class, 'addHr'])
    ->middleware('auth');
// Маршруты Отдела Кадров
Route::add(['GET', 'POST'], '/hr/departments', [Controller\Hr::class, 'departments'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/hr/employees', [Controller\Hr::class, 'employees'])
    ->middleware('auth');
Route::add('GET', '/hr/reports', [Controller\Hr::class, 'reports'])
    ->middleware('auth');