<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Movimiento extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'contacto_id',
        'producto_id',
        'fecha',
        'tipo',
        'cantidad',
        'costo',
        'detalle'
    ];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
