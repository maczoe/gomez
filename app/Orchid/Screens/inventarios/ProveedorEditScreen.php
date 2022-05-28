<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Contacto;
use Illuminate\Http\Request;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProveedorEditScreen extends Screen
{

    public $contacto;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Contacto $contacto): iterable
    {
        return [
            'contacto' => $contacto
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->contacto->exists ? 'Editar proveedor' : 'Crear nuevo proveedor';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Mantenimmiento de proveedores";
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
                ->canSee(!$this->contacto->exists),

            Button::make('Guardar')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->contacto->exists),

            Button::make('Eliminar')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->contacto->exists),
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
                Input::make('contacto.nombre')
                    ->title('Nombre')
                    ->placeholder('Nombre del proveedor'),

                TextArea::make('contacto.direccion')
                    ->title('Direccion')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Dirección del proveedor'),

                Input::make('contacto.nit')
                    ->title('Nit')
                    ->placeholder('Nit del proveedor'),

                Input::make('contacto.telefono')
                    ->title('Telefono')
                    ->mask('(999) 9999-9999')
                    ->placeholder('Telefono del proveedor'),

                Input::make('contacto.email')
                    ->title('Email')
                    ->type('email')
                    ->placeholder('Email del proveedor'),

            ])
        ];
    }


    /**
     * @param Producto $producto
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Contacto $contacto, Request $request)
    {
        $model = $contacto->fill($request->get('contacto'));
        $model->tipo = 'proveedor';
        $model->save();

        Alert::info('Proveedor guardado satifactoriamente.');

        return redirect()->route('platform.proveedor.list');
    }

    /**
     * @param Producto $producto
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Contacto $contacto)
    {
        $contacto->delete();

        Alert::info('Proveedor borrado con exito.');

        return redirect()->route('platform.proveedor.list');
    }

    public function back() {
        return redirect()->route('platform.proveedor.list');
    }
}
