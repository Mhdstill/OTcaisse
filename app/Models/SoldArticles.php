<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldArticles extends Model
{
    use HasFactory;
    protected $fillable =[
        'price',
        'quantity',
        'sale_id',
        'article_id',
        'description',
     ];
}


