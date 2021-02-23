@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h3>Word of The Day</h3>
                    @php echo $word->word; @endphp
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-3">
        <h4><a href="{{url('/search')}}" class="text-muted" style="text-decoration: none !important"><i class="fas fa-search"></i> Click here to search</a></h4>
    </div>
</div>
@endsection
