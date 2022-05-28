<?php

namespace App\Orchid\Screens\inventarios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ReporteScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        if($request->get('start')) {
            $start = $request->get('start');
        } else {
            $start = Carbon::now()->startOfMonth();
        }

        if($request->get('end')) {
            $end = $request->get('end');
        } else {
            $end = Carbon::now()->endOfMonth();
        }

        $result = DB::table('movimientos')
        ->selectRaw("sum(if(movimientos.tipo='entrada',movimientos.cantidad,-movimientos.cantidad)) as cantidad, max(productos.nombre) as producto, sum(movimientos.costo) as costo")
        ->join('productos', 'productos.id', '=', 'movimientos.producto_id')
        ->whereBetween('fecha', [$start, $end])
        ->groupBy('producto_id')
        ->get();

        return [
            'results' => $result
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Reporte de inventarios';
    }

      /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Reporte de inventarios";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
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
                DateRange::make('rango')
                ->title('Fechas'),
                Button::make('Aplicar')
                ->icon('check')
                ->type(Color::PRIMARY())
                ->method('filtrar'),
            ])->title('Filtros'),
            Layout::table('results', [
                TD::make('producto')->render(function ($result) {
                    return $result->producto;
                }),
                TD::make('cantidad')->render(function ($result) {
                    return $result->cantidad;
                }),
                TD::make('costo valorado')->render(function ($result) {
                    return round($result->costo,2);
                }),
            ])->title('Resultados')
        ];
    }

    public function filtrar(Request $request) {
        $rango = $request->get('rango');
        return redirect()->route('platform.inventarios.list', $rango);
    }
}
