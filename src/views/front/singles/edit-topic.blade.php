@if($topic->currentUserCanEdit())
	{{ Form::model($topic, array('method' => 'POST')) }}
		@include('forums::front.forms.topic')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to edit this topic.</div>
@endif
