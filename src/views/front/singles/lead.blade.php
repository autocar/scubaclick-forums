@if($topic->showLead())
<ul class="lead-header">
	<li class="lead-meta">
		<span class="lead-date">
			{{{ $topic->created_at }}}
		</span>
		<a href="{{{ $topic->getLink() }}}" title="{{{ $topic->title }}}" class="lead-permalink">
			#{{{ $topic->id }}}
		</a>
	</li>
</ul>
<ul id="lead-{{{ $topic->id }}}">
	<li class="reply-author">
		{{{ $topic->user->getFullName() }}}
	</li>
	<li class="lead-content">
		{{ $topic->content }}
	</li>
</ul>
@endif
