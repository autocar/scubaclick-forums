@if ($topic->isPaged())
<div class="pagination mini-pagination">
    <ul>
        {{ $topic->getMiniPagination() }}
    </ul>
</div>
@endif
