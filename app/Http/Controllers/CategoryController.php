<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//******improtant the following */
use App\Models\Category ;


class CategoryController extends Controller
{
    public function index()
    { 
        $categories=Category::orderBy('id','desc')->paginate(3);

        return view(
            'categories.index',
            compact('categories')
        );
    }

    public function show($id)
    {
        $category=Category::findOrfail($id);
        return view('categories.show',compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    } 
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required|string|max:100' ,
            ]);

        $name = $request->name; //==_POST['title']
        Category::create([
            'name' => $name,
        ]);

        return redirect(route('categories.index'));
    } 

    public function edit($id)
    {
        $category=Category::findOrfail($id);
        return view('categories.edit',compact('category'));

    }

    public function update ( Request $request ,$id)
    {
        //validation
        $request->validate([
            'name' => 'required|string|max:100' ,
            ]); 

        $category=Category::findOrFail($id);   
        $category->update([
            "name" => $request->name,
        ]);

        return redirect(route('categories.edit',$id));
    }

    public function delete($id)
    {
        $category=Category::findOrFail($id);
        $category->delete();

        return back();
               //or redirect (route ('books.index'));
    }
}
