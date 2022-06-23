<?php
namespace App\Repositories;

use App\Models\CartsModel;

class Carts extends CartsModel
{
    public static function getAllSession(){
        return Carts::table()
        ->select 
        (
            'carts.*',
            'product.product_name','product.product_code',
            'product.product_photo','product.product_flag',
            'product.product_description','product.product_price'
        )
        ->where('carts.customers-id', getCussSessions()->id)
        ->leftJoin('products','products.id','carts.products.id')
        ->get();
    }

    public static function countAllBySession(){
        return carts::table()
        ->where('carts.customer_id','products.id','carts.products_id')
        ->count();
    }

}