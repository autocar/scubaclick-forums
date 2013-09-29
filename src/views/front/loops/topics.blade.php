<ul id="forum-{{{ $forum->id }}}" class="forums topics">
	<li class="forum-header">
		<ul class="forum-titles">
			<li class="topic-title">Topic</li>
			<li class="topic-voice-count">Voices</li>
			<li class="topic-reply-count">Replies</li>
			<li class="topic-freshness">Freshness</li>
		</ul>
	</li>
	<li class="forum-body">
	@if($topics->count() > 0)
		@foreach($topics as $topic)
			@include('forums::front.singles.topic')
		@endforeach
	@else
		<div class="alert alert-info">No topics yet, but stay tuned</div>
	@endif
	</li>
	<li class="forum-footer">
		{{ $topics->links() }}
	</li>
</ul>
