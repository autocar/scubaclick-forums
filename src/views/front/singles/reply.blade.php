<div id="reply-{{{ $reply->id }}}" class="forum-reply">
	<ul class="forum-reply-header forum-lego">
		<li class="forum-reply-author">
			{{{ $reply->user->getFullName() }}}
		</li>
		<li class="forum-reply-content">
			<span class="forum-reply-date">
				{{{ $reply->created_at->format('l, F j, Y H:i') }}}
			</span>

			<a href="{{{ $reply->getLink() }}}" title="{{{ $reply->getTitle() }}}" class="forum-reply-permalink">#</a>
		</li>
	</ul>
	<ul class="forum-reply-body forum-lego">
		<li class="forum-reply-author">
			<img src="{{{ $reply->user->getAvatarUrl(80) }}}" width="" height="" alt="" class="img-rounded avatar" />
		</li>
		<li class="forum-reply-content">
			{{ $reply->content }}
		</li>
	</ul>
</div>
