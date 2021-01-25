<style>
.container_ {
   height: 90vh;
   width: 90vw;
   margin: 2rem auto;
   display: grid;
   grid-template-areas: "left right";
   grid-template-rows: 2fr 3fr;
   grid-template-columns: 2fr 3fr;
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

@section('title', 'Received')

@section('content')
<div class="container_">

<div class="cell-1">
    <div class="card">
        <div class="card-header">Rendelés adatai </div>
        <div class="card-body">
            <div class="container">
                Név: {{$order->user->name}}<br>
                E-mail: {{$order->user->email}}<br>
                Cím: {{$order->address}}<br>
                Rendelés ideje: {{$order->updated_at}}<br>
                Megjegyzés: {{$order->description}}<br>
            </div>
        </div>
        <div class="card-footer">
        <div class="row">
        
        <div class="col">
        @if($order->status == "RECEIVED")
            <form method="POST" action="{{route('accept.order', ['orderId' => $order->id])}}">
            @csrf
            <button type="submit" class="btn btn-success">Elfogad</button>
            </form>
            </div>
            <div class="col">
            <form method="POST" action="{{route('reject.order', ['orderId' => $order->id])}}">
            @csrf
            <button type="submit" class="btn btn-danger">Elutasít</button>
            </form>
        @else 
            <p> EL lett fogadva </p>
        @endif    
            </div>
            </div>
        </div>

    </div>
    
</div>
    <div class="cell-2">
    <div class="row">
        
        @foreach ($order->ordereditems as $thisorder)
           <div class="col-12 col-lg-4 mb-2">
                    <div class="card h-100">
                        <div class="card-body">
                        <h5 class="card-title">{{$thisorder->item->name}} </h5>
                        <p class="card-text mb-3">Description: {{$thisorder->item->description}}</p>
                        
                         </div>
                       
                        <div class="card-footer">
                        db: {{$thisorder->quantity}} </div>
                    </div> 
            </div>
        
        @endforeach
      
      
    </div>

           
            
</div>

      
        
</div>
</div>
</div>
@endsection
