<style>
.container_ {
  height: 90vh;
  margin: 2rem;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-template-rows: 1fr 1fr 1fr;
  grid-gap: 10px 10px; 
}


</style>
@extends('layouts.app')

@section('title', 'Orders')
@section('content') 
<div class="container_">
    @forelse($orders as $order)
    <div class="card border-secondary mb-3"><div class="card-header">Rendelés</div>
        <div class="card-body text-secondary">
       
        @if($order->status == "RECEIVED")
            <h5 class="card-title">Feldolgozás alatt </h5>
        @elseif($order->status == "ACCEPTED")
            <h5 class="card-title">Elfogadva </h5>
        @else
            <h5 class="card-title">Elutasítva </h5>
        @endif
        
        <small> 
        <?php $_sum = 0 ?> 
                    @foreach($order->ordereditems as $items)
                        @if($items->item->deleted_at !== NULL )
                        <p style="color: red;"> {{$items->item->name}}  {{$items->quantity}}db  {{$items->item->price}}$ </p>
                            @if($order->status == "RECEIVED")
                            <!-- Ha csak leadta a rendelést, akkor nem számolja bele a törölt item árát, 
                            így később nem kell azt is kifizetni -->
                            @else
                            <?php $_sum = $_sum + $items->quantity*$items->item->price ?>
                            @endif
                        @else 
                        <p> {{$items->item->name}}  {{$items->quantity}}db  {{$items->item->price}}$ </p>
                        <?php $_sum = $_sum + $items->quantity*$items->item->price  ?> 
                        @endif
                    @endforeach
        </small>
                    
              
         </div>
         <div class="card-footer">
      <p class="text-muted">{{$_sum}} $ </p>
    </div> 
    </div>
    
    @empty
    
        <div class="alert alert-warning" role="alert">
            Nincsenek rendelések
        </div>
    
    @endforelse    
</div>
@endsection



