<div class="control-group">
	{{ Form::label('title', 'Title', ['req' => true, 'class' => 'control-label']) }}
	<div class="controls">
	    {{ $errors->first('title') }}
	    {{ Form::text('title', null, ['class' => 'span8']) }}
	</div>
</div>

<div class="control-group">
	{{ Form::label('content', 'Content', ['req' => true, 'class' => 'control-label']) }}
	<div class="controls">
	    {{ $errors->first('content') }}
	    {{ Form::textarea('content', null, ['class' => 'span8 wysiwyg', 'rows' => 7]) }}
	</div>
</div>

<div class="control-group">
	{{ Form::label('labels', 'Tags', ['class' => 'control-label']) }}
	<div class="controls">
	    {{ $errors->first('labels') }}
	    {{ Form::text('labels', null, ['class' => 'span8']) }}
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-medium btn-success">Post</button>
	</div>
</div>
