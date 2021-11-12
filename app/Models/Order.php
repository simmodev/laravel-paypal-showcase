<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'description',
        'status',
        'reference_number',
    ];

    public static function getProductPrice($value){
        switch($value){
            case 'product1':
                $price  = '1.00';
                break;
            case 'product2':
                $price  = '2.00';
                break;
            case 'product3':
                $price  = '3.00';
                break;
            default:
                $price = '0.00';
        }
        return $price;
    }

    public static function getProductDescription($value){
        switch($value){
            case 'product1':
                $description  = 'this product costs $1';
                break;
            case 'product2':
                $description  = 'this product costs $2';
                break;
            case 'product3':
                $description  = 'this product costs $3';
                break;
            default:
                $description = 'Invalid Product';
        }
        return $description;
    }
}
