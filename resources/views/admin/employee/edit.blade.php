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
                        <a href="{{aurl('employee')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                        <a href="{{aurl('employee/'.$employee->id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('employee/create')}}">
                            <i class="fa fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$employee->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$employee->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$employee->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['employee.destroy', $employee->id]
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

            {!! Form::open(['url'=>aurl('/employee/'.$employee->id),'method'=>'put','id'=>'employee','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            <div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.name'),['class'=>'control-label']) !!}
                        {!! Form::text('name', $employee->name ,['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('id_number',trans('admin.id_number').' (اختياري)',['class'=>'control-label']) !!}
                        {!! Form::text('id_number', $employee->id_number ,['class'=>'form-control','placeholder'=>trans('admin.id_number')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('address',trans('admin.address').' (اختياري)',['class'=>'control-label']) !!}
                        {!! Form::text('address', $employee->address ,['class'=>'form-control','placeholder'=>trans('admin.address')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('phone',trans('admin.phone').' (اختياري)',['class'=>'control-label']) !!}
                        {!! Form::text('phone', $employee->phone ,['class'=>'form-control','placeholder'=>trans('admin.phone')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('salary',trans('admin.salary'),['class'=>'control-label']) !!}
                        {!! Form::number('salary', $employee->salary ,['class'=>'form-control','step' => '0.001','placeholder'=>trans('admin.salary')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('type_id',trans('admin.type_id'),['class'=>'control-label']) !!}
                        {!! Form::select('type_id',App\Models\EmployeeType::pluck('name','id'), $employee->type_id ,['class'=>'form-control select2','placeholder'=>trans('admin.type_id')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('city_id',trans('admin.city_id'),['class'=>'control-label']) !!}
                        {!! Form::select('city_id',App\Models\City::pluck('name','id'), $employee->city_id ,['class'=>'form-control select2','placeholder'=>trans('admin.city_id')]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="photo_profile">{{ trans('admin.photo_profile') }}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        {!! Form::file('photo_profile',['class'=>'custom-file-input','placeholder'=>trans('admin.photo_profile')]) !!}
                                        {!! Form::label('photo_profile',trans('admin.photo_profile'),['class'=>'custom-file-label']) !!}
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">{{ trans('admin.upload') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <br/>
                            @include("admin.show_image",["image"=>$employee->photo_profile])
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 mt-5 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('is_delete','تفعيل الموظف',['class'=>'control-label']) !!}
                        {!! Form::checkbox('is_delete','1', (is_null($employee->deleted_at)) ) !!}
                    </div>
                </div>
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
