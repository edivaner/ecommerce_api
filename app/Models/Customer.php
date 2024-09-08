<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($consumer) {
            // Exclua o relacionamento com endereço e marque-o como excluído (soft delete)
            $consumer->address()->delete();

            // Exclua o relacionamento com usuário e marque-o como excluído (soft delete)
            $consumer->user()->delete();
        });
    }

    protected $fillable = [
        'user_id', 'address_id', 'telephone'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
