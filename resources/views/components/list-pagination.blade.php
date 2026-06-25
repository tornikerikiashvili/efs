@if ($paginator->hasPages())
    <hr class="space m">
    {{ $paginator->links() }}
@endif
