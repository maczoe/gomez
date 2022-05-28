<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Ventas')
                ->icon('basket')
                ->route('platform.venta.list')
                ->title('Ventas'),

            Menu::make('Distribuidores')
                ->icon('user')
                ->route('platform.distribuidor.list'),

            Menu::make('Reporte de ventas')
                ->icon('bar-chart')
                ->route('platform.notfound'),


            Menu::make('Reporte de utilidades')
                ->icon('money')
                ->route('platform.notfound')
                ->divider(),


            Menu::make('Productos')
                ->title('Inventario')
                ->icon('modules')
                ->route('platform.producto.list'),

            Menu::make('Proveedores')
                ->icon('people')
                ->route('platform.proveedor.list'),

            Menu::make('Entradas')
                ->icon('login')
                ->route('platform.notfound'),

            Menu::make('Salidas')
                ->icon('logout')
                ->route('platform.notfound'),

            Menu::make('Reporte de inventarios')
                ->icon('bar-chart')
                ->route('platform.notfound')
                ->divider(),

            Menu::make('Gastos')
                ->title('Gastos')
                ->icon('dollar')
                ->route('platform.gasto.list'),

            Menu::make('Reporte de Gastos')
                ->icon('bar-chart')
                ->route('platform.notfound')
                ->divider(),

            Menu::make('Nuevo Proyecto')
                ->title('Proyectos')
                ->icon('task')
                ->route('platform.notfound'),

            Menu::make('Reporte de proyectos')
                ->icon('bar-chart')
                ->route('platform.notfound')

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Perfil')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
