@extends('admin.index')
@push('css')
<style>
    td{
        border-left: 1px solid gray;
    }
    table{
        position: relative;
    }
    thead.own{
        position: sticky;
        top: 0;
        background-color: #6d9cbe;
        width: 100%;
        border-bottom: 1px solid gray;
    }
    tr:nth-child(even):not(.own tr){
        background-color: #b0b8b9;
    }
    tr:hover{
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
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            {{--<table class="table table-head-fixed text-nowrap">--}}
                            <table class="table text-nowrap">

                                <thead class="own">
                                <tr class="">
                                    <th colspan="3"></th>
                                    <th colspan="1">له</th>
                                    <th colspan="4">عليه</th>
                                </tr>
                                <tr class="">

                                    <th>رقم الحركة</th>
                                    <th>تاريخ الحركة</th>
                                    <th>البيان</th>
                                    <th>الرواتب</th>
                                    <th>الديون</th>
                                    <th>الرصيد النهائي</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>183</td>
                                    <td>John Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-success">Approved</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>219</td>
                                    <td>Alexander Pierce</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-warning">Pending</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>657</td>
                                    <td>Bob Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-primary">Approved</span></td>
                                    <td>Bacon .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>175</td>
                                    <td>Mike Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>134</td>
                                    <td>Jim Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-success">Approved</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>494</td>
                                    <td>Victoria Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-warning">Pending</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>832</td>
                                    <td>Michael Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-primary">Approved</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>

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
