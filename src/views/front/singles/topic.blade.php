<ul id="forum-topic-{{{ $topic->id }}}" class="forum-lego">
	<li class="forum-topic-info">
		{{ $topic->getStatusLabel() }}
		<a class="forum-topic-permalink" href="{{{ $topic->getLink() }}}" title="{{{ $topic->title }}}">
			{{{ $topic->title }}}
		</a>

		@if(isset($label))
			in <a href="{{{ $topic->forum->getLink() }}}">{{{ $topic->forum->title }}}</a>
		@endif

		@include('forums::front._partials.pagination')

		<div class="forum-meta">
			<p>by {{{ $topic->user->full_name }}}</p>
		</div>
	</li>
	<li class="forum-topic-voice-count">
		<span class="badge badge-info">{{{ $topic->getVoices() }}}</span>
	</li>
	<li class="forum-topic-reply-count">
		<span class="badge badge-info">{{{ $topic->replies->count() }}}</span>
	</li>
	<li class="forum-topic-view-count">
		<span class="badge badge-info">{{{ $topic->views }}}</span>
	</li>
	<li class="forum-topic-freshness">
		{{ $topic->getFreshness() }}
	</li>
</ul>
