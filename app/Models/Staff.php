<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($staff) {
            // Exclua o relacionamento com endereço e marque-o como excluído (soft delete)
            $staff->address()->delete();

            // Exclua o relacionamento com usuário e marque-o como excluído (soft delete)
            $staff->user()->delete();
        });
    }

    protected $fillable = [
        'user_id', 'address_id'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
