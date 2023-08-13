<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    function category()
    {
        $categories = Category::Paginate(5);
        return view('admin.user.category.category', [
            'categories' => $categories,
        ]);
    }
    function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'category_img' => 'required|mimes:png,jpg|file|max:512|dimensions:min_width=50,min_height=50',

        ]);
        $img = $request->category_img;
        $extension = $img->extension();
        $file_name = Str::lower(str_replace('', '-', $request->category_name)) . '-' . random_int(100000, 900000) . '.' . $extension;
        Image::make($img)->save(public_path('uploads/category/' . $file_name));
        Category::insert([
            'category_name' => $request->category_name,
            'category_img' => $file_name,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('success', 'category added successfully!');
    }
    function category_edit($category_id)
    {
        $category_info = Category::find($category_id);
        return view('admin.user.category.edit', [
            'category_info' => $category_info,
        ]);
    }
    function category_update(Request $request)
    {
        $category = Category::find($request->category_id);
        if ($request->category_img == "") {
            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('success', 'category updated successfully!');
        } else {
            $present_photo = public_path('uploads/category/' . $category->category_img);
            unlink($present_photo);
            $img = $request->category_img;
            $extension = $img->extension();
            $file_name = Str::lower(str_replace('', '-', $request->category_name)) . '-' . random_int(100000, 900000) . '.' . $extension;
            Image::make($img)->save(public_path('uploads/category/' . $file_name));
            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'category_img' => $file_name,
                'created_at' => Carbon::now(),
            ]);
        }
        return back()->with('success', 'category updated successfully!');
    }
    function category_soft_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back();
    }
    function category_trash()
    {
        $trash_category = Category::onlyTrashed()->get();
        return view('admin.user.category.trash', [
            'trash_category' => $trash_category,
        ]);
    }
    function category_restore($id)
    {
        Category::onlyTrashed()->find($id)->restore();
        return back();
    }
    function category_hard_delete($id)
    {
        $category = Category::onlyTrashed()->find($id);
        $img = public_path('uploads/category/' . $category->category_img);
        unlink($img);
        Category::onlyTrashed()->find($id)->forceDelete();
        Subcategory::where('category_id',$id)->update([
            'category_id'=>16,
        ]);
        return back();
    }
    function delete_check(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::find($category)->delete();
            Subcategory::where('category_id',$category)->update([
                'category_id'=>16,
            ]);
        }
        return back();
    }
    function restore_check(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::onlyTrashed()->find($category)->restore();
        }
        return back();
    }
}
