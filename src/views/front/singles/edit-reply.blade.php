@if($reply->currentUserCanEdit())
	{{ Form::model($reply, array('route' => array($reply->getRoutePrefix() .'forum.front.reply.edit.action', $reply->topic->forum->slug, $reply->topic->slug, $reply->id), 'class' => 'form-horizontal forum-form')) }}
		@include('forums::front.forms.reply')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to edit this reply.</div>
@endif
