@extends('admin.index')
@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">
                <div class="">
                    <a>{{!empty($title)?$title:''}}</a>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only"></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a href="{{aurl('supplier')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
                        <a class="dropdown-item" style="color:#343a40"
                           href="{{aurl('supplier/'.$supplier->id.'/edit')}}">
                            <i class="fas fa-edit"></i> {{trans('admin.edit')}}
                        </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('supplier/create')}}">
                            <i class="fas fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$supplier->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fas fa-trash"></i> {{trans('admin.delete')}}
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
                                <a class="btn btn-default" data-dismiss="modal">{{trans('admin.cancel')}}</a>
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12">
                    <b>{{trans('admin.id')}} :</b> {{$supplier->id}}
                </div>
                <div class="clearfix"></div>
                <hr/>

                @if(!empty($supplier->admin_id()->first()))
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <b>{{trans('admin.admin_id')}} :</b>
                        {{ $supplier->admin_id()->first()->name }}
                    </div>
                @endif

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.name')}} :</b>
                    {!! $supplier->name !!}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.phone')}} :</b>
                    {!! $supplier->phone !!}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>الفرق المالي بين الدفعات و التعبئات للمورد :</b>
                    @if($financial_difference > 0)
                        لك : {{ShekelFormat($financial_difference)}}
                    @else
                        له : {{ShekelFormat($financial_difference)}}
                    @endif
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6">
                    <b>{{trans('admin.photo_profile')}} :</b>
                    @include("admin.show_image",["image"=>$supplier->photo_profile])
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12">
                    <b>جدول التعبئات :</b>
                    {!! Form::open(["method" => "post","url" => [aurl('/filling/multi_delete')]]) !!}
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">{{!empty($title)?$title:''}}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    {!! $dataTable->table(["class"=> "table table-striped table-bordered table-hover table-checkable dataTable no-footer"],true) !!}
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
                    </div>
                    <div class="modal fade" id="multi_delete">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{trans("admin.delete")}} </h4>
                                    <button class="close" data-dismiss="modal">x</button>
                                </div>
                                <div class="modal-body">
                                    <div class="delete_done"><i class="fa fa-exclamation-triangle"></i> {{trans("admin.ask-delete")}} <span id="count"></span> {{trans("admin.record")}} </div>
                                    <div class="check_delete">{{trans("admin.check-delete")}}</div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit(trans("admin.approval"), ["class" => "btn btn-danger btn-flat delete_done"]) !!}
                                    <a class="btn btn-default" data-dismiss="modal">{{trans("admin.cancel")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12">
                    <b>جدول الدفعات :</b>
                    <br>
                    <a class="btn btn-info mt-3" href="{{ aurl('payment/create') }}"> إضافة</a>

                    <div class="container mt-5">
                        <table class="table table-bordered mb-5">
                            <thead>
                            <tr class="table-success">
                                <th scope="col">رقم</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">تاريخ الانشاء</th>
                                <th scope="col">العملية</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <th scope="row">{{ $loop->index+1 }}</th>
                                    <td>{{ $payment->amount }}</td>
{{--                                    <td>{{ $payment->lastname }}</td>--}}
                                    <td>{{ $payment->created_at }}</td>
                                    <td><div class="btn-group">
                                            <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i> {{ trans('admin.actions') }}</button>
                                            <span class="caret"></span>
                                            <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a href="{{ aurl('/payment/'.$payment->id.'/edit')}}" class="dropdown-item" ><i class="fas fa-edit"></i> {{trans('admin.edit')}}</a>
                                                <a href="{{ aurl('/payment/'.$payment->id)}}" class="dropdown-item" ><i class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                                                <div class="dropdown-divider"></div>
                                                <a data-toggle="modal" data-target="#delete_record{{$payment->id}}" href="#" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> {{trans('admin.delete')}}</a>
                                            </div>
                                        </div>
                                        </td>
                                </tr>
                                <div class="modal fade" id="delete_record{{$payment->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                                <button class="close" data-dismiss="modal">x</button>
                                            </div>
                                            <div class="modal-body">
                                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$payment->id}})
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['payment.destroy', $payment->id]
                                                ]) !!}
                                                {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
                                                <a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delete_record{{$payment->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$payment->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['supplier.destroy', $payment->id]
                                ]) !!}
                                {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
                                <a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
    </div>
    @push('js')
        {!! $dataTable->scripts() !!}
    @endpush
@endsection
