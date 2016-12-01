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
                        @foreach($new_solutions as $new_solution)
                        <div>
                            <div>
                                {{ $new_solution->comment }}:
                            </div>
                            @foreach($new_solution->solution_steps as $step)
                            <div>
                                {{ $step->step }}
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
