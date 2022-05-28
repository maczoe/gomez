<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Venta extends Model
{
    use HasFactory;
    use AsSource;


    /**
     * @var array
     */
    protected $fillable = [
        'fecha',
        'contacto_id',
        'costo',
        'total',
        'estado',
        'observaciones',
    ];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }

    public function lineas() {
        return $this->hasMany(Lineav::class);
    }
}
