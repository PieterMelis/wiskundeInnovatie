@extends('layouts.app')

@section('pageCss')
<style>
    
    
    .subquestions {
        display: none;
    }
    
    /* to prevent the bubttons from looking weird */
    .mq-scaled.mq-sqrt-prefix {
        transform: none !important;
    }
</style>
@endsection

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
                            <div class="math-controls">
									<div class="btn btn-default btn-cursor" data-type="cmd" data-math="\sqrt">\sqrt{n}
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-math="\nthroot">
										\sqrt[n]{x}
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-math="\Leftrightarrow">
										\Leftrightarrow
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-math="\text">
										\text{Text}
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-math="\frac">
										\frac{x}{y}
									</div>
								</div>
								<span id="question"
									  class="form-control mq-editable-field mq-math-mode"></span>
								<input type="" name="questions-latex[]" id="question-latex">
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
                            <button type="button" id="add_subquestions" class="btn btn-primary">Subvragen toevoegen</button>
                        </div>
                        
                        
                        <div class="subquestions">
                            
                            <div>
                                <label for="subquestion">Subvraag:</label>
                                <label for="sub_number">Nummer:</label>
                                <input type="number" name="sub_nr" id="sub_nr" min="1" required>
                                
                                <div class="math-controls-sub">
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-math="\sqrt">\sqrt{n}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-math="\nthroot">
                                            \sqrt[n]{x}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-math="\Leftrightarrow">
                                            \Leftrightarrow
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-math="\text">
                                            \text{Text}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-math="\frac">
                                            \frac{x}{y}
                                        </div>
                                    </div>
                                    <span id="subquestion"
                                          class="form-control mq-editable-field mq-math-mode"></span>
                                    <input type="" name="subquestions-latex[]" id="subquestion-latex">
                            </div>
                            
                            <button type="button" class="btn btn-primary new_sub">Extra subvraag</button>
                            
                            <div>
                                <h2>Prvevious subquestions</h2>
                                <div class="previoussubquestions">
                                    
                                </div>
                            </div>
                            
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

@section('pageJs')
	<script>
		(function ( $, MathQuill ) {
			var renderedQuestion = document.getElementById('question');
			var latexInput = document.getElementById('question-latex');
			
			var MQ = MathQuill.getInterface(2); // for backcompat
			var mathField = MQ.MathField(renderedQuestion, {
				spaceBehavesLikeTab: true, // configurable
				handlers: {
					edit: function () { // useful event handlers
						console.log(mathField.latex());
						latexInput.value = mathField.latex(); // simple API
					}
				}
			});
			
            //get all control buttons
			var $mathControls = $('.math-controls');
			
            //for each of these controls, turn them into math symbols
			$mathControls.find('div').each(function () {
				MQ.StaticMath($(this)[ 0 ]);
			});
			
			$mathControls.on('click', 'div', function () {
				console.log("trig");
				switch ($(this).data('type')) {
					case 'type':
						mathField.typedText($(this).data('math')).focus();
						break;
					case 'cmd':
						mathField.cmd($(this).data('math')).focus();
						break;
				}
			});
            
            
            
            /* SUBQUESTIONS */
            
            var renderedSubquestion = document.getElementById('subquestion');
			var latexInputSubquestion = document.getElementById('subquestion-latex');
			
			var MQ = MathQuill.getInterface(2); // for backcompat
			var mathFieldSub = MQ.MathField(renderedSubquestion, {
				spaceBehavesLikeTab: true, // configurable
				handlers: {
					edit: function () { // useful event handlers
						console.log(mathFieldSub.latex());
						latexInputSubquestion.value = mathFieldSub.latex(); // simple API
					}
				}
			});
            
            //get all control buttons for subquestions
			var $mathControlsSub = $('.math-controls-sub');
			
            //for each of these controls, turn them into math symbols
			$mathControlsSub.find('div').each(function () {
				MQ.StaticMath($(this)[ 0 ]);
			});
			
			$mathControlsSub.on('click', 'div', function () {
				console.log("trig");
				switch ($(this).data('type')) {
					case 'type':
						mathFieldSub.typedText($(this).data('math')).focus();
						break;
					case 'cmd':
						mathFieldSub.cmd($(this).data('math')).focus();
						break;
				}
			});
            
            //slide add subquestions open
            $("#add_subquestions").click(function () {
                $(".subquestions").show();
            });
            
            $(".new_sub").click(function() {
                //check if sub_nr is filled in
                if($("#sub_nr").val()) {
                    //save previous question
                    $(".previoussubquestions").append("<p>" + latexInputSubquestion.value + " en nr " + $("#sub_nr").val() + "</p>");
                    //clear the input
                    $("#subquestion .mq-root-block").text("");
                    latexInputSubquestion.value = "";
                    mathFieldSub.latex("");
                }
                else {
                    alert("subnr invullen!");
                }
            });
            
            
		})(jQuery, MathQuill);
	</script>
@endsection
