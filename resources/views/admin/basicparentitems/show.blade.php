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
                        <a href="{{aurl('basicparents/'.$basicparentitems->basic_id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
                        <a class="dropdown-item" style="color:#343a40"
                           href="{{aurl('basicparentitems/'.$basicparentitems->id.'/edit')}}">
                            <i class="fas fa-edit"></i> {{trans('admin.edit')}}
                        </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('startup-items/'.$basicparentitems->basic_id.'/create')}}">
                            <i class="fas fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$basicparentitems->id}}"
                           class="dropdown-item" style="color:#343a40" href="#">
                            <i class="fas fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$basicparentitems->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$basicparentitems->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                       'method' => 'DELETE',
                       'route' => ['basicparentitems.destroy', $basicparentitems->id]
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
                    <b>{{trans('admin.id')}} :</b> {{$basicparentitems->id}}
                </div>
                <div class="clearfix"></div>
                <hr/>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.name')}} :</b>
                    {!! $basicparentitems->name !!}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.price')}} :</b>
                    {!! $basicparentitems->price !!}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.discount')}} :</b>
                    {!! $basicparentitems->discount !!}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.date')}} :</b>
                    {!! $basicparentitems->date !!}
                </div>

                <!-- /.row -->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="row">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr class="element">
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الملاحظات</th>
                        <th>سعر الكمية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($basicparentitems->item() as $item)
                        <tr class="element">
                            <td> {{ $item->price }} </td>
                            <td> {{ $item->amount }} </td>
                            <td> {{ $item->note }} </td>
                            <td class="all_price">{{ShekelFormat($item->price* $item->amount)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2 p-3 bg-gradient-success float-right" id="all_total">المجموع: {{ShekelFormat($basicparentitems->price)}}</div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>

@endsection
