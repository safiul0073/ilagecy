<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'supplier_id',
        'customer_id',
        'note',
        'order_id',
        'publisher_id',
        'status_admin',
        'status_caller',
        'caller_id',
        'update_admin',
        'update_caller',
        'status',
        'send_to_api',
        'country_code',
        'duplicate_id'
    ];

    public const CONFIRMED = 'confirmed';
    public const CANCELLED = 'cancelled';
    public const HOLD = 'hold';
    public const TRASH = 'trash';

    public const statuses = [
        self::CONFIRMED,
        self::CANCELLED,
        self::HOLD,
        self::TRASH
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
