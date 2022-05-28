<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Producto;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ProductoListScreen extends Screen
{


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'productos' => Producto::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Listado de productos';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Lista de todos los productos";
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
                ->route('platform.producto.edit')
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
            Layout::table('productos', [
                TD::make('id')
                ->render(function (Producto $producto) {
                    return Link::make($producto->id)
                        ->route('platform.producto.edit', $producto);
                }),
                TD::make('nombre')
                ->render(function (Producto $producto) {
                    return Link::make($producto->nombre)
                        ->route('platform.producto.edit', $producto);
                })->sort(),
                TD::make('precio')->sort(),
                TD::make('costo')->sort(),
                TD::make('existencia')->sort(),
            ])
        ];
    }
}
