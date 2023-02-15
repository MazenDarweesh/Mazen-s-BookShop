<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;


class ApiBookController extends Controller
{
   public function index()
   {
    $books= Book::get(); //u can select what u want by
            //Book::select('id' , 'title')->get();

    return response()->json($books);
   }

   public function show($id)
    {
        $book = Book::with('categories')->findOrFail($id);
        //find($id)==where('id','=',$id)->first //and first to garentee that it will return one result
        //we'll use find or fail so if id not found will get error404
        return response()->json($book);
    }
    public function store(Request $request)
    {
        //validation
        // $request->validate([
        //     'title' => 'required|string|max:100' ,
        //     'desc' => 'required|string',
        //     'img' => 'required|image|mimes:jpg,png',
        //     'category_ids' => 'required', //to store cat ids
        //     'category_ids.*' => 'exists:categories,id',
        //     ]); 
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpg,png',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

        //move: 1- got the file , 2- got the extintion
        //3- make a new unique name , 4- move to public with the new name
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $name = "book-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/books'),$name);

        //dd($request->all());
        $title = $request->title; //==_POST['title']
        $desc =$request->desc ;
        
        $book = Book::create([
            'title' => $title,
            'desc' => $desc,
            'img' => $name
        ]);

        $book->categories()->sync($request->category_ids);

        $success = "book created successfully";
        return response()->json($success);    //or return the created book.
    } 

    public function update ( Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpg,png',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

        $book=Book::findOrFail($id);
         $name = $book->img;
        
        // if there is an updated img
        if($request->hasFile('img'))
        {
            if( $name!==null)
                {

                    unlink(public_path('uploads/books/') . $name);
                }
            
                $img = $request->file('img');
                $ext = $img->getClientOriginalExtension();
                $name = "book-" . uniqid() . ".$ext";
                $img->move(public_path('uploads/books'),$name);
        }
        //we used $name to overite the old name 

        $book->update([
            "title" => $request->title,
            "desc" => $request->desc,
            "img"=> $name,
        ]);

        $book->categories()->sync($request->category_ids);

        $success = "book updated successfully";

        return response()->json($success);     
    }

    public function delete($id)
    {
        $book=Book::findOrFail($id);
        //if there is an img
        if($book->img !== null)
        {
            unlink(public_path('uploads/books/') . $book->img);
        }

        //this line is important as it clears the rows in cat table that
        // is related to the book we want to delete to avoid errors 
        $book->categories()->sync([]); 

        $book->delete();
        
        $success = "book deleted successfully";

        return response()->json($success);
    }

    

}
