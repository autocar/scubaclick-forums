<p class="forum-create">
	<i class="icon-double-angle-right"></i>
	<a href="#new-topic">Create new topic</a>
</p>

@include('forums::front._partials.searchform')

<ul id="forum-{{{ $forum->id }}}" class="forums topics">
	<li class="forum-header">
		<ul class="forum-lego">
			<li class="forum-topic-info">Topic</li>
			<li class="forum-topic-voice-count">Voices</li>
			<li class="forum-topic-reply-count">Replies</li>
			<li class="forum-topic-view-count">Views</li>
			<li class="forum-topic-freshness">Freshness</li>
		</ul>
	</li>
	<li class="forum-body">
	@if($topics->count() > 0)
		@foreach($topics as $topic)
			@include('forums::front.singles.topic')
		@endforeach
	@else
		<div class="alert alert-info">No topics yet, but stay tuned</div>
	@endif
	</li>
	<li class="forum-footer">
		{{ $topics->links() }}
	</li>
</ul>

@if($forum->currentUserCanPost())
	{{ Form::open(array('route' => array(get_route_prefix() .'forum.front.forum.topic', $forum->slug), 'id' => 'new-topic', 'class' => 'form-horizontal forum-form')) }}
		<h3>Add a Topic</h3>
		@include('forums::front.forms.topic')
	{{ Form::close() }}
@else
	<div class="alert alert-error">You are not allowed to create a topic in this forum.</div>
@endif
