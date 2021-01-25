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

@section('title', 'Manage orders')
@section('content') 
<div class="container_">
    @forelse($orders as $order)
    <div class="card border-secondary mb-3">
    <div class="card-header">{{$order->user->name}}, {{$order->address}}, {{$order->updated_at}}
    <button class="btn btn-sm btn-outline-primary py-0"><a class="nav-link"  href="{{route('admins.received', ['id' => $order->id])}}">Szerkesztés</a></button>
    </div>
        <div class="card-body text-secondary">
        <h5 class="card-title">{{$order->status}}</h5>
        <small> 
        <?php $_sum = 0 ?> 
                    @foreach($order->ordereditems as $items)
                        <p> {{$items->item->name}}  {{$items->quantity}}db  {{$items->item->price}}$ </p>
                        <?php $_sum = $_sum + $items->quantity*$items->item->price  ?> 
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



