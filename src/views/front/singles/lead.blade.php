@if($topic->showLead())
<div class="forum-lead">
	<ul class="forum-reply-header forum-lego">
		<li class="forum-reply-author">
			{{{ $topic->user->getFullName() }}}
		</li>
		<li class="forum-reply-content">
			<span class="forum-reply-date">
				{{{ $topic->created_at->format('l, F j, Y H:i') }}}
			</span>

			<a href="{{{ $topic->getLink() }}}" title="{{{ $topic->title }}}" class="forum-reply-permalink">#</a>
		</li>
	</ul>
	<ul class="forum-reply-body forum-lego">
		<li class="forum-reply-author">
			<img src="{{{ $topic->user->getAvatarUrl(80) }}}" width="" height="" alt="" class="img-rounded avatar" />
		</li>
		<li class="forum-reply-content">
			{{ $topic->content }}
		</li>
	</ul>
</div>
@endif
