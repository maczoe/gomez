<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Contacto extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'nit',
        'telefono',
        'email',
        'tipo',
    ];

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeProveedor(Builder $query)
    {
        return $query->where('tipo', 'proveedor');
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeDistribuidor(Builder $query)
    {
        return $query->where('tipo', 'cliente');
    }

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }
}
