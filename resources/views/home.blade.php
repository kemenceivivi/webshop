@extends('layouts.app')

@section('content')
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Information') }}</div>

                    <div class="card-body">
                    <div class="text-center my-3">
                    
                        <li>Itemek: {{ $item_count }}</li>
                        <li>Felhasználók: {{ $user_count }}</li>
                        <li>Kategóriák: {{ $category_count }}</li>
                    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
