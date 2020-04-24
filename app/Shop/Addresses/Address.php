<?php

namespace App\Shop\Addresses;

use App\Shop\Customers\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'alias', 'address_1', 'address_2', 'zip', 'city_id', 'province_id', 'country_id', 'customer_id', 'status'
    ];

    protected $hidden = [];

    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
