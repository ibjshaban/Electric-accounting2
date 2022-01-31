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
                        <a href="{{aurl('basicparents')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                        <a href="{{aurl('basicparents/'.$basicparents->id)}}" class="dropdown-item"
                           style="color:#343a40">
                            <i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('basicparents/create')}}">
                            <i class="fa fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$basicparents->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$basicparents->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$basicparents->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['basicparents.destroy', $basicparents->id]
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
            @if (\Request::is('admin/startup/*'))
                {!! Form::open(['url'=>aurl('/startup/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/heavy-expenses/*'))
                {!! Form::open(['url'=>aurl('/heavy-expenses/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/rentals/*'))
                {!! Form::open(['url'=>aurl('/rentals/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @elseif(\Request::is('admin/other-notebooks/*'))
                {!! Form::open(['url'=>aurl('/other-notebooks/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
           @elseif(\Request::is('admin/withdrawals/*'))
                {!! Form::open(['url'=>aurl('/withdrawals/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
           @elseif(\Request::is('admin/payments/*'))
                {!! Form::open(['url'=>aurl('/payments/update/'.$basicparents->id),'method'=>'put','id'=>'basicparents','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            @endif
            <div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.name'),['class'=>'control-label']) !!}
                        {!! Form::text('name', $basicparents->name ,['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('description',trans('admin.description'),['class'=>'control-label']) !!}
                        {!! Form::text('description', $basicparents->description ,['class'=>'form-control','placeholder'=>trans('admin.description')]) !!}
                    </div>
                </div>
               {{-- <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('startup',trans('admin.startup'),['class'=>'control-label']) !!}
                        {!! Form::select('startup',['0'=>trans('admin.0'),], $basicparents->startup ,['class'=>'form-control select2','placeholder'=>trans('admin.startup')]) !!}
                    </div>
                </div>--}}

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
