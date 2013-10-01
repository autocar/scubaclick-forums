@if($topic->currentUserCanEdit())
	{{ Form::model($topic, array('route' => array($topic->getRoutePrefix() .'forum.front.topic.edit.action', $topic->forum->slug, $topic->slug), 'class' => 'form-horizontal forum-form')) }}
		@include('forums::front.forms.topic')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to edit this topic.</div>
@endif
