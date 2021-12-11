@extends('admin.index')
@section('content')


    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">
                <div class="">
                    <span>{{!empty($title)?$title:''}}</span>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only"></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a href="{{aurl('salary')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                        <a href="{{aurl('salary/'.$salary->id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('salary/create')}}">
                            <i class="fa fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$salary->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$salary->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$salary->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['salary.destroy', $salary->id]
                                ]) !!}
                                {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
                                <a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endpush
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            {!! Form::open(['url'=>aurl('/salary/'.$salary->id),'method'=>'put','id'=>'salary','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            {{--<div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('total_amount',trans('admin.total_amount'),['class'=>' control-label']) !!}
                        {!! Form::number('total_amount',$salary->total_amount,['class'=>'form-control','placeholder'=>trans('admin.total_amount')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('salary',trans('admin.salary'),['class'=>' control-label']) !!}
                        {!! Form::number('salary',$salary->salary,['class'=>'form-control','placeholder'=>trans('admin.salary')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('discount',trans('admin.discount'),['class'=>' control-label']) !!}
                        {!! Form::number('discount',$salary->discount,['class'=>'form-control','placeholder'=>trans('admin.discount')]) !!}
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('note',trans('admin.note'),['class'=>'control-label']) !!}
                        {!! Form::text('note', $salary->note ,['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
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
                            {!! Form::text('payment_date', $salary->payment_date ,['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.payment_date'),'readonly'=>'readonly']) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('employee_id',trans('admin.employee_id'),['class'=>'control-label']) !!}
                        {!! Form::select('employee_id',App\Models\Employee::pluck('name','id'), $salary->employee_id ,['class'=>'form-control select2','placeholder'=>trans('admin.employee_id')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('revenue_id',trans('admin.revenue_id'),['class'=>'control-label']) !!}
                        {!! Form::select('revenue_id',App\Models\revenue::pluck('name','id'), $salary->revenue_id ,['class'=>'form-control select2','placeholder'=>trans('admin.revenue_id')]) !!}
                    </div>
                </div>

            </div>--}}

            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>اسم الموظف</th>
                        <th>الراتب الاساسي</th>
                        <th>مجموع الديون</th>
                        <th>الخصم</th>
                        <th style="width: 40px">صافي الراتب</th>
                        <th>الملاحظات</th>
                        <th>تاريخ الدفع</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Update software</td>
                        <td>Update software</td>
                        <td>Update software</td>
                        <td>
                            <input type="number" name="discount" class="form-group" placeholder="الخصم">
                        </td>
                        <td><span class="badge bg-success" style="font-size: 20px";>55</span></td>
                        <td>Update software</td>
                        <td>Update software</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" name="save" class="btn btn-primary btn-flat"><i
                    class="fa fa-save"></i> {{ trans('admin.save') }}</button>
            <button type="submit" name="save_back" class="btn btn-success btn-flat"><i
                    class="fa fa-save"></i> {{ trans('admin.save_back') }}</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
