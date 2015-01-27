<div class="form-group">
	{{ Form::label($name, $label, array('class' => 'col-sm-4 control-label')) }}
	<div class="col-sm-8 ">
		{{ $control }}
		@if ($error)
			<p class="label label-danger ">{{ $error }}</p>
		@endif
	</div>
</div>
