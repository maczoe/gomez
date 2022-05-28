<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Movimiento;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class SalidasListScreen extends Screen
{
     /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'salidas' => Movimiento::where('tipo', 'salida')->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de salidas de inventario';
    }

     /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de salidas de inventario";
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
                ->route('platform.salida.edit')
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
            Layout::table('salidas', [
                TD::make('id')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->id)
                        ->route('platform.salida.edit', $movimiento);
                }),
                TD::make('producto')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->producto->nombre)
                        ->route('platform.salida.edit', $movimiento);
                })->sort(),
                TD::make('contacto')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->contacto->nombre)
                        ->route('platform.salida.edit', $movimiento);
                })->sort(),
                TD::make('fecha')->sort(),
                TD::make('cantidad')->sort(),
                TD::make('detalle')->sort(),
            ])
        ];
    }
}
