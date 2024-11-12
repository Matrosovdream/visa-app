<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\orderHelper;
use App\Models\Traveller;
use App\Models\User;
use App\Models\OrderCertificate;

class Order extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->hash = Str::random(32);
        });
    }

    protected $fillable = [
        'hash',
        'user_id',
        'total_price',
        'payment_method_id',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meta()
    {
        return $this->hasMany(OrderMeta::class);
    }

    public function travellers()
    {
        return $this->belongsToMany(Traveller::class, 'traveller_orders');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function getProduct() {
        return $this->cartProducts()->first()->product;
    }

    public function getOffer() {
        return $this->cartProducts()->first()->offer;
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function certificates() {
        return $this->hasMany(OrderCertificate::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
        });
    }

    public function isCompletedForm()
    {
        // Check travellers
        $travellers = $this->travellers;
        foreach( $travellers as $traveller ) {
            if( !$traveller->isCompletedForm() ) {
                return false;
            }
        }
        return true;
    }

    public function setStatus($status_id) {
        $this->status_id = $status_id;
        $this->save();
    }

    public function customerFields()
    {
        
        $metafields = $this->getListCustomerFields();

        foreach( $metafields as $field ) {
            $meta = $this->meta->where('key', $field)->first();
            if( $meta ) {
                $fields[$field] = $meta->value;
            } else {
                $fields[$field] = '';
            }
        }
        return $fields;
    }

    public function getTotal()
    {
        return $this->total_price;
    }

    public function getCurrency()
    {
        return $this->meta->where('key', 'currency')->first()->value;
    }

    public function getMeta($key)
    {
        return $this->meta->where('key', $key)->first()->value;
    }

    public function setMeta($key, $value)
    {
        $meta = $this->meta->where('key', $key)->first();
        if( $meta ) {
            $meta->value = $value;
            $meta->save();
        } else {
            $this->meta()->create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    public function getProgress() {
        return orderHelper::getProgress($this);
    }

    public function getCart() {
        return orderHelper::getCart($this);
    }

    public function countryFrom()
    {
        $country_id = $this->meta->where('key', 'country_from_id')->first()->value;
        return Country::find($country_id);
    }

    public function countryTo()
    {
        $country_id = $this->meta->where('key', 'country_to_id')->first()->value;
        return Country::find($country_id);
    }

    public function getListCustomerFields()
    {
        return ['full_name', 'email', 'phone', 'time_arrival'];
    }

    public static function getByHash($hash)
    {
        return static::where('hash', $hash)->first();
    }

    public static function getOrdersByUser($user_id)
    {
        return static::where('user_id', $user_id);
    }

    public static function checkUserAccess($user_id, $order_id)
    {
        return static::where('user_id', $user_id)->where('id', $order_id)->exists();
    }

    public function getTotalPriceAttribute($value) {
        return number_format($value, 0);
    }

    public function isPaid() {
        return $this->is_paid;
    }

    public function setPaid() {
        $this->is_paid = 1;
        $this->save();
    }

    public function setUnpaid() {
        $this->is_paid = 0;
        $this->save();
    }

}
