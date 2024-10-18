<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


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

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
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

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
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

    public function getTotal()
    {
        return $this->total_price;
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

    public function getTravellers() {

        $travellers = $this->meta->where('key', 'travelers')->first()->value;
        $data =  json_decode($travellers, true);

        $groupedData = [];
        foreach ($data as $key => $values) {
            foreach ($values as $index => $value) {
                $groupedData[$index][$key] = $value;
            }
        }

        return $groupedData;

    }

    public static function getByHash($hash)
    {
        return static::where('hash', $hash)->first();
    }

    public function getListCustomerFields()
    {
        return ['full_name', 'email', 'phone', 'time_arrival'];
    }

}
