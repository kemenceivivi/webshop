<style>
.container_ {
   height: 90vh;
   width: 90vw;
   margin: 2rem auto;
   display: grid;
   grid-template-areas: "left right";
   grid-template-rows: 3fr 2fr;
   grid-template-columns: 3fr 2fr;
   grid-column-gap: 1rem;
}
.cell-1 {
   grid-area: left;
}
.cell-2 {
   grid-area: right;
}

</style>
@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container_">

@if (session()->has('ordereditem.deleted'))
    <div class="alert alert-success mb-3" role="alert">
        Törölted
    </div> 
@endif


<div class="cell-2">
    <div class="card">
        <div class="card-header">
                Rendelés leadása
        </div>
        <div class="card-body">
            <form action="{{route('update-order')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">Cím</label>
                        <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" value="{{ old('address') }}">
                        @if ($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>
                    <label class="radio-inline"><input type="radio" style="margin:5px;" name="payment_method" value="CARD" checked>Card</label>
                    <label class="radio-inline"><input type="radio" style="margin:5px;" name="payment_method" value="CASH">Cash</label>
                </div>
                <div class="col-12 col-md-6">
                    <label for="text">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" rows="5"></textarea>

                </div>
            </div>
    </div>
            <div class=card-footer> 
            @if($not_empty)
                <p> Összár {{$total}} $<button type="submit" class="btn btn-primary float-right">Rendelés</button> </p>
            @else 
                <p> Összár {{$total}} $<button type="submit" class="btn btn-primary float-right" disabled>Rendelés</button> </p>
            @endif
            </div>
            </form>
        </div>
    </div>
         
    <div class="cell-1">
    <div class="row">
        @if($not_empty)
        @foreach ($good_items as $ordereditem)
           <div class="col-12 col-lg-4 mb-2">
                    <div class="card h-100">
                        <div class="card-body">
                        <h5 class="card-title">{{$ordereditem->item->name}} </h5>
                        <p class="card-text mb-3">Description: {{$ordereditem->item->description}}</p>
                        
                         </div>
                       
                        <div class="card-footer">
                        <small> Db: {{$ordereditem->quantity}} </small>
                            <form action="{{route('ordereditem.deleted', ['itemId' => $ordereditem->id])}}" method="POST">   
                            @csrf
                            price: {{$ordereditem->item->price}}$
                            <button type="submit" class="btn btn-outline-danger float-right">Törlés</button>
                            </form>      
                        </div>
                    </div> 
            </div>
        
        @endforeach
        @else
        <div class="alert alert-danger" role="alert">
            Üres a kosár
        </div>
        @endif
      
    </div>

           
            
</div>

      
        
</div>
</div>
</div>
@endsection
