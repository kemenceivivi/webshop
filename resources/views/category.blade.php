<style> 
.container_ {
   
   width: 90vw;
   margin: 2rem auto;
   display: grid;
   grid-template-areas: "left main";
   grid-template-columns: 1fr 3fr;
}
.cell-1 {
   grid-area: header;
}
.cell-2 {
  
   grid-area: left;
}
.cell-3 {
   grid-area: main;
}
.cell-4 {
   background: gold;
   grid-area: right;
}
.cell-5 {
   background: blueviolet;
   grid-area: footer;
}

.card.white{
    height: 100%;
    border-color: white;
}

.card.red{
    height: 100%;
    border-color: red;
}


.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}

.a{
      text-decoration: none;
 }

</style>
@extends('layouts.app')

@section('title', 'Category')

@section('content')
@if (session()->has('category_updated'))
                <div class="alert alert-success" role="alert">
                    Sikeresen módosítottad ezt a kategóriát!
                </div>
            @endif

@guest <!-- VENDÉG -->

<div class="container_">
  <div class="cell cell-2">
  
    <div class="card" style="width: 15rem;">
    <div class="card-header">
        Kategória
    </div>
    @foreach($categories as $all_category)
    <ul class="list-group list-group-flush">
        <li class="list-group-item">

        <a class="dropdown-item" href="{{route('category', ['id' => $all_category->id])}}">    {{$all_category->name}} </a>
        
        </li>
    </ul>
    @endforeach
   
    </div>
    </div>
     <div class="cell cell-3">   
     <h1> {{$category->name}} </h1>
        <div class="row">
            @forelse ($items as $item)
            
                <div class="col-12 col-lg-4 mb-5">
                    <div class="card h-100 ">
                    @if ($item->image_url !== null)
                        <img src="{{ Storage::url('images/'.$item->image_url ) }}" class="card-img-top" >
                    @else
                        <img  src="{{ Storage::url('public/images/placeholder.png') }}" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">{{$item->description}}</p>    
                    </div>
                    <div class="card-footer">
                <div class="form-group">
                        <small class="text-muted">{{$item->price}} $</small>
                        <div class="float-right">
                        <form method="POST" action="/cart/add/{{$item->id}}/quantity/1" id="addtocart{{$item->id}}" enctype="multipart/form-data">
                        @csrf
                          
                            <input name="quantity" id="quantity{{$item->id}}"  type="number" data-decimals="2" min="1" max="10" value="1"/> 
                            <button type="submit" class="btn btn-primary @guest disabled @endguest" >Kosárba</button>
                        </form>       
                        </div>
                    </div>
                </div>
                
        </div>
                </div>

    <script type="text/javascript">
                    const form{{$item->id}} = document.getElementById('addtocart{{$item->id}}')
                    const input{{$item->id}} = document.getElementById('quantity{{$item->id}}')
                    input{{$item->id}}.addEventListener('change', (e) => {
                        console.log(input{{$item->id}}.value);
                    form{{$item->id}}.action = `/cart/add/{{$item->id}}/quantity/${input{{$item->id}}.value}`
                    })
    </script>
           
            @empty
                <p>Még nincsenek termékek</p>
            @endforelse
        </div>

      
    </div>
    </div>
</div>


@else <!-- VENDÉG VÉGE -->
<div class="container_">
  <div class="cell cell-2">
  
    <div class="card" style="width: 15rem;">
    <div class="card-header">
        Kategória
    </div>
    @foreach($categories as $all_category)
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
        @if(Auth::user()->is_admin)  
                    <div class="row">
                        <form action="{{route('category.deleted', ['categoryId' => $all_category->id])}}" method="POST">
                        @csrf
                        <a class="dropdown-item" href="{{route('category', ['id' => $all_category->id])}}">    {{$all_category->name}} </a>
                        <button type="submit"  class="btn btn-sm btn-outline-danger py-0">Törlés</button>
                        <a href="{{route('to.edit', ['id' => $all_category->id])}}"  role="button" class="btn btn-sm btn-outline-primary py-0">Szerkesztés</a>
                        
                        </form> 
                    </div>
        @else
        <a class="dropdown-item" href="{{route('category', ['id' => $all_category->id])}}">    {{$all_category->name}} </a>
        @endif
        </li>
    </ul>
    @endforeach
    @if(Auth::user()->is_admin)  
    <form action="{{ route('store.new.category') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('title') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div> 
                @enderror
                    
            <div class="card">
                <button type="submit" class="btn btn-success">Új kategória</button>
            </div>
            </form>
            <div class="card">
            <a class="nav-link" href="{{route('new.item')}}" ><button class="btn btn-success">Új item hozzáadása-></button></a>
            </div>
    
    
    @endif    
    </div>
   
    </div> <!-- ADMIN -->
    
     <div class="cell cell-3">
       <h2> {{$category->name}} </h2>
        <div class="row">
            @forelse ($items as $item)
                <div class="col-12 col-lg-4 mb-5">
                        @if($item->deleted_at==NULL)
                            <div class="card h-100 ">
                        @else 
                            <div class="card h-100 border-danger mb-3">    
                        @endif    
                        @if(Auth::user()->is_admin)  
                        <div> 
                             @if($item->deleted_at == NULL)
                                    <div class="row">
                                        <div class="col">
                                        <form action="{{route('item.deleted', ['itemId' => $item->id])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-block ">Törlés</button>
                                        </div>
                                        <div class="col">
                                        <button class="btn btn-sm btn-outline-primary py-0"><a class="nav-link"  href="{{route('to.edit.item', ['id' => $item->id])}}">Szerkesztés</a></button>
                                        </div>
                                    </form>
                                    </div>
                                    
                                    @else 
                                    <form action="{{route('item.restore', ['itemId' => $item->id])}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block">Visszaállítás</button>
                                    </form> 
                                    @endif
                                
                           
                        </div>
                    @endif     
                    @if ($item->image_url !== null)
                    
                    <img src="{{ Storage::url('images/'.$item->image_url ) }}" alt="" class="card-img-top" >
                   
                    @else
                        <img  src="{{ Storage::url('public/images/placeholder.png') }}" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">{{$item->description}}</p>    
                    </div>
                    <div class="card-footer">
                <div class="form-group">
                        <small class="text-muted">{{$item->price}} $</small>
                        <div class="float-right">
                        <form method="POST" action="/cart/add/{{$item->id}}/quantity/1" id="addtocart{{$item->id}}" enctype="multipart/form-data">
                        @csrf
                          
                            <input name="quantity" id="quantity{{$item->id}}"  type="number" data-decimals="2" min="1" max="10" value="1"/> 
                            <button type="submit" class="btn btn-primary @guest disabled @endguest" >Kosárba</button>
                        </form>       
                        </div>
                    </div>
                </div>
                
        </div>
                </div>

    <script type="text/javascript">
                    const form{{$item->id}} = document.getElementById('addtocart{{$item->id}}')
                    const input{{$item->id}} = document.getElementById('quantity{{$item->id}}')
                    input{{$item->id}}.addEventListener('change', (e) => {
                        console.log(input{{$item->id}}.value);
                    form{{$item->id}}.action = `/cart/add/{{$item->id}}/quantity/${input{{$item->id}}.value}`
                    })
    </script>
           
            @empty
                <p>Még nincsenek termékek</p>
            @endforelse
        </div>

      
    </div>
    </div>
    
@endguest
@endsection



