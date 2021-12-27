@if(!empty($deleted_at))
    <div class="alert-danger">{{ $name }}</div>
@else
    <div>{{ $name }}</div>
@endif

