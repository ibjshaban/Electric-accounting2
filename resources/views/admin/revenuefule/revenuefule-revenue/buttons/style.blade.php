@if( $price*$quantity==$paid_amount)
    <div class="alert-success">{{ $paid_amount }}</div>
@else
    <div class="alert-danger">{{ $paid_amount }}</div>
@endif
