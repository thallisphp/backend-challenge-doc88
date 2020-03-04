<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model de Pastel
 *
 * @property int    $id
 * @property string $nome
 * @property float  $preco
 *
 * @package App\Models
 */
class Pastel extends Model {
    use SoftDeletes;

    protected $table = 'pasteis';

    protected $fillable = [
        'nome',
        'preco',
    ];

    protected $casts = [
        'preco' => 'float',
    ];
}
