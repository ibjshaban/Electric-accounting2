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
                                <span class="info-box-number">{{ShekelFormat($revenue->total_amount)}}</span>


                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-gradient-olive">
                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                            <?php $percent = $revenue->total_amount > 0 ? number_format(($total_collection * 100) / $revenue->total_amount, 1) : 0;?>
                            <a href="{{ aurl('revenue-collection/'.$revenue->id) }}" style="color: #ffffff;">
                                <div class="info-box-content">
                                    <span class="info-box-text">المبلغ الذي تم تحصيله</span>
                                    <span class="info-box-number">{{ShekelFormat($total_collection)}}</span>
                                    <span class="info-box-number">{{$percent}}%</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{$percent}}%"></div>
                                    </div>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-6 m-auto pb-5">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <?php $percent = $revenue->total_amount > 0 ? number_format(($total_other_collection * 100) / $revenue->total_amount, 1) : 0;?>
                            <a href="{{ aurl('revenue-collection/'.$revenue->id) }}" style="color: #ffffff;">
                                <div class="info-box-content">
                                    <span class="info-box-text">الجهات الاخرى</span>
                                    <span class="info-box-number">{{ShekelFormat($total_other_collection)}}</span>
                                    <span class="info-box-number">{{$percent}}%</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{$percent}}%"></div>
                                    </div>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="pt-3 border-top">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 m-auto">

                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="fas fa-sort-amount-down"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">الخسارة</span>
                                        <span
                                            class="info-box-number"> @if($net_profit < 0){{ ShekelFormat($net_profit) }} @else {{ ShekelFormat(0) }} @endif</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                    </div>
                    <div class="col-lg-6 col-md-6 m-auto pt-3">
                        <div class="info-box bg-gradient-navy">
                            <span class="info-box-icon"><i class="fas fa-object-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">المجموع</span>
                                <span class="info-box-number">@if($net_profit < 0){{ ShekelFormat($net_profit+$total_collection+$total_other_collection) }} @else {{ ShekelFormat($total_collection+$total_other_collection) }} @endif</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
                <div class="leftSide col-md-6">

                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-fill-drip"></i></span>

                            <a href="{{ aurl('revenuefule-revenue/'.$revenue->id) }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">السولار</span>
                                    <span class="info-box-number">{{ShekelFormat($total_fules)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-bill-wave"></i></span>
                            <a href="{{ aurl('revenue-salary/'.$revenue->id) }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">الرواتب</span>
                                    <span class="info-box-number">{{ShekelFormat($total_salary)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto" style="padding-bottom: 2.5%;">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-bill-alt"></i></span>
                            <a href="{{ aurl('revenue-expenses/'.$revenue->id) }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">مصاريف تشغيلية</span>
                                    <span class="info-box-number">{{ShekelFormat($total_expenses)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-bill-alt"></i></span>
                            <a href="{{ aurl('revenue-otheroperation/'.$revenue->id) }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">مصاريف أخرى</span>
                                    <span class="info-box-number">{{ShekelFormat($total_other_operation)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="pt-3 border-top">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 m-auto">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-sort-amount-up"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">الربح</span>
                                        <span
                                            class="info-box-number"> @if($net_profit > 0){{ ShekelFormat($net_profit) }} @else {{ ShekelFormat(0) }} @endif</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                    </div>
                    <div class="col-lg-6 col-md-6 m-auto pt-3">
                        <div class="info-box bg-gradient-navy">
                            <span class="info-box-icon"><i class="fas fa-object-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">المجموع</span>
                                <span class="info-box-number">@if($net_profit > 0){{ ShekelFormat($net_profit+$total_all) }} @else {{ ShekelFormat($total_all) }} @endif</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
        </div>
@endsection
