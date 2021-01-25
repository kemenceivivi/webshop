<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\OrderedItem;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Auth;
use Storage;

class ItemController extends Controller
{
    public function showAll() {

        $items = Item::all();    
        if(Auth::check()){
            if(Auth::user()->is_admin){
                $items = Item::withTrashed()->get();
            }
        }
      
        $categories = Category::all();
    
        return view('items', compact('items','categories'));
    }

    public function addToCart(Request $request,$itemId,$quantity){
        $validated = $request->validate([
            'quantity' => 'required|max:10|min:1'
        ]);

        $_itemId = $itemId;
        $_quantity = $request->input('quantity');
        //error_log($_quantity);
        
        //van -e már ilyen userünk az orders táblában
        if(Order::where('user_id',Auth::id())->first() != NULL){
            //VAN
            
            //van -e már ennek a usernek CART állapota
            if(Order::where('user_id',Auth::id())->where('status','CART')->first() != NULL){
                //VAN
                $cart_order_id = Order::where('user_id',Auth::id())->where('status','CART')->first()->id;
                //benne van -e már az item
                if(OrderedItem::where('order_id',$cart_order_id)->where('item_id',$itemId)->first()){
                    //IGEN
                    //jelenlegi quantityje
                    $this_item = OrderedItem::where('order_id',$cart_order_id)->where('item_id',$itemId)->first();
                    $oldQuantity = $this_item->quantity;                
                    //elmentjük új quantityvel
                    $this_item->quantity = $oldQuantity + $_quantity;
                    $this_item->save();

                    $ordereditem = OrderedItem::all();
                }else{
                    //NEM
                    $new_item = new OrderedItem;
                    $new_item->item_id = $itemId;
                    $new_item->order_id =  $cart_order_id;
                    $new_item->quantity = $_quantity;
                    $new_item->save();
                }
            }else{
                //NINCS
                Order::create([
                    'user_id' => Auth::id(),
                    'address' => 'default',
                    'comment' => 'default',
                    'payment_method'=>'CASH',
                    'status'=>'CART',
                ]);
                    //már van CART állapota 
                    $cart_order_id = Order::where('user_id',Auth::id())->where('status','CART')->first()->id;

                    $new_item = new OrderedItem;
                    $new_item->item_id = $itemId;
                    $new_item->order_id = $cart_order_id;
                    $new_item->quantity = $_quantity;
                    $new_item->save();
            }
        }else{
            //NINCS
            Order::create([
                'user_id' => Auth::id(),
                'address' => 'default',
                'comment' => 'default',
                'payment_method'=>'CASH',
                'status'=>'CART',
            ]);
                    //már van CART állapota 
                    $cart_order_id = Order::where('user_id',Auth::id())->where('status','CART')->first()->id;

                    $new_item = new OrderedItem;
                    $new_item->item_id = $itemId;
                    $new_item->order_id = $cart_order_id;
                    $new_item->quantity = $_quantity;
                    $new_item->save();
        }
        $ordereditems = OrderedItem::all();
        
        return redirect('cart')->with(compact('_itemId','_quantity', 'ordereditems'));
    }

    public function delete_item($itemId) {
        $item = Item::find($itemId);

        if($item === null){
            return redirect()->route('items');
        }
        
        $item->delete();

        return redirect()->route('items')->with('item.deleted',true);
    }

    public function restore_item($itemId) {
        $item = Item::withTrashed()->find($itemId)->restore();

        if($item === null){
            return redirect()->route('items');
        }
        
        return redirect()->route('items')->with('item.restored',true);
    }

    public function toEditItem($id) {
        $categories = Category::all();

        if(Item::withTrashed()->find($id) != NULL){
            $item = Item::find($id);
        }else{
            $item = NULL;
        }
        
        if(Auth::user()->is_admin){

            return view('edititem', compact('item','categories'));
        }else{
            $items = Item::all();
            return view('items', compact('items','categories'));
        }
        
    }

    public function newItemForm() {
        if(Auth::user()->is_admin){
            $categories = Category::all();

            return view('new-item', compact('categories'));
        }else{
            return redirect()->route('home');
        }
        
    }

    public function storeNewItem(Request $request) {
        $data = $request->validate(
            [   
                'price' => 'required',
                'name' => 'required|min:3',
                'description' => 'required',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:4096'
            ],
            [
                'name.required' => 'A cím megadása kötelező',
                'name.min' => 'A cím túl rövid, legalább 3 karakter kell',
            ],
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hashName = $file->hashName();
            Storage::disk('public')->put('images/'.$hashName, file_get_contents($file));
            $data['image_url'] = $hashName;
        }


        $item = Item::create($data);

        $item->categories()->attach($request->categories);

        return redirect()->route('items')->with('item_added', true);
    
    }

    public function updateItem(Request $request, $id) {
        $item = Item::find($id);

        $data = $request->validate(
            [
                'name' => 'required|min:3',
                'description' => 'required',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:4096'
            ],
            [
                'name.required' => 'A cím megadása kötelező',
                'name.min' => 'A cím túl rövid, legalább 3 karakter kell',
            ],
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hashName = $file->hashName();
            Storage::disk('public')->put('images/'.$hashName, file_get_contents($file));
            $data['image_url'] = $hashName;
        }

        $item->update($data);

        $item->categories()->sync($request->categories);

        return redirect()->route('items')->with('item_updated', true);
    }

    
}
