<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Auth;

class CategoryController extends Controller
{
    public function show($id) {

        if(Category::where('id',$id)->first() != NULL){
            $category = Category::where('id',$id)->first();
            $items = $category->items;
            $categories = Category::all();
        }else{
            $category = NULL;
            $items = [];
            $categories = [];
        }
        
        
        return view('category', compact('category','items', 'categories'));
    }

    public function delete_category($categoryId) {

        $category = Category::find($categoryId);

        if($category === null){
            return redirect()->route('items');
        }
        $category->delete();

        return redirect()->route('items')->with('category.deleted',true);
    }

    public function storeNewCategory(Request $request) {
        $data = $request->validate(
            [
                'name' => 'required|min:3',
            ],
            [
                'name.required' => 'A cím megadása kötelező',
                'name.min' => 'A név túl rövid, legalább 3 karakter kell',
            ],
        );

    
        $data = $request->all();
        $category = Category::create($data);


        return redirect()->route('items');
    }

    public function toEdit($id) {
        if(Auth::user()->is_admin){
            if(Category::where('id',$id)->first() != NULL){
                $category = Category::find($id);
            }else{
                $category = NULL;
            }
            return view('editcategory', compact('category'));
        }else{
            return redirect()->route('home');
        }
    }

    public function updateCategory(Request $request, $id) {
        $my_id2= $id;
        $old_name = Category::find($id)->name;
        $category = Category::find($id);

        $data = $request->validate(
            [
                'name' => 'required|min:3',
            ],
            [
                'name.required' => 'A név megadása kötelező',
                'name.min' => 'A név túl rövid, legalább 3 karakter kell',
            ],
        );

    
        $category->update($data);


        return redirect()->route('items', ['id' => $id])->with('category_updated', true);
    }

}
