<?php

namespace App\Orchid\Screens\ventas;

use App\Models\Contacto;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DistribuidorEditScreen extends Screen
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
        return  $this->contacto->exists ? 'Editar distribuidor' : 'Crear nuevo distribuidor';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Mantenimmiento de distribuidores";
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
                    ->placeholder('Nombre del distribuidor'),

                TextArea::make('contacto.direccion')
                    ->title('Direccion')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Dirección del distribuidor'),

                Input::make('contacto.nit')
                    ->title('Nit')
                    ->placeholder('Nit del distribuidor'),

                Input::make('contacto.telefono')
                    ->title('Telefono')
                    ->mask('(999) 9999-9999')
                    ->placeholder('Telefono del distribuidor'),

                Input::make('contacto.email')
                    ->title('Email')
                    ->type('email')
                    ->placeholder('Email del distribuidor'),
            ])
        ];
    }

    /**
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Contacto $contacto, Request $request)
    {
        $model = $contacto->fill($request->get('contacto'));
        $model->tipo = 'cliente';
        $model->save();

        Alert::info('Distribuidor guardado satifactoriamente.');

        return redirect()->route('platform.distribuidor.list');
    }

    /**
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Contacto $contacto)
    {
        $contacto->delete();

        Alert::info('Distribuidor borrado con exito.');

        return redirect()->route('platform.distribuidor.list');
    }

    public function back() {
        return redirect()->route('platform.distribuidor.list');
    }
}

