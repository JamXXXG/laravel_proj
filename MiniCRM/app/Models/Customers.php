<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    /** @use HasFactory<\Database\Factories\CustomersFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     *
     */
    protected $fillable = [
        'users_id',
        'name',
        'email',
        'phone',
        'notes',
        'avatar_path',
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class, 'customers_id');
    }
}
