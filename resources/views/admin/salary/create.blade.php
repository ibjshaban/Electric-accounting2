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

            {!! Form::open(['url'=>aurl('/salary'),'id'=>'salary','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
{{--
            <div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('total_amount',trans('admin.total_amount'),['class'=>' control-label']) !!}
                        {!! Form::number('total_amount',old('total_amount'),['class'=>'form-control','placeholder'=>trans('admin.total_amount')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('salary',trans('admin.salary'),['class'=>' control-label']) !!}
                        {!! Form::number('salary',old('salary'),['class'=>'form-control','placeholder'=>trans('admin.salary')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('discount',trans('admin.discount'),['class'=>' control-label']) !!}
                        {!! Form::number('discount',old('discount'),['class'=>'form-control','placeholder'=>trans('admin.discount')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('note',trans('admin.note'),['class'=>' control-label']) !!}
                        {!! Form::text('note',old('note'),['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <!-- Date range -->
                    <div class="form-group">
                        {!! Form::label('payment_date',trans('admin.payment_date')) !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
                            </div>
                            {!! Form::text('payment_date',old('payment_date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.payment_date'),'readonly'=>'readonly']) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('employee_id',trans('admin.employee_id')) !!}
                        {!! Form::select('employee_id',App\Models\Employee::pluck('name','id'),old('employee_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('revenue_id',trans('admin.revenue_id')) !!}
                        {!! Form::select('revenue_id',App\Models\revenue::pluck('name','id'),old('revenue_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
                    </div>
                </div>

            </div>
--}}
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
                        <th>الملاحظات</th>
                        <th>تاريخ الدفع</th>
                        <th>العملية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $em)
                    <tr>
                        <td>{{$em->id}}</td>
                        <td>{{$em->name}}</td>
                        <td>{{$em->salary}}</td>
                        <td>{{ $em->debt()}}</td>
                        <td>
                            <input type="number" name="discount" class="form-group" placeholder="الخصم">
                        </td>
                        <td><span class="badge bg-success" style="font-size: 20px";>{{$em->salary}}</span></td>
                        <td>
                            <input name="note" type="text" class="form-group" placeholder="الملاحظات">
                        </td>
                        <td>
                            <input type="date" name="date" class="form-group">
                        </td>
                        <td>
                            <button type="submit" name="submit" class="btn btn-info">سحب</button>
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
            <button type="submit" name="add" class="btn btn-primary btn-flat"><i
                    class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
            <button type="submit" name="add_back" class="btn btn-success btn-flat"><i
                    class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
            {!! Form::close() !!}    </div>
    </div>
@endsection
