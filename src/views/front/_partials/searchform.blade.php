{{ Form::open(array('route' => array(get_route_prefix() .'forum.front.search'), 'method' => 'GET', 'id' => 'forum-search', 'class' => 'form-search')) }}
<div class="input-append">
	{{ Form::text('term', $term, array('class' => 'input-medium search-query')) }}
	<button type="submit" class="btn">Search</button>
</div>
{{ Form::close() }}
