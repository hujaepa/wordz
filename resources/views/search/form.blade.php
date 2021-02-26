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
            <div class="alert alert-success" id="success-alert" role="alert">
                <span class="message"></span>
            </div>
            <div class="alert alert-danger" id="danger-alert" role="alert">
                <span class="message"></span>
            </div>
            {{--RESULTS--}}
            @isset($info)
            @if($info["status"])
            <div class="card mt-3" id="result">
                <div class="card-body">
                    <h4>{{ucwords($info["word"])}}</h4>
                    @for ($i = 0; $i < $info["total_meanings"]; $i++)
                        @php $no=$i+1; @endphp
                        [<span class="font-italic font-weight-bold text-success">{{$info["partOfSpeech"][$i]}}</span>]
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
                    @if(isset($info["total_synonyms"]))
                        <span class="text-primary font-weight-bold">Synonyms</span>
                        <br>
                        @for ($i = 0; $i <$info["total_synonyms"]; $i++)
                            <span class="badge badge-success">{{$info["synonyms"][$i]}}</span>
                        @endfor
                    @endif
                    <br>
                    @if(isset($info["added"]) && $info["added"]==true)
                        <div class="float-right pt-3">
                            <button class="btn btn-secondary btn-sm" disabled>
                                Added to favourites</i>
                            </button>
                        </div>  
                    @else
                        <div class="float-right pt-3">
                            <button class="btn btn-outline-primary btn-sm" id="save" data-id="{{$info['word']}}">Add to favourites <i class="fas fa-star text-warning"></i></button>
                        </div>
                    @endif
                </div>
            </div>
            @else
                <div class="d-flex pt-3 justify-content-center">
                    <h3 class="text-secondary">Sorry Pal, No Results</h3>
                </div>
            @endif
        @endisset
        </div>
    </div>
</div>
@endsection
