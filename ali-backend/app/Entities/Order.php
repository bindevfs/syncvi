<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities;
 */
class Order extends Model implements Transformable
{
    use TransformableTrait;

    const PERCENT_CHARGE = 0.035;

    const PERCENT_DEPOSIT_MIN = 0.6;

    const STATUS_CART = 0;

    const STATUS_PROCESSING = 1;

    const STATUS_AUTHENCATED = 2;

    const STATUS_PAID = 3;

    const STATUS_WAIT_SHIPPING = 4;

    const STATUS_SHIPPING = 5;

    const STATUS_FINISH = 6;

    const STATUS_REQUIRE_REJECT = 7;

    const STATUS_CANCEL = 8;

    const STATUS_ORTHER = 9;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sum_price', 'shop_id', 'status', 'payment',
        'description', 'note', 'deleted_at', 'charge', 'deposit', 'created_at', 'delivery_date'
    ];

}
