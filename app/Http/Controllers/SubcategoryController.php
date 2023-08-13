<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function subcategory()
    {
        $categories = Category::all();
        return view('admin.user.subcategory.subcategory', [
            'categories' => $categories,
        ]);
    }
    function subcategory_store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'subcategory_name' => 'required',
        ]);
        if (Subcategory::where('category_id', $request->category)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exists', 'Subcategory Already Exists in this Category!');
        } else {
            Subcategory::insert([
                'category_id' => $request->category,
                'subcategory_name' => $request->subcategory_name,
            ]);
            return back()->with('success', 'Subcategory Added!');
        }
    }
    function subcategory_edit($id)
    {
        $categories = Category::all();
        $subcategory = Subcategory::find($id);
        return view('admin.user.subcategory.edit', [
            'categories' => $categories,
            'subcategory' => $subcategory,
        ]);
    }
    function subcategory_update(Request $request, $id)
    {
        if (Subcategory::where('category_id', $request->category)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exists', 'Subcategory Already Exists in this Category!');
        } else {
            Subcategory::find($id)->update([
                'category_id' => $request->category,
                'subcategory_name' => $request->subcategory_name,
                'updated_at' => Carbon::now(),
            ]);
            return back()->with('updated', 'Subcategory updated!');
        }
    }
    function subcategory_delete($id) {
        Subcategory::find($id)->delete();
        return back()->with('deleted', 'Subcategory deleted!');
    }
}
