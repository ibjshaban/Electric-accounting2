@extends('admin.index')
@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">
                <div class="">
			<span>
			{{ !empty($title)?$title:'' }}
			</span>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only"></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a href="{{ aurl('salary') }}" style="color:#343a40" class="dropdown-item">
                            <i class="fas fa-list"></i> {{ trans('admin.show_all') }}</a>
                    </div>
                </div>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>اسم الموظف</th>
                        <th>المبلغ الكلي</th>
                        <th>الديون</th>
                        <th>الخصم</th>
                        <th style="width: 40px">صافي الراتب</th>
                        <th>الملاحظات (اختياري)</th>
                        <th>تاريخ الدفع <br> <input type="date" name="date" class="form-group" onchange="changeAllPaidDate(this)"></th>
                        <th>العملية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $em)
                    <tr id="employee-{{$em->id}}" class="employee" data-id="{{$em->id}}">
                        <td>{{$em->id}}</td>
                        <td>{{$em->name}}</td>
                        <td id="employee-{{$em->id}}-all-salary">{{$em->salary}}</td>
                        <td id="employee-{{$em->id}}-debt">{{$em->debt()}}</td>
                        <td>
                            <input oninput="SalaryCheck({{$em->id}})" id="employee-{{$em->id}}-discount" type="number" name="discount" class="form-group" placeholder="الخصم">
                        </td>
                        <td>
                            <span id="employee-{{$em->id}}-salary" class="badge bg-success" style="font-size: 20px";>
                                {{$em->salary}}
                            </span>
                        </td>
                        <td>
                            <input id="employee-{{$em->id}}-note" name="note" type="text" class="form-group" placeholder="الملاحظات">
                        </td>
                        <td>
                            <input type="date" name="date" class="form-group" id="employee-{{$em->id}}-paid-date">
                        </td>
                        <td>
                            <button type="button" name="submit" class="btn btn-info" onclick="deposit({{$em->id}})">سحب</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a href="{{aurl("/revenue-salary/".request()->route('id'))}}" class="btn btn-primary btn-flat"><i
                    class="fas fa-arrow-alt-circle-right"></i>الذهاب للجدول</a>
            <button type="button" onclick="depositAll()" name="add_back" class="btn btn-success btn-flat"><i
                    class="fa fa-plus"></i> السحب للكل</button>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('/assets/plugins/toastr/toastr.min.js')}}"></script>
    <script>
        $(document).ready( function() {
            var now = new Date();
            var today = new Date(now.getFullYear(), now.getMonth()+1, 1);
            today.setDate(0);
            $('input[type="date"]').val(moment(today).format('YYYY-MM-DD'));
        });
        function changeAllPaidDate(e){
            $('input[type="date"]').val($(e).val());
        }
        function SalaryCheck(id){
            event.preventDefault();
            $('.employee-'+id+'-discounterror').remove()
            const discount= parseFloat($('#employee-'+id+'-discount').val());
            const allSalary= parseFloat($('#employee-'+id+'-all-salary').text());
            const debt= parseFloat($('#employee-'+id+'-debt').text());
            if (discount > 0 && allSalary > 0){
                if (debt > 0){
                    if (discount <= allSalary && discount <= debt){
                        $('#employee-'+id+'-salary').text((allSalary - discount).toFixed(2))
                    }
                    else {
                        $('#employee-'+id+'-discount').after('<p class="text-sm text-danger employee-'+id+'-discounterror">قيمة الخصم يجب أن تكون أقل أو يساوي الراتب و الديون</p>');
                        $('#employee-'+id+'-salary').text(0)
                    }
                }
                else {
                    $('#employee-'+id+'-discount').after('<p class="text-sm text-danger employee-'+id+'-discounterror" >لا يوجد ديون حتى يتم الخصم</p>');
                }
            }
            else {
                $('#employee-'+id+'-salary').text(allSalary)
            }
        }
        function deposit(id){
            event.preventDefault();
            $('.employee-'+id+'-paiddateerror').remove()
            var discount= parseFloat($('#employee-'+id+'-discount').val());
            const allSalary= parseFloat($('#employee-'+id+'-all-salary').text());
            const debt= parseFloat($('#employee-'+id+'-debt').text());
            const note= $('#employee-'+id+'-note').val();
            const paid_date= $('#employee-'+id+'-paid-date').val();
            var status= true;
            if (debt > 0 && discount > 0){
                if (!(discount <= allSalary && discount <= debt)){
                    status= false;
                }
            }
            if (paid_date && status){
                var data= {"revenue_id" : {{request()->route('id')}},"id": id,"discount": discount, "note" : note, "paid_date": paid_date, "_token": "{{csrf_token()}}"};
                $.post( "{{route("deposit_salary")}}", data)
                    .done(function(response) {
                        $('#employee-'+id).remove();
                        toastr.success(response);

                    })
                    .fail(function(error) {
                        toastr.error('حدث خطأ في حفظ الراتب, يرجى مراجعة المدخلات')
                    })
            }
            else {
                $('#employee-'+id+'-paid-date').after('<p class="text-sm text-danger employee-'+id+'-paiddateerror">يرجي ادخال تاريخ الدفعة</p>');
            }


        }
        function depositAll(){
            Swal.fire({
                title: 'هل أنت متأكد ؟',
                text: "تريد سحب الراتب لكل الموظفين دفعة واحدة",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم, اسحب الآن',
                cancelButtonText: 'إالغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = $('.employee').map(function() {
                        return $(this).data('id');
                    }).get();
                    data.forEach(id => deposit(id));
                }
            })
        }
    </script>
@endpush
