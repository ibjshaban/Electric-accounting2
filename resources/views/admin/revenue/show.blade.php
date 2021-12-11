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
                        <a href="{{aurl('revenue')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('revenue/'.$revenue->id.'/edit')}}">
                            <i class="fas fa-edit"></i> {{trans('admin.edit')}}
                        </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('revenue/create')}}">
                            <i class="fas fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$revenue->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fas fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$revenue->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$revenue->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                       'method' => 'DELETE',
                       'route' => ['revenue.destroy', $revenue->id]
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
                <div class="rightSide col-md-6" style="border-left: 1px solid gray !important;">

                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">المبلغ المطلوب</span>
                                <span class="info-box-number">90,410</span>


                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-gradient-warning">
                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">المبلغ الذي تم تحصيله</span>
                                <span class="info-box-number">90,410</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 20%"></div>
                                </div>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
                <div class="leftSide col-md-6">

                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-fill-drip"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">السولار</span>
                                <span class="info-box-number">90,410</span>


                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-bill-wave"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الرواتب</span>
                                <span class="info-box-number">90,410</span>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>1</h3>
                                <p>الرواتب</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money-bill-wave"></i>
                            </div>
                            <a href="{{ aurl('revenue-salary/'.$revenue->id) }}" class="small-box-footer">الرواتب <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>1</h3>
                                <p>مصاريف تشغيلية</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money-bill-alt"></i>
                            </div>
                            <a href="{{ aurl('revenue-expenses/'.$revenue->id) }}" class="small-box-footer">مصاريف
                                تشغيلية <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>1</h3>
                                <p>مصاريف اخرى</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money-bill-alt"></i>
                            </div>
                            <a href="{{ aurl('revenue-otheroperation/'.$revenue->id) }}" class="small-box-footer">مصاريف
                                اخرى <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
        </div>
@endsection
