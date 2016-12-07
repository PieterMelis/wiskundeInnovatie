@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Oplossing toevoegen</div>
					
					<div class="panel-body">
						<div class="question">
							Placeholder for question
						</div>
						<form method="POST">
							<div class="form-group" id="render-solution">
								<div class="solution-step" id="solution-template">
									<div class="render-field" id="render-template"></div>
									<div class="solution-step-controls">
										<i class="fa fa-copy copy" aria-hidden="true"></i>
										<i class="fa fa-pencil edit" aria-hidden="true"></i>
										<i class="fa fa-times delete" aria-hidden="true"></i>
									</div>
									<input type="hidden" name="solutions-latex[]" class="solution-latex">
								</div>
								<div class="solution-step" id="solution-live-render">
									<p>Live preview</p>
									<div id="live-render"></div>
									<input type="hidden" name="solutions-latex[]" id="solution-latex-live">
								</div>
							</div>
							<div class="form-group">
								<label for="solution">Oplossing</label>
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
								<span id="solution"
									  class="form-control mq-editable-field mq-math-mode"></span>
								<div class="editing-controls hidden">
									<div class="btn btn-success" id="change-step-solution">Stap aanpassen</div>
									<div class="btn btn-danger" id="cancel-change-step-solution">Stap aanpassen
										annuleren
									</div>
								</div>
							</div>
							<div class="solution-controls">
								<div class="btn btn-default" id="add-step-solution">Nieuwe tussen stap toevoegen</div>
								<div class="btn btn-default" id="add-photo">Foto toevoegen</div>
							</div>
							<div>
								<input type="submit" class="btn btn-success" value="Oplossing toevoegen">
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
		(function ( window, document, $, undefined ) {
			// Set step counter to zero
			var solutionStepCounter = 0;
			
			// Get the default elements
			var mathFieldSpan = document.getElementById('solution');
			var latexInput = document.getElementById('solution-latex-live');
			var liveRender = document.getElementById('live-render');
			
			var $editingControls = $(".editing-controls");
			
			var is_editing = null;
			
			// Get a MathQuill instance
			var MQ = MathQuill.getInterface(2);
			// Create the input math field
			var mathField = MQ.MathField(mathFieldSpan, {
				spaceBehavesLikeTab: true, // configurable
				handlers: {
					edit: function () {
						// Live render the latex
						var liveLatex = mathField.latex();
						console.log(liveLatex);
						MQ.StaticMath(liveRender).latex(liveLatex);
						// Set the latex into a hidden textfield
						latexInput.value = liveLatex;
					}
				}
			});
			// Empty the input math field
			mathField.latex("");
			
			// Find the math control buttons
			var $mathControls = $('.math-controls');
			
			$mathControls.find('div').each(function ( i ) {
				// Render the math in the math control buttons
				MQ.StaticMath($(this)[ 0 ]);
			});
			
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
				
				// Focus the math field input
				mathField.focus();
			});
			
			$editingControls
				.on("click", "#change-step-solution", function () {
					console.log("clicked Change step");
					push_editing_to_step();
				})
				.on("click", "#cancel-change-step-solution", function () {
					console.log("Clicked cancel step change");
					stop_editing();
				});
			
			$("#solution").on("keyup", "textarea", function ( event ) {
				if (event.keyCode === 13 && event.altKey) {
					console.log("trigA");
					var latex = add_new_solution_step();
					console.log(latex);
					copy_latex_to_live(latex);
				}
				else if (event.keyCode === 13) {
					console.log("trigC");
					add_new_solution_step();
				}
			});
			
			$("#render-solution")
				.on("click", ".solution-step-controls .edit", function () {
					// Start editing a previous solution step
					var $root = $(this).parent().parent();
					edit_root_solution_step($root);
					
					console.log("edit");
				})
				.on("click", ".solution-step-controls .delete", function () {
					// Delete a solution step (remove the parent)
					$(this).parent().parent().remove();
				})
				.on("click", ".solution-step-controls .copy", function () {
					// Copy the latex into the math field input
					var latex = $(this).parent().next().val();
					copy_latex_to_live(latex);
				});
			
			$(".mq-hasCursor").removeClass('mq-hasCursor');
			
			$(".solution-controls").on("click", "#add-step-solution", function () {
				add_new_solution_step();
			});
			
			var add_new_solution_step = function () {
				// Add a new step
				// Increment the solution step counter for unique ids
				solutionStepCounter++;
				
				// Get the latex from the current input
				var latex = fetch_live_latex();
				
				// Create a new step
				var $newStep = make_new_step(latex);
				
				// Set and render the latex
				set_and_render_latex_to_step($newStep, latex);
				
				// Prepend the new template to the live render fields
				$("#solution-live-render").before($newStep);
				
				// Focus the math field input
				mathField.latex("").focus();
				
				check_if_editing();
				
				return latex;
			};
			
			var make_new_step = function () {
				// Find the template in the dom and clone in new jQuery object
				var $template = $("#solution-template").clone();
				var $mathRender = $template.find("#render-template");
				
				// Change the ids to unique ids with solution step
				$template.attr('id', 'solution-' + solutionStepCounter);
				$mathRender.attr('id', 'render-' + solutionStepCounter);
				$template.data('counter', solutionStepCounter);
				
				return $template;
			};
			
			var set_and_render_latex_to_step = function ( $rootStep, latex ) {
				var $latexInput = $rootStep.find("input");
				var mathField = $rootStep.find(".render-field")[ 0 ];
				
				// Set the input of the template to latex input
				$latexInput.val(latex);
				
				// Render the math of the template
				MQ.StaticMath(mathField).latex(latex);
			};
			
			var fetch_live_latex = function () {
				var $latexLiveRender = $("#solution-latex-live");
				return $latexLiveRender.val();
			};
			
			var check_if_editing = function(){
				if (is_editing !== null) {
					// If an other is being edited, discard current edit
					stop_editing();
				}
			};
			
			var edit_root_solution_step = function ( $root_solution_step ) {
				check_if_editing();
				$editingControls.removeClass("hidden");
				$root_solution_step.addClass("is_editing");
				is_editing = $root_solution_step.data("counter");
				
				var latex = $root_solution_step.find("input").first().val();
				copy_latex_to_live(latex);
			};
			
			var stop_editing = function () {
				// remove the class that it is editing
				$editingControls.addClass("hidden");
				var $root_solution_step = $("#solution-" + is_editing);
				$root_solution_step.removeClass("is_editing");
				
				// Make live empty
				copy_latex_to_live("");
				
				// set the global var to null
				is_editing = null;
			};
			
			var push_editing_to_step = function () {
				var latex = fetch_live_latex();
				var $root_editing_element = $("#solution-" + is_editing);
				
				set_and_render_latex_to_step($root_editing_element, latex);
				
				stop_editing();
			};
			
			var copy_latex_to_live = function ( latex ) {
				mathField.latex(latex).focus();
			};
			
		})(window, window.document, window.jQuery);
	</script>
@endsection