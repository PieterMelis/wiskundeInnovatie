@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vraag toevoegen</div>

                <div class="panel-body">
                    <form method="post" action="{{url('/add_question')}}">
                        {{ csrf_field() }}
                        <div>
                            <label for="nr">Nummer:</label>
                            <input type="number" name="nr" id="nr" min="1" required>
                        </div>
                        
                        <div>
                            <label for="question">Vraag:</label>
                            <input type="text" name="question" id="question" required>
                        </div>
                        
                        <div>
                            <label for="chapter">Hoofdstuk:</label>
                            <select name="chapter" id="chapter">
                                @foreach($chapters as $chapter)
                                @foreach($chapter->subchapters as $subchapter)
                                <option value="{{$subchapter->id}}">{{$chapter->nr}}.{{$subchapter->nr}} {{$subchapter->name}}</option>
                                @endforeach
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="subquestions">Bevat subvragen:</label>
                            <input type="checkbox" id="subquestions" name="subquestions">
                            <div>Als bovenstaande gechecked wordt moet er een form-deel zichtbaar worden waarop je de subvragen ineens kan toevoegen</div>
                        </div>
                        
                        <div>
                            <input class="btn btn-success" type="submit" value="Opslagen">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
