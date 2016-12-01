@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vraag toevoegen</div>

                <div class="panel-body">
                    Hier kan je vragen toevoegen
                    
                    @foreach($questions as $question)
                    {{$question->question}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
