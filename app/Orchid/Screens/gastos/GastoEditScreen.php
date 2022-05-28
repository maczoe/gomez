<?php

namespace App\Orchid\Screens\gastos;

use App\Models\Contacto;
use App\Models\Gasto;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class GastoEditScreen extends Screen
{

    public $gasto;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Gasto $gasto): iterable
    {
        return [
            'gasto' => $gasto
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->gasto->exists ? 'Editar gasto' : 'Crear nuevo gasto';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Mantenimmiento de gastos";
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
                ->canSee(!$this->gasto->exists),

            Button::make('Guardar')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->gasto->exists),

            Button::make('Eliminar')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->gasto->exists),
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

                Relation::make('gasto.contacto_id')
                    ->fromModel(Contacto::class, 'nombre')
                    ->applyScope('proveedor')
                    ->title('Proveedor'),

                Input::make('gasto.documento')
                    ->title('Documento')
                    ->placeholder('Documento de referencia'),

                DateTimer::make('gasto.fecha')
                    ->title('Opening date'),

                TextArea::make('gasto.detalle')
                    ->title('Detalle')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Detalle del gasto'),

                Input::make('gasto.precio')
                    ->type('number')
                    ->title('Precio')
                    ->placeholder('Precio del gasto'),

            ])
        ];
    }


    /**
     * @param Gasto $producto
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Gasto $gasto, Request $request)
    {
        $gasto->fill($request->get('gasto'))->save();

        Alert::info('Gasto guardado satifactoriamente.');

        return redirect()->route('platform.gasto.list');
    }

    /**
     * @param Gasto $gasto
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Gasto $gasto)
    {
        $gasto->delete();

        Alert::info('Gasto borrado con exito.');

        return redirect()->route('platform.gasto.list');
    }

    public function back() {
        return redirect()->route('platform.gasto.list');
    }
}
