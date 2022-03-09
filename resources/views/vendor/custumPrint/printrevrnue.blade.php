
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>{{ $title }}</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 20px;
            float: right;
            width: 90%;
            color: black;
        }
    </style>
</head>

<body>

    @php


        if(count($expenses) != 0){
            $exp = $expenses;
        }else{
            if(!$print){
            $revenue_id = App\Models\Expenses::where('id', $data[0]['رقم'])->first()->revenue_id;
            $exp = App\Models\Expenses::where('revenue_id', $revenue_id)->latest()->get();
            }else {
                $exp = [];
            }
        }
    @endphp

    <div style="text-align: center;">
        <img src="{{ asset('assets/img/motor-logo.jpeg') }}" alt="{{ __('') }}">
        <h1>{{ $title }}</h1>
        <table class="table table-bordered table-hover">
            @php
                $id = 1;
            @endphp
            @foreach ($exp as $revenue)
                @if ($loop->first)
                    <tr>
                        <td>#</td>
                        <td>البيان</td>
                        <td>الخصم</td>
                        <td>السعر</td>
                        <td>التاريخ</td>
                        <td>الايرادة</td>
                        <td>البيان/</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $id }}</td>
                    <td>{{ $revenue->name }}</td>
                    <td>{{ $revenue->discount }}</td>
                    <td>{{ $revenue->price }}</td>
                    <td>{{ $revenue->date }}</td>
                    <td>{{ App\Models\revenue::where('id', $revenue_id)->first()->name }}</td>
                    <td>
                        @if (count($revenue->item()) != 0)
                            @php
                                $total = 0;
                                $i = 1;
                            @endphp
                            <table class="table table-bordered table-hover">
                                @foreach ($revenue->item() as $item)
                                    @if ($loop->first)
                                        <tr>
                                            <td>الصنف</td>
                                            <td>الكمية</td>
                                            <td>سعر الوحدة</td>
                                            <td>سعر الكمية</td>
                                        <tr>
                                    @endif

                                    <tr>
                                        <td>{{ $item->item }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->price * $item->amount }}</td>
                                    <tr>
                                        @php
                                            $total += $item->price * $item->amount;
                                            $i++;
                                        @endphp
                                @endforeach
                            </table>
                            <h5>مجموع سعر الكمية = {{ $total }} </h5>
                            <h5>الخصم = {{ $revenue->discount }} </h5>
                        @endif
                    </td>
                </tr>
                @php
                    $id++;
                @endphp
            @endforeach
        </table>
        @if($totalPrice != 0 && $total_name != null)
        <h2>{{ $total_name . ':' . $totalPrice }} </h2>
        @endif
    </div>


</body>

</html>
