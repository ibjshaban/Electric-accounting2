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
                        <a href="{{ aurl('basicparents') }}" style="color:#343a40" class="dropdown-item">
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
            @if (\Request::is('admin/startup/create'))
                {!! Form::open(['url'=>aurl('/startup/store'),'id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/heavy-expenses/create'))
                {!! Form::open(['url'=>aurl('/heavy-expenses/store'),'id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/rentals/create'))
                {!! Form::open(['url'=>aurl('/rentals/store'),'id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/other-notebooks/create'))
                {!! Form::open(['url'=>aurl('/other-notebooks/store'),'id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @endif
           {{-- <?php
            $currentRoute = \Route::current()->uri;
            echo $currentRoute;
            ?>--}}
            <div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.name'),['class'=>' control-label']) !!}
                        {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('description',trans('admin.description'),['class'=>' control-label']) !!}
                        {!! Form::text('description',old('description'),['class'=>'form-control','placeholder'=>trans('admin.description')]) !!}
                    </div>
                </div>
                {{--<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('item',trans('admin.startup')) !!}
                        {!! Form::select('item',['0'=>trans('admin.0'),],old('startup'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
                    </div>
                </div>--}}

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
