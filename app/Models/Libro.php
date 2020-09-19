<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Libro extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'libros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'editorial_id', 'titulo', 'autor', 'anno', 'precio', 'cantidad', 'categoria', 'importe',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'editorial_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'cantidad' => 'integer',
        'precio' => 'decimal:2',
        'importe' => 'decimal:2'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'generos',
        'editorial',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function (Libro $libro) {
            $libro->actualizaciones()->create([
                'accion' => 'Entrada',
                'cantidad' => $libro->cantidad,
                'precio' => $libro->precio
            ]);
        });
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class);
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function actualizaciones()
    {
        return $this->hasMany(Actualizacion::class)->orderBy('created_at', 'ASC');
    }

    public function defectuosos()
    {
        return $this->hasMany(Defectuoso::class)
            ->orderBy('created_at', 'ASC');
    }

    public function donaciones()
    {
        return $this->hasMany(Donacion::class)
            ->orderBy('created_at', 'ASC');
    }

    public function rebajas()
    {
        return $this->hasMany(Rebaja::class)
            ->orderBy('created_at', 'DESC');
    }

    public function traslados()
    {
        return $this->hasMany(Traslado::class)
            ->orderBy('created_at', 'ASC');
    }

    public function ventaTransferencias()
    {
        return $this->hasMany(VentaTransferencia::class)
            ->orderBy('created_at', 'ASC');
    }
}
