@if (session('status'))
  <div class="alert alert-info">
    {{ session('status') }}
  </div>
@endif
@if (session('error'))
  <div class="alert alert-warning">
    {{ session('error') }}
  </div>
@endif
@if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif
