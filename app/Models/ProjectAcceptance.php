<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAcceptance extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function purchase()
    {
        return $this->hasOne(CustomerPurchaseOrder::class, 'id', 'customer_purchase_order_id');
    }
}
