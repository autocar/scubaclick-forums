@foreach($topic->labels as $label)
	<a href="{{{ $label->getArchiveLink() }}}" class="btn btn-mini">{{{ $label->title }}}</a>
@endforeach
