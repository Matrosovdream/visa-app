<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content\File;

class OrderCertificate extends Model
{
    protected $table = 'order_certificates';

    protected $fillable = [
        'order_id',
        'file_id',
        'description',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
