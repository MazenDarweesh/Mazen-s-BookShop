<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book ;
use App\Models\Category ;


class BookController extends Controller
{
    public function index()
    {
        //insted of $books=Book::get(); that gets u all the books in on page
        // will use paginate (numbering the pages) to split the result into 'n' pages
        $books=Book::orderBy('id','desc')->get()/*paginate(3)*/;

       
        //die & dump
       // dd($books);
       return view('books.index',compact('books'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword; // each typed key word will be in the request class
        $books = Book::where('title', 'like', "%$keyword%")->get(); // this mean the keyword in any place in the title  b

        return response()->json($books);
    }

    public function show(Book $book)
    {
        //find($id)==where('id','=',$id)->first //and first to garentee that it will return one result
        //we'll use find or fail so if id not found will get error404
       return view('books.show',compact('book'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view(
            'books.create',
            compact('categories')
        );    } 
    
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'title' => 'required|string|max:100' ,
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpg,png',
            'category_ids' => 'required', //to store cat ids
            'category_ids.*' => 'exists:categories,id',
            ]); 
        
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

        return redirect(route('books.index'));
    } 

    public function edit(Book $book)
    {
        return view('books.edit',compact('book'));

    }

    public function update ( Request $request ,$id)
    {
        //validation
        $request->validate([
            'title' => 'required|string|max:100' ,
            'desc' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,png',
            'category_ids' => 'required',
            'category_ids.*' => 'exists:categories,id',
            ]); 

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
        
        return redirect(route('books.edit',$id));
    }

    public function delete($id)
    {
        $book=Book::findOrFail($id);
        //if there is an img
        if($book->img !== null)
        {
            unlink(public_path('uploads/books/') . $book->img);
        }

        $book->delete();
        return back();
               //or redirect (route ('books.index'));
    }
}
  





//$books = Book::select('title','desc')->get();
//$books = Book::where('id','>=',2)->get();
 //$books = Book::select('title','desc')->where('id','>=',2)->orderBy('id','DESC')->get();
