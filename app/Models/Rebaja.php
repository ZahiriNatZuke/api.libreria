<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Rebaja extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rebajas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libro_id', 'cantidad', 'viejo_precio', 'viejo_importe', 'nuevo_precio', 'nuevo_importe', 'diferencia',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'libro_id',
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
        'viejo_precio' => 'decimal:2',
        'nuevo_precio' => 'decimal:2',
        'viejo_importe' => 'decimal:2',
        'nuevo_importe' => 'decimal:2',
        'diferencia' => 'decimal:2',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}
