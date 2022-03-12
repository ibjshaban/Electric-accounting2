@extends('admin.index')
@section('content')
    <div class="card card-dark" style="overflow-y: scroll;">
        <div class="card-header">
            <h3 class="card-title">{{!empty($title)?$title:''}}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <div>
                    مجموع الغير مراجع: <span id="unchecked_price">{{$all_uncheck}}</span>
                </div>
                <div>
                    المجموع الكلي: {{ShekelFormat($all_price)}}
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">الأيقونة</th>
                    <th scope="col">التاريخ</th>
                    <th scope="col">البيان</th>
                    <th scope="col">المبلغ</th>
                    <th scope="col">الايرادة</th>
                    <th scope="col">المنطقة</th>
                    <th scope="col">نوع العملية</th>
                    <th scope="col">منفذ العملية</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" onclick="change_status({{$log->id}})"
                                       id="selectdata{{$log->id}}" type="checkbox" {{$log->checked == '1'? 'checked' : ''}}>
                            </div>
                        </th>
                        <td>{{$log->note_name()}}</td>
                        <td>{{$log->created_at}}</td>
                        <td>{{$log->statement}}</td>
                        <td id="item_price{{$log->id}}" data-price="{{$log->amount}}">{{ShekelFormat($log->amount)}}</td>
                        <td>{{$log->revenue? $log->revenue->name : ''}}</td>
                        <td>{{$log->city? $log->city->name : ''}}</td>
                        <td>{{$log->oper_type()}}</td>
                        <td>{{$log->admin? $log->admin->name : ''}}</td>
                        <td><a href="{{aurl($log->url)}}" target="_blank">الذهاب اليه</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                <div class="text-right">
                    <div>
                        مجموع الغير مراجع: <span id="unchecked_price">{{$all_uncheck}}</span>
                    </div>
                    <div>
                        المجموع الكلي: {{ShekelFormat($all_price)}}
                    </div>
                </div>
                <div class="text-left">
                    {!! $logs->links() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
@push('js')
    <script src="{{asset('/assets/plugins/toastr/toastr.min.js')}}"></script>
    <script>
        function change_status(id){
            var status =  $("#selectdata"+id).is(':checked');

            $.post( "{{route("change_log_status")}}", {id: id, status: status, _token: "{{csrf_token()}}"})
                .done(function() {
                    $("#selectdata"+id).prop('checked', status);
                    var unchecked_price= parseFloat($('#unchecked_price').text());
                    var item_price= $('#item_price'+id).data('price');
                    var $final_price=0;
                    if (status == false){
                        $final_price= unchecked_price + item_price;
                    }
                    else {
                        $final_price= unchecked_price - item_price;
                    }
                    $('#unchecked_price').text(parseFloat($final_price).toFixed(2))
                    toastr.success('تم تغيير الحالة بنجاح')
                })
                .fail(function() {
                    $("#selectdata"+id).prop('checked', !status);
                    toastr.error('حدث خطأ في تغيير الحالة')
                })
        }
    </script>

@endpush
