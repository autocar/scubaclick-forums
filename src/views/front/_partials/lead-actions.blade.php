<div class="forum-actions btn-group">
	@if(Auth::user()->id == $topic->user_id)
		@if($topic->status == 'open')
			{{ Form::open(array('route' => array($topic->getRoutePrefix() .'forum.front.topic.resolve', $topic->forum->slug, $topic->slug))) }}
			<button title="Resolve {{{ $topic->title }}}" class="btn btn-mini btn-success forum-topic-resolvelink">
				Resolve
			</button>
			{{ Form::close() }}
		@else
			{{ Form::open(array('route' => array($topic->getRoutePrefix() .'forum.front.topic.reopen', $topic->forum->slug, $topic->slug))) }}
			<button title="Re-open {{{ $topic->title }}}" class="btn btn-mini btn-info forum-topic-reopenlink">
				Re-open
			</button>
			{{ Form::close() }}
		@endif

		<a href="{{{ $topic->getEditLink() }}}" title="Edit {{{ $topic->title }}}" class="btn btn-mini btn-info forum-topic-editlink">Edit</a> 

		{{ Form::open(array('route' => array($topic->getRoutePrefix() .'forum.front.topic.delete', $topic->forum->slug, $topic->slug))) }}
		<button title="Delete {{{ $topic->title }}}" class="btn btn-mini btn-warning forum-topic-deletelink">
			Delete
		</button>
		{{ Form::close() }}
	@endif

	<a href="{{{ $topic->getLink() }}}" title="{{{ $topic->title }}}" class="btn btn-mini btn-info forum-topic-permalink">#</a>
</div>
