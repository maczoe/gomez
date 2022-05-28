<?php

namespace App\Orchid\Screens\ventas;

use App\Models\Contacto;
use App\Models\Lineav;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class VentaEditScreen extends Screen
{

    public $venta;
    public $lineas;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Venta $venta): iterable
    {
        return [
            'venta' => $venta,
            'lineas' => $venta->lineas
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->venta->exists ? 'Detalle de venta' : 'Crear nueva venta';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Detallle de ventas";
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
                ->canSee(!$this->venta->exists),

            Button::make('Anular')
                ->icon('cross')
                ->type(Color::DANGER())
                ->method('anular')
                ->canSee($this->venta->estado == 'finalizado'),

            Button::make('Eliminar')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->venta->exists),
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
                DateTimer::make('venta.fecha')
                    ->title('Fecha')
                    ->disabled($this->venta->exists)
                    ->horizontal(),

                Relation::make('venta.contacto_id')
                    ->fromModel(Contacto::class, 'nombre')
                    ->applyScope('proveedor')
                    ->disabled($this->venta->exists)
                    ->title('Distribuidor')
                    ->horizontal(),

                TextArea::make('venta.obeservaciones')
                    ->title('Observaciones')
                    ->rows(2)
                    ->maxlength(200)
                    ->disabled($this->venta->exists)
                    ->placeholder('Observaciones')
                    ->horizontal(),
            ]),
            Layout::rows([
                Button::make('Agregar Linea')
                ->method('anular')
                ->icon('plus')
                ->type(Color::PRIMARY())
            ])->canSee(!$this->venta->exists),
            Layout::table('venta.lineas', [
                TD::make('cantidad')
                    ->render(function (Lineav $linea) {
                        return Input::make('linea.cantidad')
                            ->disabled($this->venta->exists)
                            ->value($linea->cantidad)
                            ->type('number');
                    }),
                TD::make('producto')
                    ->render(function (Lineav $linea) {
                        return Relation::make('linea.producto_id')
                            ->disabled($this->venta->exists)
                            ->fromModel(Producto::class, 'nombre')
                            ->value($linea->producto);
                    }),
                TD::make('unitario')
                    ->render(function (Lineav $linea) {
                        return Input::make('linea.unitario')
                        ->value($linea->unitario)
                        ->disabled($this->venta->exists)
                        ->type('number');
                    }),
                TD::make('total')
                    ->render(function (Lineav $linea) {
                        return Input::make('linea.precio')
                            ->disabled($this->venta->exists)
                            ->type('number')
                            ->value($linea->precio)
                            ->disabled();
                    }),
            ]),
            Layout::rows([
                Input::make('venta.total')
                        ->disabled()
                        ->title('TOTAL = ')
                        ->horizontal()
                        ->type('number')
            ])
        ];
    }

    /**
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Venta $venta, Request $request)
    {
        $model = $venta->fill($request->get('venta'));
        $model->estado = 'finalizado';
        $model->save();

        Alert::info('Venta guardada satifactoriamente.');

        return redirect()->route('platform.venta.list');
    }

    /**
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Venta $venta)
    {
        $venta->delete();

        Alert::info('Venta borrada con exito.');

        return redirect()->route('platform.venta.list');
    }

    public function back()
    {
        return redirect()->route('platform.venta.list');
    }

    public function anular(Venta $venta, Request $request)
    {
        $model = $venta;
        $model->estado = "anulado";
        $model->save();

        Alert::info('Venta anulada satifactoriamente.');

        return redirect()->route('platform.venta.list');
    }
}
