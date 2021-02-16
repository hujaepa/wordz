@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <form method="post" action="{{url('/search/result')}}">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search" required 
                    @isset($word)
                        value="{{$word}}" 
                    @endisset>

                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            
            {{--RESULTS--}}
            @isset($info)
            @if(is_array($info))
            <div class="card mt-3">
                <div class="card-body">
                    <h4>{{ucwords($info["word"])}}</h4>
                    @for ($i = 0; $i < $info["total_meanings"]; $i++)
                        @php $no=$i+1; @endphp
                        [<span class="font-italic text-success">{{$info["partOfSpeech"][$i]}}</span>]
                        <br/>
                        <span class="font-weight-bold">
                            Definition #{{$no}}:
                            <span class="font-italic text-muted p-2">{{$info["definition"][$i]}}</span>
                            <br/>
                            @isset($info["example"][$i])
                                Example:
                                <span class="font-italic text-muted p-2">{{$info["example"][$i]}}</span>
                                <br/>
                            @endisset
                        </span>
                    @endfor
                    <span class="text-primary">Synonyms</span>
                    <br>
                    @for ($i = 0; $i <$info["total_synonyms"]; $i++)
                        <span class="badge badge-success">{{$info["synonyms"][$i]}}</span>
                    @endfor
                    <br>
                    <div class="float-right">
                        <button class="btn btn-outline-primary btn-sm" id="save" data-id="{{$info['word']}}">Add to favourites <i class="fas fa-star text-warning"></i></button>
                    </div>
                </div>
            </div>
            @else
                <h1 class="text-secondary">Sorry Pal, No Results</h1>
            @endif
        @endisset
        </div>
    </div>
</div>
@endsection
