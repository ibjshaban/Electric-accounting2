
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>{{ $title }}</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <style>
        body {
            margin: 20px;
            float: right;
            width: 90%;
            color: black;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        injected stylesheet * {
            outline: none !important;
        }

        user agent stylesheet table {
            display: table;
            border-collapse: separate;
            box-sizing: border-box;
            text-indent: initial;
            border-spacing: 2px;
            border-color: grey;
        }

        style attribute {
            text-align: center;
        }

        body {
            margin: 20px;
            float: right;
            width: 90%;
            color: black;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
        }

        html {
            font-size: 10px;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        :after,
        :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        :after,
        :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        td,
        th {
            padding: 0;
        }

        user agent stylesheet td {
            display: table-cell;
            vertical-align: inherit;
        }
    </style>
</head>

<body>

    @php


        if($expenses && count($expenses) != 0){
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
                $totalPrice = 0;
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
                    $totalPrice += $revenue->price;
                @endphp
            @endforeach
        </table>
        @if($totalPrice != 0 )
        <h2>{{ 'السعر الكلي:' . $totalPrice }} </h2>
        @endif
    </div>


</body>

</html>
