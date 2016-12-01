@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Oplossing toevoegen</div>
					
					<div class="panel-body">
						<form method="POST">
							<div class="form-group">
								<label for="solution">Oplossing</label>
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
								<span id="solution"
									  class="form-control mq-editable-field mq-math-mode"></span>
								<input type="hidden" name="solutions-latex[]" id="solution-latex">
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
		(function ( $, MathQuill ) {
			var mathFieldSpan = document.getElementById('solution');
			var latexInput = document.getElementById('solution-latex');
			
			var MQ = MathQuill.getInterface(2); // for backcompat
			var mathField = MQ.MathField(mathFieldSpan, {
				spaceBehavesLikeTab: true, // configurable
				handlers: {
					edit: function () { // useful event handlers
						console.log(mathField.latex());
						latexInput.value = mathField.latex(); // simple API
					}
				}
			});
			
			var $mathControls = $('.math-controls');
			
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
		})(jQuery, MathQuill);
	</script>
@endsection