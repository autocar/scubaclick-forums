@if(is_null($post))
	<p>----</p>
@else
	<p>
		<a href="{{{ $post->getLink() }}}" title="Created on {{{ $post->created_at }}}">
			{{{ $post->updated_at->diffForHumans() }}}
		</a><br />
		<span class="forum-latest-poster">by {{{ $post->user->full_name }}}</span>
	</p>
@endif
