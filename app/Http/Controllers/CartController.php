<?php

namespace App\Http\Controllers;

use App\Repositories\Carts;
use App\Repositories\TrOrders;
use App\Repositories\TrOrdersDetail;

use Illuminate\Http\Request;


class CartController extends Controller
{
    public static function getIndex(){
        $data['carts'] = Carts::getAllBySession();

        return view('front.cart', $data);
    }
    public function getAdd(Request $request){
        $cart = new carts();
        $carts->product_id = $request->products_id;
        $carts->customer_id = getCustSessions()->id;
        $cart->save();

        return redirect('cart')->with('success','success add to cart');

        
    }
    public function getDelete($id){
        $cart = Carts::findById($id);
        if($cart->id == null){
            return redirect()->back()->with('danger','No Data Found');
        }
        $cart->delete();
        return redirect()->back()->with('success','success delete data');
    }
    public function postCheckout(Request $request){
        $carts = Carts::getAllBySession();
        if(count($carts)==0){
            return redirect()->back()->with('danger', 'Cart Is Empty');
        }
        $total_price = 0;
        foreach($carts as $cart){
            $total_price += $cart->product_price;
        }

        $order = new TrOrders();
        $order->code_transaction = generateCodeTransaction();
        $order->total_price = $total_price;
        $order->customers_id = getCustSessions()->id;
        $order->status = "SUCCESS";
        $order->save();

        foreach ($carts as $cart){
            $order_detail = new TrOrdersDetail();
            $order_detail->tr_orders_id = $order->id;
            $order_detail->products_id = $cart->product_id;
            $order_detail->price = $cart->product_price;
            $order_detail->save();
    }
    Carts::deleteBy('customer_id', getCustSessions()->id);
    return redirect('/')->with('succes','succes checkout');

    }
    
}