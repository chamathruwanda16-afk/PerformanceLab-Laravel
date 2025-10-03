<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','exists:products,id'],
            'items.*.qty' => ['required','integer','min:1'],
        ]);

        $user = $request->user();
        $subtotal = 0;
        foreach ($data['items'] as $i) {
            $price = Product::find($i['product_id'])->price;
            $subtotal += $price * $i['qty'];
        }
        $order = Order::create([
            'user_id'=>$user->id,'status'=>'pending',
            'subtotal'=>$subtotal,'tax'=>0,'shipping'=>0,'total'=>$subtotal
        ]);
        foreach ($data['items'] as $i) {
            $price = Product::find($i['product_id'])->price;
            OrderItem::create([
                'order_id'=>$order->id,'product_id'=>$i['product_id'],'qty'=>$i['qty'],'unit_price'=>$price
            ]);
        }
        return response()->json($order->load('items.product'), 201);
    }
}
