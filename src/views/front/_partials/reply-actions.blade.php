<div class="forum-actions btn-group">
	@if(Auth::user()->id == $reply->user_id)
		<a href="{{{ $reply->getEditLink() }}}" title="Edit {{{ $reply->getTitle() }}}" class="btn btn-mini btn-info forum-reply-editlink">Edit</a>

		{{ Form::open(array('route' => array(get_route_prefix() .'forum.front.reply.delete', $reply->topic->forum->slug, $reply->topic->slug, $reply->id), 'method' => 'DELETE')) }}
		<button title="Delete {{{ $reply->getTitle() }}}" class="btn btn-mini btn-warning forum-reply-deletelink">
			Delete
		</button>
		{{ Form::close() }}
	@endif

	<a href="{{{ $reply->getLink() }}}" title="{{{ $reply->getTitle() }}}" class="btn btn-mini btn-info forum-reply-permalink">#</a>
</div>
