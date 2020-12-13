<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 'created';
    const STATUS_AWAITING_PAYMENT= 'awaiting_payment';
    const STATUS_PROCESSED = 'processed';
    const STATUS_CANCELED = 'canceled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'status',
       'user_id',
       'shipping'
    ];
    
    public function products(){
        return $this->belongsToMany('App\Product')
            ->withPivot('quantity','sub_total');
    }

    public function getSubTotalAttribute(){
        return $this->products->map(function($product){
            return $product->pivot->quantity * $product->pivot->sub_total;
        })->sum();
    }

    public function getTotalAttribute(){
        return $this->sub_total + $this->frete;
    }
}
