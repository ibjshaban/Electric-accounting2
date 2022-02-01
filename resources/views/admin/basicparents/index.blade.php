@extends('admin.index')
@section('content')
{{--
    {!! Form::open(["method" => "post","url" => [aurl('/basicparents/multi_delete')]]) !!}
--}}
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
                @foreach($basicparents as $basicparent)
                    <div class="btn-group col-md-2">
                        <button type="button" class="btn btn-{{  ($basicparent->deleted_at !='') ? 'danger': 'info' }}">
                            <i
                                class="fa fa-user pr-4"></i>{{ $basicparent->name }}</button>
                        <button type="button"
                                class="btn btn-{{  ($basicparent->deleted_at !='') ? 'danger': 'info' }} dropdown-toggle dropdown-icon"
                                data-toggle="dropdown" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            @if (\Request::is('admin/startup'))
                                <a href="{{ aurl('/startup/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('startup-items/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة خاصية</a>
                            @elseif(\Request::is('admin/heavy-expenses'))
                                <a href="{{ aurl('/heavy-expenses/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('startup-items/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة خاصية</a>
                            @elseif(\Request::is('admin/rentals'))
                                <a href="{{ aurl('/rentals/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('startup-items/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة خاصية</a>
                            @elseif(\Request::is('admin/other-notebooks'))
                                <a href="{{ aurl('/other-notebooks/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('startup-items/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة خاصية</a>
                            @elseif(\Request::is('admin/withdrawals'))
                                <a href="{{ aurl('/withdrawals/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('/basicparents/withdrawals/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة عنصر بالدفتر</a>
                            @elseif(\Request::is('admin/payments'))
                                <a href="{{ aurl('/payments/'.$basicparent->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                <a href="{{ aurl('/basicparents/payments/'.$basicparent->id.'/create')}}" class="dropdown-item" ><i class="fas fa-plus"></i> إضافة عنصر بالدفتر</a>
                            @endif

                            @if(\Request::is('admin/withdrawals'))
                                <a href="{{ aurl('/withdrawals/'.$basicparent->id.'/show')}}" class="dropdown-item" ><i class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                            @elseif(\Request::is('admin/payments'))
                                <a href="{{ aurl('/payments/'.$basicparent->id.'/show')}}" class="dropdown-item" ><i class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                            @else
                                <a href="{{ aurl('/basicparents/'.$basicparent->id)}}" class="dropdown-item" ><i class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a data-toggle="modal" data-target="#delete_record{{$basicparent->id}}" href="#"
                               class="dropdown-item">
                                <i class="fas fa-trash"></i> {{trans('admin.delete')}}</a>
                        </div>
                        <div class="modal fade" id="delete_record{{$basicparent->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                        <button class="close" data-dismiss="modal">x</button>
                                    </div>
                                    <div class="modal-body">
                                        <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$basicparent->id}})
                                    </div>ذ
                                    <div class="modal-footer">
                                        {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['basicparents.destroy', $basicparent->id]
                                        ]) !!}
                                        {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
                                        <a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
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
    {{--
        <div class="modal fade" id="multi_delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{trans("admin.delete")}} </h4>
                        <button class="close" data-dismiss="modal">x</button>
                    </div>
                    <div class="modal-body">
                        <div class="delete_done"><i class="fa fa-exclamation-triangle"></i> {{trans("admin.ask-delete")}}
                            <span id="count"></span> {{trans("admin.record")}} </div>
                        <div class="check_delete">{{trans("admin.check-delete")}}</div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(trans("admin.approval"), ["class" => "btn btn-danger btn-flat delete_done"]) !!}
                        <a class="btn btn-default" data-dismiss="modal">{{trans("admin.cancel")}}</a>
                    </div>
                </div>
            </div>
        </div>
    --}}

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
