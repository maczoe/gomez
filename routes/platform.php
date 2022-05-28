<?php

declare(strict_types=1);

use App\Orchid\Screens\ventas\DistribuidorEditScreen;
use App\Orchid\Screens\ventas\DistribuidorListScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Examples\NoDisponible;
use App\Orchid\Screens\gastos\GastoEditScreen;
use App\Orchid\Screens\gastos\GastoListScreen;
use App\Orchid\Screens\inventarios\EntradasEditScreen;
use App\Orchid\Screens\inventarios\EntradasListScreen;
use App\Orchid\Screens\inventarios\ProductoEditScreen;
use App\Orchid\Screens\inventarios\ProductoListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\inventarios\ProveedorEditScreen;
use App\Orchid\Screens\inventarios\ProveedorListScreen;
use App\Orchid\Screens\inventarios\ReporteScreen;
use App\Orchid\Screens\inventarios\SalidasEditScreen;
use App\Orchid\Screens\inventarios\SalidasListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\ventas\VentaEditScreen;
use App\Orchid\Screens\ventas\VentaListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

Route::screen('producto/{producto?}', ProductoEditScreen::class)
    ->name('platform.producto.edit');

Route::screen('productos', ProductoListScreen::class)
    ->name('platform.producto.list');

Route::screen('distribuidor/{contacto?}', DistribuidorEditScreen::class)
    ->name('platform.distribuidor.edit');

Route::screen('distribuidores', DistribuidorListScreen::class)
    ->name('platform.distribuidor.list');

Route::screen('proveedor/{contacto?}', ProveedorEditScreen::class)
    ->name('platform.proveedor.edit');

Route::screen('proveedores', ProveedorListScreen::class)
    ->name('platform.proveedor.list');

Route::screen('gasto/{gasto?}', GastoEditScreen::class)
    ->name('platform.gasto.edit');

Route::screen('gastos', GastoListScreen::class)
    ->name('platform.gasto.list');

Route::screen('venta/{venta?}', VentaEditScreen::class)
    ->name('platform.venta.edit');

Route::screen('ventas', VentaListScreen::class)
    ->name('platform.venta.list');

Route::screen('entrada/{movimiento?}', EntradasEditScreen::class)
    ->name('platform.entrada.edit');

Route::screen('entradas', EntradasListScreen::class)
    ->name('platform.entrada.list');

Route::screen('salida/{movimiento?}', SalidasEditScreen::class)
    ->name('platform.salida.edit');

Route::screen('salidas', SalidasListScreen::class)
    ->name('platform.salida.list');

Route::screen('inventarios', ReporteScreen::class)
    ->name('platform.inventarios.list');

Route::screen('notfound', NoDisponible::class)->name('platform.notfound');
