<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Producto;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductoEditScreen extends Screen
{
    public $producto;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(Producto $producto): iterable
    {
        return [
            'producto' => $producto
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->producto->exists ? 'Editar producto' : 'Crear nuevo producto';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Mantenimmiento de productos";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Regresar')
                ->icon('arrow-left')
                ->method('back'),

            Button::make('Guardar')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->producto->exists),

            Button::make('Guardar')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->producto->exists),

            Button::make('Eliminar')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->producto->exists),
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
            Layout::rows([
                Input::make('producto.nombre')
                    ->title('Nombre')
                    ->placeholder('Nombre del producto'),

                TextArea::make('producto.descripcion')
                    ->title('Descripcion')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Descripcion del producto'),

                Input::make('producto.precio')
                    ->type('number')
                    ->title('Precio')
                    ->placeholder('Precio del producto'),

                Input::make('producto.costo')
                    ->type('number')
                    ->title('Costo')
                    ->placeholder('Costo del producto'),

                Input::make('producto.existencia')
                    ->type('number')
                    ->title('Existencia')
                    ->help('Existencia actual del producto')
                    ->disabled(),

            ])
        ];
    }


    /**
     * @param Producto $producto
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Producto $producto, Request $request)
    {
        $producto->fill($request->get('producto'))->save();

        Alert::info('Producto guardado satifactoriamente.');

        return redirect()->route('platform.producto.list');
    }

    /**
     * @param Producto $producto
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Producto $producto)
    {
        $producto->delete();

        Alert::info('Producto borrado con exito.');

        return redirect()->route('platform.producto.list');
    }

    public function back() {
        return redirect()->route('platform.producto.list');
    }
}
