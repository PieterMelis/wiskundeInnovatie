@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hoofdstuk updaten</div>

                <div class="panel-body">
                    <form method="post" action="{{url('/edit_chapter')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$chapter->id}}">
                        
                        <div>
                            <label for="nr">Nummer:</label>
                            <input type="number" name="nr" id="nr" min="1" value="{{$chapter->nr}}" required>
                        </div>
                        
                        <div>
                            <label for="name">Naam:</label>
                            <input type="text" name="name" id="name" value="{{$chapter->name}}" required>
                        </div>
                        
                        <div>
                            <input class="btn btn-success" type="submit" value="Updaten">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
