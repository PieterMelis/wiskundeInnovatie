@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nieuwe oplossingen</div>

                <div class="panel-body">
                    Hier vind je een overzicht met nieuwe oplossingen
                    
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                Vraag:
                            </div>
                            <div class="col-md-3">
                                Beantwoord door:
                            </div>
                            <div class="col-md-3">
                                Oplossing details
                            </div>
                        </div>
                        
                        @foreach($new_solutions as $new_solution)
                        <div class="row">
                            <div class="col-md-6">
                                {{ $new_solution->mainquestion->question }}
                            </div>
                            <div class="col-md-3">
                                {{ $new_solution->user->name }}
                            </div>
                            <div class="col-md-3">
                                <a href="{{url('new_solution_details/' . $new_solution->id)}}">Bekijk</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
