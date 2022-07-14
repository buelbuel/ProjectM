<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'salutation',
        'title',
        'shipping_street',
        'shipping_city',
        'shipping_zip',
        'shipping_state',
        'shipping_country',
        'mobile',
        'phone',
        'email',
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
    ];

    /*
     * The functions to be executed when creating data for the model.
     *
     */
    public static function booted()
    {
        static::creating(function (Contact $contact) {
            $contact->number = Str::random(6);
        });
    }
}
