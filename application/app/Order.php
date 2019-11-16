<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'price'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'customer_id',
        'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function products()
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot('quantity');
    }
}
