<?php

namespace App\Orchid\Screens\ventas;

use App\Models\Venta;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class VentaListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'ventas' => Venta::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de Ventas';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de todas las ventas";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Nueva')
                ->icon('pencil')
                ->route('platform.venta.edit')
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
            Layout::table('ventas', [
                TD::make('id')
                ->render(function (Venta $venta) {
                    return Link::make($venta->id)
                        ->route('platform.venta.edit', $venta);
                }),
                TD::make('distribuidor')
                    ->render(function (Venta $venta) {
                        return $venta->contacto->nombre;
                    })
                    ->sort(),
                TD::make('fecha')->sort(),
                TD::make('total')->sort(),
                TD::make('estado')->sort(),
            ])
        ];
    }
}
