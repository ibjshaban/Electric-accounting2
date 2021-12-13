@extends('admin.index')
@push('css')
<style>
    td, th{
        border-left: 1px solid gray;
    }
</style>
@endpush
@section('content')
    <h1>الحركات المالية</h1>
    <div class="card ">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Fixed Header Table</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                           placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">له</th>
                                    <th colspan="2">عليه</th>
                                </tr>
                                <thead>

                                <tr>

                                    <th>رقم الحركة</th>
                                    <th>تاريخ الحركة</th>
                                    <th>البيان</th>
                                    <th>المبلغ</th>
                                    <th>النوع</th>
                                    <th>المبلغ</th>
                                    <th>النوع</th>
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
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>219</td>
                                    <td>Alexander Pierce</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-warning">Pending</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>657</td>
                                    <td>Bob Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-primary">Approved</span></td>
                                    <td>Bacon .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>175</td>
                                    <td>Mike Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>134</td>
                                    <td>Jim Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-success">Approved</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>494</td>
                                    <td>Victoria Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-warning">Pending</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>832</td>
                                    <td>Michael Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-primary">Approved</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
                                </tr>
                                <tr>
                                    <td>982</td>
                                    <td>Rocky Doe</td>
                                    <td>11-7-2014</td>
                                    <td><span class="tag tag-danger">Denied</span></td>
                                    <td>Bacon ipsum .</td>
                                    <td>24</td>
                                    <td>Bacon ipsum .</td>
                                    <td>Bacon ipsum .</td>
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
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
    </div>
@endsection
