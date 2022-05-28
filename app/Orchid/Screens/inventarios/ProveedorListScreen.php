<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Contacto;
use Orchid\Screen\Actions\Link;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ProveedorListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'proveedores' => Contacto::where('tipo', 'proveedor')->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de Proveedores';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de todos los proveedores";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Nuevo')
                ->icon('pencil')
                ->route('platform.proveedor.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('proveedores', [
                TD::make('id')
                ->render(function (Contacto $contacto) {
                    return Link::make($contacto->id)
                        ->route('platform.proveedor.edit', $contacto);
                }),
                TD::make('nombre')
                ->render(function (Contacto $contacto) {
                    return Link::make($contacto->nombre)
                        ->route('platform.proveedor.edit', $contacto);
                })->sort(),
                TD::make('direccion')->sort(),
                TD::make('nit')->sort(),
                TD::make('telefono')->sort(),
                TD::make('email')->sort(),
            ])
        ];
    }
}
