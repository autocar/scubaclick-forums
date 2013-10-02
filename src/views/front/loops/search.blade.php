@include('forums::front._partials.searchform')

<ul id="forum-label-archive" class="forums topics">
	<li class="forum-header">
		<ul class="forum-lego">
			<li class="forum-topic-info">Topic</li>
			<li class="forum-topic-voice-count">Voices</li>
			<li class="forum-topic-reply-count">Replies</li>
			<li class="forum-topic-view-count">Views</li>
			<li class="forum-topic-freshness">Freshness</li>
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
