<ul id="forum-{{{ $forum->id }}}" class="forum-lego">
	<li class="forum-info">
		@if($forum->status == 'closed')
			<span class="label label-important">Closed</span>
		@endif
		<a class="forum-title" href="{{{ $forum->getLink() }}}" title="{{{ $forum->title }}}">
			{{{ $forum->title }}}
		</a>

		<div class="forum-meta">
			{{ $forum->content }}
		</div>
	</li>
	<li class="forum-topic-count">
		<span class="badge badge-info">{{{ $forum->topics->count() }}}</span>
	</li>
	<li class="forum-reply-count">
		<span class="badge badge-info">{{{ $forum->getReplyCount() }}}</span>
	</li>
	<li class="forum-freshness">
		{{ $forum->getFreshness() }}
	</li>
</ul>
