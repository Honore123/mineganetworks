<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingBook extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
