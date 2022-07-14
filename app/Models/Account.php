<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The one-to-many relationships of this Object.
     *
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'shipping_street',
        'shipping_city',
        'shipping_zip',
        'shipping_state',
        'shipping_country',
        'billing_street',
        'billing_city',
        'billing_zip',
        'billing_state',
        'billing_country',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'completed_at' => 'datetime',
        'hourly_rate' => 'double',
    ];

    /*
     * The functions to be executed when creating data for the model.
     *
     */
    public static function booted()
    {
        static::creating(function (Account $account) {
            $account->number = Str::random(6);
        });
    }
}
