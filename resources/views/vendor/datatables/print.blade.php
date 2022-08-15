<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>{{ isset($title) ? $title : "مولدات زنزن و الشاعر" }}</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <style>
        body {
            margin: 20px;
            float: right;
            width: 90%;
            text-align: center;
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
    {{-- @dd($data) --}}
    @php
        $tableRows = count($data);
        $table = (int) ($tableRows / 24);
        $count = 0;
    @endphp

    <div style="text-align: center;">
        @for ($i = 0; $i <= $table; ++$i)
            <img src="{{ asset('assets/img/motor-logo.jpeg') }}">
            <h1>{{ isset($title)  ? $title : "" }}</h1>
            <table class="table table-bordered table-condensed table-striped" style="width: 100%;">
                @if ($count != count($data))
                    <tr>
                        @foreach ($data[$i] as $key => $value)
                            <th style="text-align: center;">{!! $key !!}</th>
                        @endforeach
                    </tr>
                @endif
                @for ($j = 0; $j < count($data); ++$j)
                    <tr>
                        @php
                            if ($count == count($data)) {
                                break;
                            }
                        @endphp
                        @foreach ($data[$count] as $key => $value)
                            @if (is_string($value) || is_numeric($value))
                                <td>{!! $value !!}</td>
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
                    @php
                        $count++;
                        if ($count % 24 == 0) {
                            $j = count($data);
                        }
                    @endphp

                @endfor
            </table>
        @endfor
        @if((isset($totalPrice)? $totalPrice : 0) != 0 && $total_name != null)
        <h2>{{ $total_name . ':' . $totalPrice }} </h2>
        @endif
    </div>
</body>

</html>
