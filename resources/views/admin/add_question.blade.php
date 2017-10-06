@extends('layouts.app')

@section('pageCss')
<style>
    
    .btn-primary,
    .btn-success {
        margin-top: 25px;
    }
    
    label {
        width: 100px;
    }
    
    input, select {
        padding: 5px 10px;
    }
    
    .subquestions {
        display: none;
    }
    
    .previousSub,
    div[class^='previousSub']{
        display: block;
    }
    
    .renderedSub {
        float: left;
    }
    .previousSubControls {
        float: right; 
    }
    .previousSubControls .edit {
        cursor: pointer;
    }
    .previousSub::before, .previousSub::after,
    div[class^='previousSub']::before, div[class^='previousSub']::after {
        line-height: 0;
        content: "";
        display: table;
    }
    .previousSub::after,
    div[class^='previousSub']::after {
        clear: both;
    }
    
    
    /* to prevent the bubttons from looking weird */
    .mq-scaled.mq-sqrt-prefix {
        transform: none !important;
    }
    
    .mainquestion_required {
        color: #d22;
        display: none;
    }
    .mainquestion_required.visible {
        display: block;
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
                            <label for="nr">Nummer:</label>
                            <input type="number" name="nr" id="nr" min="1" value="1" required>
                        </div>
                        
                        <div>
                            <label for="question">Vraag:</label>
                                <div class="math-controls">
									<div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\sqrt"
										 data-balloon-pos="up">\sqrt{n}
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\nthroot"
										 data-balloon-pos="up">
										\sqrt[n]{x}
									</div>
									<div class="btn btn-default btn-cursor" data-type="type"
										 data-balloon="\Leftrightarrow\\" data-balloon-pos="up">
										\Leftrightarrow
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\text"
										 data-balloon-pos="up">
										\text{Text}
									</div>
									<div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\frac"
										 data-balloon-pos="up">
										\frac{x}{y}
									</div>
								</div>
								<span id="question"
									  class="form-control mq-editable-field mq-math-mode"></span>
								<input type="" name="questions_latex[]" id="question_latex">
                                <div id="live_latex"></div>
                        </div>
                        
                        <div>
                            <button type="button" id="add_subquestions" class="btn btn-primary">Subvragen toevoegen</button>
                            <div class="mainquestion_required">*Je moet eerst een hoofdvraag aanmaken.</div>
                        </div>
                        
                        
                        <div class="subquestions">
                            
                            <div>
                                <h2>Previous subquestions</h2>
                                <div class="previoussubquestions">
                                    
                                </div>
                            </div>
                            
                            <div>
                                <label for="subquestion">Subvraag:</label>
                                <label for="sub_number">Nummer:</label>
                                <input type="number" name="sub_nr" id="sub_nr" min="1" value="1" required>
                                
                                <div class="math-controls-sub">
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\sqrt"
                                             data-balloon-pos="up">\sqrt{n}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\nthroot"
                                             data-balloon-pos="up">
                                            \sqrt[n]{x}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="type"
                                             data-balloon="\Leftrightarrow\\" data-balloon-pos="up">
                                            \Leftrightarrow
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\text"
                                             data-balloon-pos="up">
                                            \text{Text}
                                        </div>
                                        <div class="btn btn-default btn-cursor" data-type="cmd" data-balloon="\frac"
                                             data-balloon-pos="up">
                                            \frac{x}{y}
                                        </div>
                                    </div>
                                    <span id="subquestion"
                                          class="form-control mq-editable-field mq-math-mode"></span>
                                    <input type="" name="subquestions-latex[]" id="subquestion_latex">
                                    <div class="editing-controls hidden">
                                        <div class="btn btn-success" id="change-step-solution">Stap aanpassen</div>
                                        <div class="btn btn-danger" id="cancel-change-step-solution">Stap aanpassen
                                            annuleren
                                        </div>
								    </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary new_sub">Subvraag toevoegen</button>
                            
                            
                            
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
			var latexInput = document.getElementById('question_latex');
			
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
            
            //var liveLatex = mathField.latex();
            //MQ.StaticMath($("#live_latex").latex(liveLatex));
            
            // Render the latex of the mathfield
			var render_live_math = function () {
				// Live render the latex
				var liveLatex = mathField.latex();
				MQ.StaticMath(latexInput).latex(liveLatex);
				// Set the latex into a hidden textfield
				latexInput.value = liveLatex;
			};
			
            // Add event listen so that also a text element triggers a render
			var $mathFieldLive = $("#question");
			$mathFieldLive.on("keyup", "textarea", function () {
				render_live_math();
			});
            
            
			
            //get all control buttons
			var $mathControls = $('.math-controls');
			
           // Give the buttons also fancy math
			$mathControls.find('div').each(function () {
				// Render the math in the math control buttons
				MQ.StaticMath($(this)[ 0 ]);
			});
			
			// Handles when a button of math insert is clicked
			$mathControls.on('click', 'div', function () {
				// Insert the math from the button into the math input field
				switch ($(this).data('type')) {
					case 'type':
						// Simulate typing text
						mathField.typedText($(this).data('balloon'));
						break;
					case 'cmd':
						// Put the latex command in it
						mathField.cmd($(this).data('balloon'));
						break;
				}
				// Lose focus from button
				$(this).find('.mq-hasCursor').removeClass('mq-hasCursor');
				
				// Make sure it is rendered
				//render_live_math();
				
				// Focus the math field input
				mathField.focus();
			});
            
            
            
            /* SUBQUESTIONS */
            
            var renderedSubquestion = document.getElementById('subquestion');
			var latexInputSubquestion = document.getElementById('subquestion_latex');
            var editing_sub = false;
            
            var subquestioncounter = 1;
            var $editingControls = $(".editing-controls");
			
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
				
                
                // Insert the math from the button into the math input field
				switch ($(this).data('type')) {
					case 'type':
						// Simulate typing text
						mathFieldSub.typedText($(this).data('balloon')).focus();
						break;
					case 'cmd':
						// Put the latex command in it
						mathFieldSub.cmd($(this).data('balloon')).focus();
						break;
				}
			});
            
            //slide add subquestions open
            $("#add_subquestions").click(function () {
                if($("#question_latex").val()) {
                    $(".subquestions").show();
                    $(".mainquestion_required").removeClass("visible");
                }
                else {
                    $(".mainquestion_required").addClass("visible");
                }
            });
            
            
            $(".new_sub").click(function() {
                //var name = "test" + subquestioncounter;
                var name = "subq[]";
                //check if sub_nr is filled in
                if($("#sub_nr").val()) {
                    //save previous question  (nog op te kuisen ! )
                    $(".previoussubquestions").append('<div class="previousSub' + subquestioncounter + '" counter="' + subquestioncounter +'"><input type=hidden name=' + name + ' type="text" value="' + $("#sub_nr").val() + '*' + latexInputSubquestion.value + '"><span class="renderedSub">' + latexInputSubquestion.value + '</span><span class="previousSubControls"><i class="fa fa-pencil edit" aria-hidden="true"></i><i class="fa fa-times delete" aria-hidden="true"></i></span></div>');
                    
                    subquestioncounter++;
                    
                    //clear the input
                    $("#subquestion .mq-root-block").text("");
                    latexInputSubquestion.value = "";
                    mathFieldSub.latex("");
                    $("#sub_nr").val(subquestioncounter);
                }
                else {
                    alert("subnr invullen!");
                }
                
                
                for(var i = 0; i < $(".renderedSub").length; i++) {
                    //console.log($(".renderedSub")[i]);
                    MQ.StaticMath($(".renderedSub")[i]);
                }
                
                
            });
            
            // Render the latex of the mathfield
			var render_live_math_sub = function () {
				// Live render the latex
				var liveLatex = mathFieldSub.latex();
				MQ.StaticMath(latexInputSubquestion).latex(liveLatex);
				// Set the latex into a hidden textfield
				latexInputSubquestion.value = liveLatex;
			};
			
            // Add event listen so that also a text element triggers a render
			var $mathFieldLiveSub = $("#subquestion");
			$mathFieldLiveSub.on("keyup", "textarea", function () {
				render_live_math_sub();
			});
            
            /* edit subquestion */
            $(".previoussubquestions").on("click", ".previousSubControls .edit", function(event){
                //console.log($(this).parent().parent().find("input").val());
                //$("#subquestion .mq-root-block").text($(this).parent().parent().find("input").val());
                $editingControls.removeClass("hidden");
                set_latex_to_live($(this).parent().parent().find("input").val().substr($(this).parent().parent().find("input").val().indexOf("*") + 1));
                is_editing = $(this).parent().parent().attr('counter');
                
            });
            
            var set_latex_to_live = function ( latex ) {
				mathFieldSub.latex(latex).focus();
				render_live_math_sub();
			};
            
            // Handles the options when editing a step
			$editingControls
				.on("click", "#change-step-solution", function () {
					console.log("clicked Change step");
					push_editing_to_step();
				})
				.on("click", "#cancel-change-step-solution", function () {
					console.log("Clicked cancel step change");
					stop_editing();
				});
            
            // Stop/cancel the editing
			var stop_editing = function () {
				// Hide the controls
				$editingControls.addClass("hidden");
				// remove the class that it is editing
				var $root_solution_step = $("#solution-" + is_editing);
				$root_solution_step.removeClass("is_editing");
				
				// Make live empty
				set_latex_to_live("");
				
				// set the global var to null
				is_editing = null;
			};
			
			// Save the editing (live field) to the step
			var push_editing_to_step = function () {
				var latex = fetch_live_latex();
				var $root_editing_element = $("#solution-" + is_editing);
				
				set_and_render_latex_to_step($root_editing_element, latex);
				
				stop_editing();
			};
            
            // Get the latex of the live math field
			var fetch_live_latex = function () {
				var $latexLiveRender = $("#subquestion_latex");
				return $latexLiveRender.val();
			};
            
            
		})(jQuery, MathQuill);
	</script>
@endsection
