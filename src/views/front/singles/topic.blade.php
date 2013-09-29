<ul id="topic-{{{ $topic->id }}}">
	<li class="topic-title">
		<a class="topic-permalink" href="{{{ $topic->getLink() }}}" title="{{{ $topic->title }}}">
			{{{ $topic->title }}}
		</a>

		<p class="topic-meta">
			<span class="topic-started-by">{{{ $topic->user->getFullName() }}}</span>
		</p>
	</li>
	<li class="topic-voice-count">
		
	</li>
	<li class="topic-reply-count">
		
	</li>
	<li class="topic-freshness">
		<p class="topic-meta">
			<span class="topic-freshness-author"></span>
		</p>
	</li>
</ul>
