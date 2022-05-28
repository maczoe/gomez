<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Movimiento;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class EntradasListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'entradas' => Movimiento::where('tipo', 'entrada')->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de entradas de inventario';
    }

     /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de entradas de inventario";
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
                ->route('platform.entrada.edit')
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
            Layout::table('entradas', [
                TD::make('id')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->id)
                        ->route('platform.entrada.edit', $movimiento);
                }),
                TD::make('producto')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->producto->nombre)
                        ->route('platform.entrada.edit', $movimiento);
                })->sort(),
                TD::make('contacto')
                ->render(function (Movimiento $movimiento) {
                    return Link::make($movimiento->contacto->nombre)
                        ->route('platform.entrada.edit', $movimiento);
                })->sort(),
                TD::make('fecha')->sort(),
                TD::make('cantidad')->sort(),
                TD::make('detalle')->sort(),
            ])
        ];
    }
}
