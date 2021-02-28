@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Filter Favourites" name="search" required
                @isset($word)
                    value="{{$word}}" 
                @endisset>

                {{-- <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div> --}}
            </div>
            <div class="card mt-3" id="favourites">
                <div class="card-body">
                    <h4>Favourites</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection