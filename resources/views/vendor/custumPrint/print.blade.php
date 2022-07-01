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
        if ($basic != null && count($basic) != 0) {
            $ba = $basic;
        } else {
            if (!$print) {
                $basic_id = App\Models\BasicParentItem::where('id', $data[0]['رقم'])->first()->basic_id;
                $ba = App\Models\BasicParentItem::where('basic_id', $basic_id)
                    ->latest()
                    ->get();
            } else {
                $ba = [];
            }
        }
    @endphp


    <div style="text-align: center;">
        <img src="{{ asset('assets/img/motor-logo.jpeg') }}" alt="{{ __('') }}" class="mb-2">
        <h1>{{ $title }}</h1>
        <table class="table table-bordered table-hover">
            @php
                $id = 1;
                $totalPrice = 0;
            @endphp
            @foreach ($ba as $basic)
                @if ($loop->first)
                    <tr>
                        <td>#</td>
                        <td>البيان</td>
                        <td>السعر</td>
                        <td>الخصم</td>
                        <td>التاريخ</td>
                        <td>التفاصيل</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $id }}</td>
                    <td>{{ $basic->name }}</td>
                    <td>{{ $basic->price }}</td>
                    <td>{{ $basic->discount }}</td>
                    <td>{{ $basic->date }}</td>
                    <td>
                        @if (count($basic->item()) != 0)
                            @php
                                $total = 0;
                                $i = 1;
                            @endphp
                            <table class="table table-bordered table-hover">
                                @foreach ($basic->item() as $item)
                                    @if ($loop->first)
                                        <tr>
                                            <td>الرقم</td>
                                            <td>السعر</td>
                                            <td>الكمية</td>
                                            <td>سعر الكمية</td>
                                            <td>الملاحظات</td>
                                        <tr>
                                    @endif

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->price * $item->amount }}</td>
                                        <td>{{ $item->note }}</td>
                                    <tr>
                                        @php
                                            $total += $item->price * $item->amount;
                                            $i++;
                                        @endphp
                                @endforeach
                            </table>
                            <h5>مجموع سعر الكمية = {{ $total }} </h5>
                            <h5>الخصم = {{ $basic->discount }} </h5>
                        @endif
                    </td>
                </tr>
                @php
                    $id++;
                    $totalPrice += $basic->price;
                @endphp
            @endforeach
        </table>

        @if ($totalPrice != 0)
            <h2>{{ 'السعر الكلي:' . $totalPrice }} </h2>
        @endif
    </div>


</body>

</html>
