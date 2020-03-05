<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * Model de Cliente
 *
 * @property int         $id
 * @property string      $nome
 * @property string      $email
 * @property string      $telefone
 * @property string      $data_de_nascimento
 * @property string      $endereco
 * @property string|null $complemento
 * @property string      $bairro
 * @property string      $cep
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @package App\Models
 */
class Cliente extends Model {
    use SoftDeletes;
    use Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_de_nascimento',
        'endereco',
        'complemento',
        'bairro',
        'cep',
    ];

    protected $casts = [
        'id',
    ];

    protected $dates = [
        'data_de_nascimento',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function routeNotificationFor($driver, $notification = null) {
        return $this->email;
    }
}
