<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderedItem;
use App\Models\Order;
use App\Http\Requests\PlaceNewOrder;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class OrderedItemController extends Controller
{
    public function showAll() {

        $ordereditems = OrderedItem::all();
        $quantity = 0;
        $total = 0;
        $price = 0;
        //VAN cart állapota?
        if(Order::where('user_id',Auth::id())->where('status','CART')->first() != NULL){
            //VAN
            $not_empty = True;
            $cart_order_id = Order::where('user_id',Auth::id())->where('status','CART')->first()->id;
            $good_items = OrderedItem::where('order_id',$cart_order_id)->get();

            foreach($good_items as $ordereditem){
                $quantity = $ordereditem->quantity;
                $price = $ordereditem->item->price;
                $total = $total + $quantity * $price;
            }
        }else{
            //NINCS
            $total = 0;
            $not_empty = False;
            $good_items = [];
        }

        $ordereditem = OrderedItem::all();

        return view('cart', compact('good_items','total','not_empty'));
    }

    public function delete($itemId) {

        $ordereditems = OrderedItem::find($itemId);

        if($ordereditems === null){
            return redirect()->route('cart');
        }
        $ordereditems->delete();

        $allOrderedItems = OrderedItem::all();

        if($allOrderedItems->count() == 0){
            $order = Order::find($ordereditems->order_id);
            $order->delete();
            return redirect()->route('cart')->with('ordereditem.deleted',true);
        }else{
            return redirect()->route('cart')->with('ordereditem.deleted',true);
        }
    }

    public function validateOrder(Request $request){
        
        $validated = $request->validate([
            'address' => 'required|min:5',
            'comment' => 'max:500',
            'payment_method' => 'required|in:CARD,CASH',
        ]);
        
        $current_user_id = Auth::user()->id;
        
        $order = Order::where('user_id','=', $current_user_id)->where('status','=','CART')->first();
        $order->update([
            'user_id' => $current_user_id,
            'address' => $request->input('address'),
            'comment' => $request->input('comment'),
            'payment_method' => $request->input('payment_method'),
            'status' => "RECEIVED",
            'received_on' => Carbon::now(),
        ]);
        return redirect()->route('orders');
    }

    
}
