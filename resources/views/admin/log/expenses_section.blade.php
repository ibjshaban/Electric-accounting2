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
            <div class="col-md-12 mb-2 row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>المنفذ</label>
                        <select id="admin_search" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1">
                            @foreach(\App\Models\Admin::all() as $admin)
                            <option {{request()->input('admin') == null ? 'selected' : ''}} data-id="{{null}}" value="{{null}}" >الكل</option>
                            <option {{request()->input('admin') == $admin->id ? 'selected' : ''}} data-id="{{$admin->id}}" value="{{$admin->id}}" >{{$admin->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>الايقونة</label>
                        <select id="note_search" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1">
                            @foreach(\App\Models\Admin::all() as $admin)
                            <option {{request()->input('note') == null ? 'selected' : ''}} data-id="{{null}}" value="{{null}}" >الكل</option>
                            <option {{request()->input('note') == 1 ? 'selected' : ''}} data-id="1" value="1" >دفعات الموردين</option>
                            <option {{request()->input('note') == 2 ? 'selected' : ''}} data-id="2" value="2" >الرواتب</option>
                            <option {{request()->input('note') == 3 ? 'selected' : ''}} data-id="3" value="3" >المصاريف التشغيلية</option>
                            <option {{request()->input('note') == 4 ? 'selected' : ''}} data-id="4" value="4" >المصاريف الأخرى</option>
                            <option {{request()->input('note') == 5 ? 'selected' : ''}} data-id="5" value="5" >الديون</option>
                            <option {{request()->input('note') == 6 ? 'selected' : ''}} data-id="6" value="6" >المصاريف التأسيسية</option>
                            <option {{request()->input('note') == 7 ? 'selected' : ''}} data-id="7" value="7" >المصاريف الثقيلة</option>
                            <option {{request()->input('note') == 8 ? 'selected' : ''}} data-id="8" value="8" >دفعات الأجارات</option>
                            <option {{request()->input('note') == 9 ? 'selected' : ''}} data-id="9" value="9" >دفاتر أخرى</option>
                            <option {{request()->input('note') == 10 ? 'selected' : ''}} data-id="10" value="10" >السحوبات الشخصية</option>
                            <option {{request()->input('note') == 11 ? 'selected' : ''}} data-id="11" value="11" >دفعات التجار</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>نوع العملية</label>
                        <select id="operation_search" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1">
                            <option {{request()->input('operation') == null ? 'selected' : ''}} data-id="{{null}}" value="{{null}}" >الكل</option>
                            <option {{request()->input('operation') == 'store' ? 'selected' : ''}} data-id="store" value="store" >إضافة</option>
                            <option {{request()->input('operation') == 'update' ? 'selected' : ''}} data-id="update" value="update" >تعديل</option>
                            <option {{request()->input('operation') == 'delete' ? 'selected' : ''}} data-id="delete" value="delete" >حذف</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>حالة العملية</label>
                        <select id="status_search" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1">
                            <option {{request()->input('status') == null ? 'selected' : ''}} data-id="{{null}}" value="{{null}}" >الكل</option>
                            <option {{request()->input('status') == '1' ? 'selected' : ''}} data-id="1" value="1" >المراجع</option>
                            <option {{request()->input('status') == '0' ? 'selected' : ''}} data-id="0" value="0" >الغير مراجع</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="display: none ">
                        <select class="form-control select2 select2-hidden-accessible disabled"  style="display: none !important; ;width: 100%;" data-select2-id="1">
                        </select>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
                <div class="col-md-3 text-right">
                    <button class="btn btn-secondary mx-1" onclick="resett()">إلغاء</button>
                    <button class="btn btn-success" onclick="search()">بحث</button>
                </div>
            </div>
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
                    @if(array_key_exists('last_page',$logs->toArray()))
                    {!! $logs->links() !!}
                    @endif
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
        function search(){
            var admin_search= $('#admin_search').val();
            var note_search= $('#note_search').val();
            var operation_search= $('#operation_search').val();
            var status_search= $('#status_search').val();
            var $parameter= '?';
            if (admin_search){
                $parameter+= "admin="+admin_search
            }
            if (note_search){
                if ($parameter.search("admin") != -1){
                    $parameter+= "&note="+note_search
                }
                else {
                    $parameter+= "note="+note_search
                }
            }
            if (operation_search){
                if ($parameter.search("admin") != -1 || $parameter.search("note") != -1){
                    $parameter+= "&operation="+operation_search
                }
                else {
                    $parameter+= "operation="+operation_search
                }
            }
            if (status_search){
                if ($parameter.search("admin") != -1 || $parameter.search("note") != -1 || $parameter.search("operation") != -1){
                    $parameter+= "&status="+status_search
                }
                else {
                    $parameter+= "status="+status_search
                }
            }

            window.location.href = window.location.href.split('?')[0]+$parameter;
        }
        function resett(){window.location.href= window.location.href.split('?')[0]}
    </script>

@endpush
