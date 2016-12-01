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
								<input type="text" name="solution" id="solution" class="form-control">
								<input type="hidden" name="solution-latex">
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
		var mathFieldSpan = document.getElementById('solution');
		var latexInput = document.getElementById('solution-latex');
		
		var MQ = MathQuill.getInterface(2); // for backcompat
		var mathField = MQ.MathField(mathFieldSpan, {
			spaceBehavesLikeTab: true, // configurable
			handlers: {
				edit: function() { // useful event handlers
					latexInput.value = mathField.latex(); // simple API
				}
			}
		});
	</script>
@endsection