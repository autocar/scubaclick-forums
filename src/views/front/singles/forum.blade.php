<ul id="forum-{{{ $forum->id }}}">
	<li class="forum-info">
		<a class="forum-title" href="{{{ $forum->getLink() }}}" title="{{{ $forum->title }}}">
			{{{ $forum->title }}}
		</a>

		<div class="forum-content">
			{{ $forum->content }}
		</div>
	</li>
	<li class="forum-topic-count">
		
	</li>
	<li class="forum-reply-count">
		
	</li>
	<li class="forum-freshness">
		<p class="topic-meta">
			<span class="topic-freshness-author">
				
			</span>
		</p>
	</li>
</ul>
