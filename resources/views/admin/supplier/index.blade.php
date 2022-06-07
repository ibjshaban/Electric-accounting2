@extends('admin.index')
@section('content')
     <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">{{!empty($title)?$title:''}}
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only"></span>
                </a>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" style="color:#343a40" id="click" onclick="redirect()">
                        <i class="fas fa-plus"></i> {{trans('admin.create')}}
                    </a>

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
                @foreach($suppliers as $supplier)


                        <div class="btn-group col-md-2">
                            <a style="all: unset" href="{{aurl('/supplier/'.$supplier->id)}}">
                            <button type="button" class="btn btn-{{  ($supplier->deleted_at !='') ? 'danger': 'info' }}">
                                <i class="fa fa-user pr-4"></i>
                                {{ $supplier->name }}
                            </button>
                            </a>
                            <button type="button"
                                    class="btn btn-{{  ($supplier->deleted_at !='') ? 'danger': 'info' }} dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a href="{{ aurl('/supplier/'.$supplier->id.'/edit')}}" class="dropdown-item"><i
                                        class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('/supplier/'.$supplier->id)}}" class="dropdown-item"><i
                                        class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                                <div class="dropdown-divider"></div>
                                <a data-toggle="modal" data-target="#deleteRecord{{$supplier->id}}" class="dropdown-item"
                                   style="color:#343a40" href="#">
                                    <i class="fas fa-trash"></i> {{trans('admin.delete')}}
                                </a>
                            </div>
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
                                            <a class="btn btn-default" data-dismiss="modal">
                                                {{trans('admin.cancel')}}
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                @endforeach
                {{--<div class="table-responsive">
                {!! $dataTable->table(["class"=> "table table-striped table-bordered table-hover table-checkable dataTable no-footer"],true) !!}
                </div>--}}
            </div>
            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
    </div>

    @push('js')
        {{--
        {!! $dataTable->scripts() !!}
        --}}

        <script>
            function redirect(){
                location.replace(window.location.href+'/create');
            }
        </script>
    @endpush
@endsection
