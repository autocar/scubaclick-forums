<div id="reply-{{{ $reply->id }}}" class="forum-reply">
	<ul class="forum-reply-header forum-lego">
		<li class="forum-reply-author">
			{{{ $reply->user->full_name }}}
		</li>
		<li class="forum-reply-content">
			<span class="forum-reply-date">
				{{{ $reply->created_at->format('l, F j, Y H:i') }}}
			</span>

			@include('forums::front._partials.reply-actions')
		</li>
	</ul>
	<ul class="forum-reply-body forum-lego">
		<li class="forum-reply-author">
			<img src="{{{ $reply->user->getAvatarUrl(80) }}}" width="" height="" alt="" class="img-rounded avatar" />
		</li>
		<li class="forum-reply-content">
			{{ $reply->content }}

			@if($reply->wasEdited())
				<p class="last-edited">Last edited on {{{ $reply->updated_at->format('l, F j, Y H:i') }}}</p>

			@endif
		</li>
	</ul>
</div>
