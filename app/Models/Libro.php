<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            $libro->registros()->create([
                'accion' => 'Entrada',
                'cantidad' => $libro->cantidad,
                'precio' => $libro->precio
            ]);
        });
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(Genero::class);
    }

    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class);
    }

    public function registros(): HasMany
    {
        return $this->hasMany(Registros::class)->orderBy('created_at', 'ASC');
    }

    public function defectuosos(): HasMany
    {
        return $this->hasMany(Defectuoso::class)
            ->orderBy('created_at', 'ASC');
    }

    public function donaciones(): HasMany
    {
        return $this->hasMany(Donacion::class)
            ->orderBy('created_at', 'ASC');
    }

    public function rebajas(): HasMany
    {
        return $this->hasMany(Rebaja::class)
            ->orderBy('created_at', 'DESC');
    }

    public function traslados(): HasMany
    {
        return $this->hasMany(Traslado::class)
            ->orderBy('created_at', 'ASC');
    }
}
