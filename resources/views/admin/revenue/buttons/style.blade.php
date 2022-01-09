@if($status==1)
    <div class="alert-warning">الإيرادة مفتوحة</div>
@elseif($status==0)
    <div class="alert-success">{{ $close_date }}</div>
@endif
