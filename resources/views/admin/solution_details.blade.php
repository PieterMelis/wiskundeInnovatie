@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Details oplossing</div>

                <div class="panel-body">
                    Details oplossing
                    
                    
                    <div>
                        <div>
                            {{ $solution->comment }}:
                        </div>
                        @foreach($solution->solution_steps as $step)
                        <div>
                            {{ $step->step }}
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <a href="{{url('accept_new_solution/'.$solution->id)}}">Accepteer deze oplossing</a>
                        <a href="{{url('decline_new_solution/'.$solution->id)}}">Wijs deze oplossing af</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
