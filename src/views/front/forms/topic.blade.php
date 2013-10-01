<div class="control-group">
	{{ Form::label('title', 'Title', array('req' => true, 'class' => 'control-label')) }}
	<div class="controls">
	    {{ $errors->first('title') }}
	    {{ Form::text('title', null, array('class' => 'span8')) }}
	</div>
</div>

<div class="control-group">
	{{ Form::label('content', 'Content', array('req' => true, 'class' => 'control-label')) }}
	<div class="controls">
	    {{ $errors->first('content') }}
	    {{ Form::textarea('content', null, array('class' => 'span8 wysiwyg', 'rows' => 7)) }}
	</div>
</div>

<div class="control-group">
	{{ Form::label('labels', 'Tags', array('class' => 'control-label')) }}
	<div class="controls">
	    {{ $errors->first('labels') }}
        {{ Form::hidden('labels', $labels, array('id' => 'tags', 'class' => 'span8')) }}
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-medium btn-success">Post</button>
	</div>
</div>
