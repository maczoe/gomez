<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Lineav extends Model
{
    use HasFactory;
    use AsSource;

    protected $table = 'lineasv';


    /**
     * @var array
     */
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'unitario',
        'precio',
        'costo',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
