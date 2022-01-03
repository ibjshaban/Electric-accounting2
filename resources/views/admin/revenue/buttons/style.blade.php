@if($status)
    <div class="alert-warning">الإيرادة مفتوحة</div>
@else
    <div class="alert-success">{{ $close_date }}</div>
@endif
