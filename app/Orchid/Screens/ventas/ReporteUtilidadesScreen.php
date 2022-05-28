<?php

namespace App\Orchid\Screens\ventas;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ReporteUtilidadesScreen extends Screen
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

        $result = DB::table('lineasv')
        ->selectRaw("sum(lineasv.precio) as total, max(productos.nombre) as producto, sum(lineasv.cantidad) as cantidad, sum(lineasv.costo) as costo, sum(lineasv.precio)-sum(lineasv.costo) as utilidad")
        ->join('productos', 'productos.id', '=', 'lineasv.producto_id')
        ->join('ventas', 'ventas.id', '=', 'lineasv.venta_id')
        ->whereBetween('ventas.fecha', [$start, $end])
        ->groupBy('lineasv.producto_id')
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
        return 'Reporte de utilidades';
    }

      /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Reporte de utilidades por Producto";
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
                TD::make('cantidad unidades')->render(function ($result) {
                    return $result->cantidad;
                }),
                TD::make('precio')->render(function ($result) {
                    return round($result->total,2);
                }),
                TD::make('costo')->render(function ($result) {
                    return round($result->costo,2);
                }),
                TD::make('utilidad')->render(function ($result) {
                    return round($result->utilidad,2);
                }),
            ])->title('Resultados')
        ];
    }

    public function filtrar(Request $request) {
        $rango = $request->get('rango');
        return redirect()->route('platform.utilidad.report', $rango);
    }
}
