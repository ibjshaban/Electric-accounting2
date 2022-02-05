@extends('admin.index')
@push('css')
    <style>
        td {
            border-left: 1px solid gray;
        }

        table {
            position: relative;
        }

        thead.own {
            position: sticky;
            top: 0;
            background-color: #6d9cbe;
            width: 100%;
            border-bottom: 1px solid gray;
        }

        tr:nth-child(even):not(.own tr) {
            background-color: #b0b8b9;
        }

        tr:hover {
            background-color: #82dfed;
        }
    </style>
@endpush
@section('content')
    <h1>الحركات المالية</h1>
    <!-- /.card-header -->
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">جدول الحركات المالية</h3>
                </div>
                @if(!$salaries->isEmpty())
                    <a class="btn btn-secondary buttons-pdf btn-outline col-md-2" style="color: #FFFFFF;"
                       href="{{ aurl('generate-pdf/'.$salaries[0]->employee_id) }}" type="button"><span><i
                                class="fa fa-file-pdf"> </i> تصدير الى PDF</span>
                    </a>
            @endif
            <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    {{--<table class="table table-head-fixed text-nowrap">--}}
                    <table class="table text-nowrap">

                        <thead class="own">
                        <tr class="">
                            <th colspan="2"></th>
                            <th colspan="1">له</th>
                            <th colspan="4">عليه</th>
                        </tr>
                        <tr class="">
                            <th>البيان</th>
                            <th>تاريخ الحركة</th>
                            <th></th>
                            <th></th>
                            <th>الرصيد النهائي</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            @if($item->type == 0)
                                <tr>
                                    <td>إيداع راتب @if($item->note)- ملاحظة: {{$item->note}} @endif</td>
                                    <td>{{$item->payment_date}}</td>
                                    <td><span class="tag tag-success">{{$item->discount > 0 ? ShekelFormat($item->total_amount) .' - '. ShekelFormat($item->discount) : ShekelFormat($item->total_amount)}}</span></td>
                                    <td></td>
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
                                المتبقي: {{ShekelFormat($debt_remainder)}}</td>
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
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->

@endsection
