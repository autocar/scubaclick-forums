@if($topic->showLead())
<div class="forum-lead">
	<ul class="forum-reply-header forum-lego">
		<li class="forum-reply-author">
			{{{ $topic->user->full_name }}}
		</li>
		<li class="forum-reply-content">
			<span class="forum-reply-date">
				{{{ $topic->created_at->format('l, F j, Y H:i') }}}
			</span>

			@include('forums::front._partials.lead-actions')
		</li>
	</ul>
	<ul class="forum-reply-body forum-lego">
		<li class="forum-reply-author">
			<img src="{{{ $topic->user->getAvatarUrl(80) }}}" width="" height="" alt="" class="img-rounded avatar" />
		</li>
		<li class="forum-reply-content">
			{{ $topic->content }}

			@if($topic->wasEdited())
				<p class="last-edited">Last edited on {{{ $topic->edited_at->format('l, F j, Y H:i') }}}</p>
			@endif
		</li>
	</ul>
</div>
@endif
