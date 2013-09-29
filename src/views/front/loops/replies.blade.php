<ul id="topic-{{{ $topic->id }}}-replies" class="forums replies">
	<li class="forum-header">
		<ul class="forum-titles">
			<li class="reply-author">Author</li>
			<li class="reply-content">Replies</li>
		</ul>
	</li>
	<li class="forum-body">
	@include('forums::front.singles.lead')

	@if($replies->count() > 0)
		@foreach($replies as $reply)
			@include('forums::front.singles.reply')
		@endforeach
	@endif
	</li>
	<li class="forum-footer">
		{{ $replies->links() }}
	</li>
</ul>
