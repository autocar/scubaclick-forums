@if($reply->currentUserCanEdit())
	{{ Form::model($reply, array('method' => 'POST')) }}
		@include('forums::front.forms.reply')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to edit this reply.</div>
@endif
