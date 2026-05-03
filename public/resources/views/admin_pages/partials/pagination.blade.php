@if(isset($paginator) && is_object($paginator) && method_exists($paginator, 'hasPages') && $paginator->hasPages())
  <nav class="d-inline-block">
    {{ $paginator->links('pagination::bootstrap-4') }}
  </nav>
@endif
