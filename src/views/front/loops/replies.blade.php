<ul id="topic-{{{ $topic->id }}}-replies" class="forums replies">
	<li class="forum-body">
	@include('forums::front.singles.lead')

	@if($replies->count() > 0)
		@foreach($replies as $reply)
			@include('forums::front.singles.reply')
		@endforeach
	@endif
	</li>
	<li class="forum-footer">
		{{ $replies->links() }}
	</li>
</ul>

@if($topic->currentUserCanReply())
	{{ Form::open(array('method' => 'POST', 'class' => 'form-horizontal forum-form')) }}
		@include('forums::front.forms.reply')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to reply to this topic.</div>
@endif
