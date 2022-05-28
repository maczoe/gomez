<?php

namespace App\Orchid\Screens\gastos;

use App\Models\Gasto;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class GastoListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'gastos' => Gasto::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Listado de gastos';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de todos los gastos";
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
                ->route('platform.gasto.edit')
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
            Layout::table('gastos', [
                TD::make('id')
                ->render(function (Gasto $gasto) {
                    return Link::make($gasto->id)
                        ->route('platform.gasto.edit', $gasto);
                }),
                TD::make('documento')
                ->render(function (Gasto $gasto) {
                    return Link::make($gasto->documento)
                        ->route('platform.gasto.edit', $gasto);
                })->sort(),
                TD::make('proveedor')
                    ->render(function (Gasto $gasto) {
                        return $gasto->contacto->nombre;
                    })
                    ->sort(),
                TD::make('fecha')->sort(),
                TD::make('detalle'),
                TD::make('precio')->sort(),
            ])
        ];
    }
}
