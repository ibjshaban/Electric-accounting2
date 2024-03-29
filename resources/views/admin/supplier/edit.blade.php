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
                        <a href="{{aurl('supplier')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                        <a href="{{aurl('supplier/'.$supplier->id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('supplier/create')}}">
                            <i class="fa fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$supplier->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$supplier->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$supplier->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['supplier.destroy', $supplier->id]
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

            <form action="{{aurl('/supplier/'.$supplier->id)}}" class="form-horizontal form-row-seperated" method="post"
                  enctype="multipart/form-data" id="supplier">
                <div class="row"><input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="put">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="name" class="control-label">{{trans('admin.name')}}</label>
                            <input type="text" id="name" name="name" value="{{ $supplier->name }}" class="form-control"
                                   placeholder="{{trans('admin.name')}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="phone" class="control-label">{{trans('admin.phone')}} (اختياري)</label>
                            <input type="text" id="phone" name="phone" value="{{ $supplier->phone }}"
                                   class="form-control" placeholder="{{trans('admin.phone')}}"/>
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
                                @include("admin.show_image",["image"=>$supplier->photo_profile])
                            </div>
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
            </form>
        </div>
    </div>
@endsection
