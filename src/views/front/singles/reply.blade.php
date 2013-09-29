<ul class="reply-header">
	<li class="reply-meta">
		<span class="reply-date">
			{{{ $reply->created_at }}}
		</span>
		<a href="{{{ $reply->getLink() }}}" title="{{{ sprintf('Reply to %s', $reply->topic->title) }}}" class="reply-permalink">
			#{{{ $reply->id }}}
		</a>
	</li>
</ul>
<ul id="reply-{{{ $reply->id }}}">
	<li class="reply-author">
		{{{ $reply->user->getFullName() }}}
	</li>
	<li class="reply-content">
		{{ $reply->content }}
	</li>
</ul>
