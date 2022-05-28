<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Producto extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'costo',
        'existencia',
    ];
}
