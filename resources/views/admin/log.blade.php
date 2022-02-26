@extends('admin.index')
@section('content')
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>العملية</th>
                        <th>منفذ العملية</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$log->name}}</td>
                        <td>{{$log->admin() ? $log->admin()->name : ''}}</td>
                        <td>
                            <div class="row">
                                <button class="btn btn-info m-1">
                                    <a class="text-white" href="{{route('log_details',$log->id)}}">عرض التفاصيل</a>
                                </button>
                                <a href="{{route('log_accept',$log->id)}}" class="btn btn-success m-1 text-white">قبول</a>
                                <a href="{{route('log_cancel',$log->id)}}" class="btn btn-danger m-1 text-white">رفض</a>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {!! $logs->links() !!}
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
