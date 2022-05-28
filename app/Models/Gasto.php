<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Gasto extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'documento',
        'detalle',
        'precio',
        'contacto_id',
        'fecha',
    ];

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}
