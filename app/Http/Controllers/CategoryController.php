<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // category list
    public function list()
    {
        $categories = Category::latest()->get();

        return view('category.category-list', compact('categories'));
    }


    // store
    public function save(Request $request, $id = false)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable'
        ]);

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($id) 
        {
            $category = Category::findOrFail($id);
        } 
        else 
        {
            $category = new Category();
        }
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return redirect()->back()->with(['message' => 'Category saved']);
    }


    // delete
    public function delete($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->back()->with(['message' => 'Category removed']);
    }
}
