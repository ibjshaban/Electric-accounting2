<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>جدول الطباعة</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <style>
        body {
            margin: auto;
            text-align: right;
        }

        table {
            width: 100%;
        }

        table thead tr th {
            text-align: right !important;
        }
        img{
            margin-right: 46%;
            width: 300px;
        }
    </style>
</head>
<body>
<header>

</header>
{{--<img src="{{ asset('assets/img/motor-logo.jpeg') }}">--}}
<table class="table table-bordered table-condensed table-striped">
    {{-- @foreach($data as $row)
         @if ($loop->first)
             <tr>
                 @foreach($row as $key => $value)
                     <th>{!! $key !!}</th>
                 @endforeach
             </tr>
         @endif
         <tr>
             @foreach($row as $key => $value)
                 @if(is_string($value) || is_numeric($value))
                     <td>{!! $value !!}</td>
                 @else
                     <td></td>
                 @endif
             @endforeach
         </tr>
     @endforeach--}}
    <thead>
    <tr>
        <th colspan="2"></th>
        <th colspan="1">له</th>
        <th colspan="4">عليه</th>
    </tr>
    <tr>
        <th>البيان</th>
        <th>تاريخ الحركة</th>
        <th></th>
        <th></th>
        <th>الرصيد النهائي</th>
    </tr>
    </thead>
    <tbody>
    <tbody>
    @foreach($data as $item)
        @if($item->type == 0)
            <tr>
                <td>إيداع راتب @if($item->note)- ملاحظة: {{$item->note}} @endif</td>
                <td>{{$item->payment_date}}</td>
                <td><span class="tag tag-success">{{ShekelFormat($item->total_amount)}}</span></td>
                <td>{{ShekelFormat(-$item->discount)}}</td>
                <td>{{ShekelFormat($item->salary)}}</td>
            </tr>
        @else
            <tr>
                <td>سحب دين @if($item->note)- ملاحظة: {{$item->note}} @endif</td>
                <td>{{$item->payment_date}}</td>
                <td><span class="tag tag-success"></span></td>
                <td>{{ShekelFormat(-$item->total_amount)}}</td>
                <td>{{ShekelFormat(-$item->total_amount)}}</td>
            </tr>
        @endif
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td><span class="tag tag-success"></span></td>
        <td> الدين
            المتبقي: {{ShekelFormat($data->where('type',1)->sum('total_amount') - $data->where('type',0)->sum('discount'))}}</td>
        <td></td>
    </tr>
    <tr>
        <td>المجموع:</td>
        <td></td>
        <td><span
                class="tag tag-success">{{ShekelFormat($data->where('type',0)->sum('total_amount'))}}</span>
        </td>
        <td>{{ShekelFormat(- $data->where('type',1)->sum('total_amount'))}}</td>
        <td></td>
    </tr>
    </tbody>

</table>
</body>
</html>
