<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model de Pedido
 *
 * @property int                    $id
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $deleted_at
 *
 * @property-read Cliente           $cliente
 * @property-read Collection|Pastel $pasteis
 *
 * @package App\Models
 */
class Pedido extends Model {
    use SoftDeletes;

    protected $table = 'pedidos';

    protected $casts = [
        'id'         => 'int',
        'cliente_id' => 'int',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo|Cliente
     */
    public function cliente() : BelongsTo {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * @return BelongsToMany|Pastel
     */
    public function pasteis() : BelongsToMany {
        return $this
            ->belongsToMany(Pastel::class, 'pedidos_pasteis')
            ->withPivot(['quantidade'])
            ->withCasts(['quantidade' => 'int']);
    }
}
