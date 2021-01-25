@extends('layouts.app')

@section('title', 'Edit category')

@section('content')
@if ($category == null)
        <div class="alert alert-danger text-center">
            Az elem nem található
        </div>

@else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2> {{$category->name}} </h2>
                <form action="{{route('edit.category', ['id' => $category->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input placeholder="Új név" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('title') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div> 
                            @enderror
                                
                        <div class="card">
                            <button type="submit" class="btn btn-success">Mentés</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endif    
@endsection