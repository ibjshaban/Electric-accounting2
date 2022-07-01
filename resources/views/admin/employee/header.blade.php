<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>جدول الطباعة</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
            margin-right: 30%;
            width: 300px;
        }
    </style>
</head>
<body>
<header>

</header>
<img src="{{ public_path('assets/img/motor-logo.jpeg') }}">
<h1> الحركات المالية للموظف:{{ $employee_name }}</h1>
</body>
</html>
