@extends('layouts.app')

@section('title', 'New item')

@section('content')
    <div class="container">
        <form action="{{ route('store.new.item') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name">Cím</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="price">Ár</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $errors->first('price') }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="description">description</label>
                        <textarea class="form-control @error('text') is-invalid @enderror" name="description" id="description" rows="3">{{ old('text') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group my-2">
                <label for="image">Kép</label>
                <input name="image" type="file" class="form-control-file" id="image">
                @error('image')
                    <div class="text-danger">
                        {{ $errors->first('image') }}
                    </div>
                @enderror
            </div>

            <h6>Kategóriák:</h6>
            @forelse ($categories as $category)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" value="{{ $category->id }}" id="tag{{ $loop->iteration }}" name="categories[]">
                    <label for="category{{ $loop->iteration }}" class="form-check-label">{{ $category->name }}</label>
                </div>
            @empty
                <p>Nincsenek még category-k az adatbázisban</p>
            @endforelse

            <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">Hozzáadás</button>
            </div>
        </form>
    </div>

    
@endsection
