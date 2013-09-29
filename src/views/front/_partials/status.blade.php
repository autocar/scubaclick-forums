@if($status == 'open')
	<span class="label label-info">Open</span>
@elseif($status == 'resolved')
	<span class="label label-success">Resolved</span>
@endif
