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
            text-align: center;
            color: black;
        }
    </style>
</head>

<body>
    {{--  @dd($data)  --}}
    @php
        $tableRows = count($data);
        $table = (int) ($tableRows / 24);
        $count = 0;
    @endphp

    <div style="text-align: center;">
        @for ($i = 0; $i <= $table; ++$i)
            <img src="{{ asset('assets/img/motor-logo.jpeg') }}" alt="{{ __('') }}">
            <h1>{{ $title }}</h1>
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
    </div>
</body>

</html>
