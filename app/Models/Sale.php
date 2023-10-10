<?php

namespace App\Models;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'quantity',
        'price',
        'payment_method',
        'status',
        'commentary'
    ];
}
