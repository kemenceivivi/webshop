<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderedItem;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function showAllOrders(){
       
        if(Order::where('user_id',Auth::id())->first() != NULL){
            $orders = Order::where('user_id',Auth::id())->where('status','!=','CART')->get();
                
        }else{
            $orders = [];
        }
        return view('orders', compact('orders'));
    }

    public function allOrdersAdmin(){
        if(Auth::user()->is_admin){
            $orders = Order::where('status','RECEIVED')->get();
            return view('manage-orders', compact('orders'));
        }else{
            return redirect()->route('home');
        }        
        
    }

    public function processedOrders(){
        if(Auth::user()->is_admin){
            $orders = Order::where('processed_on','!=',NULL)->get();
            return view('processed', compact('orders'));
        }else{
            return redirect()->route('home');
        }  
    }

    public function manageReceived($id){
        if(Auth::user()->is_admin){
            $order = Order::find($id);
            return view('checkreceived', compact('order'));
        }else{
            return redirect()->route('home');
        }  
    }

    public function acceptOrder($orderId){
        $do_accept = Order::find($orderId);
        $do_accept->status = "ACCEPTED";
        $do_accept->processed_on = Carbon::now();
        $do_accept->save();

        $orders = Order::where('status','RECEIVED')->get();

        return view('manage-orders', compact('orders'));
    }

    public function rejectOrder($orderId){
        $do_accept = Order::find($orderId);
        $do_accept->status = "REJECTED";
        $do_accept->processed_on = Carbon::now();
        $do_accept->save();

        $orders = Order::where('status','RECEIVED')->get();

        return view('manage-orders', compact('orders'));
    }

}
