<div class="control-group">
	{{ Form::label('content', 'Content', array('req' => true, 'class' => 'control-label')) }}
	<div class="controls">
	    {{ $errors->first('content') }}
	    {{ Form::textarea('content', null, array('class' => 'span8 wysiwyg', 'rows' => 7)) }}
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-medium btn-success">Reply</button>
	</div>
</div>
