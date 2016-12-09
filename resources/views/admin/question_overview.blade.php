@extends('layouts.app')

@section('pageCss')
<style>
    .subchapter {
        margin-left: 20px;
    }
    .subchapter h3 {
        border-bottom: 1px #eee solid;
    }
    
    .mainquestion {
        margin-left: 20px;
    }
    
    .subquestion {
        margin-left: 20px;
    }
    
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vragenoverzicht</div>

                <div class="panel-body">
                   
                    @foreach($chapters as $chapter)
                    <div class="chapter">
                        <h2>{{$chapter->nr}}. {{$chapter->name}}</h2>
                        @foreach($chapter->subchapters as $subchapter)
                        <div class="subchapter">
                            <h3>{{$subchapter->nr}}. {{$subchapter->name}}</h3>
                            @foreach($subchapter->mainquestions as $mainquestion)
                            <div class="mainquestion">
                                <h4>{{$mainquestion->nr}}. {{$mainquestion->question}}</h4>
                                @foreach($mainquestion->subquestions as $subquestion)
                                <div class="subquestion">
                                    {{$subquestion->nr}}. {{$subquestion->question}}
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endsection