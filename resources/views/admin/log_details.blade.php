@extends('admin.index')
@section('content')
    <div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5>العملية : {{$log->name}}</h5>
            <h5>منفذ العملية : {{$log->admin() ? $log->admin()->name : ''}}</h5>
            <div class="row">
                @if($info->operation == 'delete' || $info->operation == 'update')
                    <div class="col-md-6 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="">البيانات الحالية</h6>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                    @foreach($log->item() as $key=> $data)
                                        <tr>
                                            <td></td>
                                            <td>{{trans('admin.'. $key)}}</td>
                                            <td>
                                                {{$data}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                @endif
                @if($info->operation == 'store' || $info->operation == 'update')
                    <div class="col-md-6 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="">البيانات المضافة</h6>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                    @foreach($log->show_new_data() as $key=> $data)
                                        <tr>
                                            <td></td>
                                            <td>{{trans('admin.'. $key)}}</td>
                                            <td>
                                                {{$data}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-right">
                <a href="{{route('log_accept',$log->id)}}" class="btn btn-success m-1 text-white">قبول</a>
                <a href="{{route('log_cancel',$log->id)}}" class="btn btn-danger m-1 text-white">رفض</a>
            </div>
        </div>
    </div>
    </div>
@endsection
