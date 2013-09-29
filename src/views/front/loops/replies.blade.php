<ul id="topic-{{{ $topic->id }}}-replies" class="forums replies">
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

{{ Form::open() }}
	@include('forums::front.forms.reply')
{{ Form::close() }}
