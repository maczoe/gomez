<?php

namespace App\Orchid\Screens\inventarios;

use App\Models\Contacto;
use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SalidasEditScreen extends Screen
{
    public $movimiento;


    /**
     * Query data.
     *
     * @return array
     */
    public function query(Movimiento $movimiento): iterable
    {
        return [
            'movimiento' => $movimiento
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->movimiento->exists ? 'Ver salida' : 'Crear nueva salida';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Mantenimmiento de salidas de inventario";
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
                ->canSee(!$this->movimiento->exists),

            Button::make('Eliminar')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->movimiento->exists),
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
                DateTimer::make('movimiento.fecha')
                    ->title('Fecha')
                    ->disabled($this->movimiento->exists),

                TextArea::make('movimiento.detalle')
                    ->title('Detalle')
                    ->rows(2)
                    ->maxlength(200)
                    ->disabled($this->movimiento->exists)
                    ->placeholder('Detalle de entrada'),

                Relation::make('movimiento.contacto_id')
                    ->fromModel(Contacto::class, 'nombre')
                    ->disabled($this->movimiento->exists)
                    ->title('Contacto'),

                Input::make('movimiento.cantidad')
                    ->type('number')
                    ->title('Cantidad')
                    ->disabled($this->movimiento->exists)
                    ->placeholder('Cantidad entrante'),

                Relation::make('movimiento.producto_id')
                    ->fromModel(Producto::class, 'nombre')
                    ->disabled($this->movimiento->exists)
                    ->title('Producto')

            ])
        ];
    }


    /**
     * @param Movimiento $entrada
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Movimiento $movimiento, Request $request)
    {
        $model = $movimiento->fill($request->get('movimiento'));
        $model->tipo = 'salida';
        $model->costo = $model->producto->costo * $model->cantidad;
        $model->save();

        $producto = Producto::find($model->producto->id);
        $existencia = DB::table('movimientos')->selectRaw("sum(if(tipo='entrada',cantidad,-cantidad)) as existencia")->where('producto_id', $producto->id)->first();
        $producto->existencia = $existencia->existencia;
        $producto->save();


        Alert::info('Salida guardada satifactoriamente.');

        return redirect()->route('platform.salida.list');
    }

    /**
     * @param Producto $producto
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Movimiento $movimiento)
    {
        $movimiento->delete();

        Alert::info('Salida borrada con exito.');

        return redirect()->route('platform.salida.list');
    }

    public function back() {
        return redirect()->route('platform.salida.list');
    }
}
