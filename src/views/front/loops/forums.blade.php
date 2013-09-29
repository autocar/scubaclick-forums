<ul id="forums-list" class="forums">
	<li class="forum-header">
		<ul class="forum-titles">
			<li class="forum-info">Forum</li>
			<li class="forum-topic-count">Topics</li>
			<li class="forum-reply-count">Replies</li>
			<li class="forum-freshness">Freshness</li>
		</ul>
	</li>
	<li class="forum-body">
	@if($forums->count() > 0)
		@foreach($forums as $forum)
			@include('forums::front.singles.forum')
		@endforeach
	@else
		<div class="alert alert-info">No forums yet, but stay tuned</div>
	@endif
	</li>
	<li class="forum-footer">
		{{ $forums->links() }}
	</li>
</ul>
