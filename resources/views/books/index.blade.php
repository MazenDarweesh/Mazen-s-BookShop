@extends('inc/layout')

@section('title')
    All Books
@endsection

@section('content')
    
<input type="text" id="keyword"> {{-- text input for real time search --}}

@auth 

    <h1>Notes:</h1>
    @foreach(Auth::user()->notes as $note)
       <p>{{ $note->content }}</p>
    @endforeach

    <a href="{{ route('notes.create') }}" class="btn btn-info">Add new note</a>
@endauth

    <h1>All Books</h1>

    @auth
        <a class="btn btn-primary" href="{{route('books.create')}}">Create</a>
    @endauth
    {{-- 
        from here is the part that displays the hole books
        so we will put it in a div to manipulate it with java script
    --}}
<div id="allBooks">
    @foreach($books as $book)

        <hr>
        {{-- <a href="{{route('books.show',$book->id)}}"> --}}
            <h3>{{ $book->title }};</h3>
        {{-- </a> --}}
        <p>{{ $book->desc }}</p>
        @auth
            @if (Auth::user()->is_admin==1)
                <a class="btn btn-danger" href="{{route('books.delete', $book->id)}}">Delete</a>    
            @endif
            <a class="btn btn-primary" href="{{route('books.edit',$book->id)}}">Edit</a>
        @endauth
    @endforeach
</div>


    {{-- {{$books->render()}} --}}


@endsection

@section('scripts')
<script>
  $('#keyword').keyup(function(){   //  if the user typed a letter then stopped
    let keyword = $(this).val() // read this letter and put it in keyword
    let url = "{{ route('books.search') }}" + "?keyword=" + keyword 
    // go to the search url and u sent with it a GET parameter (keyword)
    //console.log(url);
    // the following block is for the ajax request 
    $.ajax({ 
      type: "GET", 
      url: url,
      contentType: false,
      processData: false,
      success: function (data) // if the request succeeded the do the following with the coming data
      {
        $('#allBooks').empty() // here when the user start to type in the search box it will empty all the box in the div section
        for (book of data) { // the for (_ of _ ) is like the foreach in php (it iterate through an arrays) // notice for (_ in _) iterate through objects  
            //here will iterate through all the box that match with the typed letters and show them
          $('#allBooks').append(`
            <h3>${book.title}</h3>
            <p>${book.desc}</p>
          `)
        }
      }
    })
  })
</script>
@endsection