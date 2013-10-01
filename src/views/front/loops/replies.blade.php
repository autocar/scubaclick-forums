<ul id="topic-{{{ $topic->id }}}-replies" class="forums replies">
	<li class="forum-body">
	@include('forums::front.singles.lead')

	@if($replies->count() > 0)
		@foreach($replies as $reply)
			@include('forums::front.singles.reply')
		@endforeach
	@endif

	@if($topic->hasLabels())
		<p class="topic-tags">
			Tagged with:
			@include('forums::front._partials.labels')
		</p>
	@endif
	</li>
	<li class="forum-footer">
		{{ $replies->links() }}
	</li>
</ul>

@if($topic->currentUserCanReply())
	{{ Form::open(array('route' => array($topic->getRoutePrefix() .'forum.front.topic.reply', $topic->forum->slug, $topic->slug), 'id' => 'new-reply', 'class' => 'form-horizontal forum-form')) }}
		<h3>Add your Voice</h3>
		@include('forums::front.forms.reply')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to reply to this topic.</div>
@endif
