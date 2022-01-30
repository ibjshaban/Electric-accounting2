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

                <div class="rightSide col-md-6" style="border-left: 1px solid gray !important;">
                    @if(admin()->user()->role("generalrevenue_show"))
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-gradient-olive">
                            <span class="info-box-icon"><i class="fa fa-box-tissue"></i></span>
                            <a href="{{aurl('generalrevenue')}}" style="color: #ffffff;">
                                <div class="info-box-content">
                                    <span class="info-box-text">{{trans('admin.generalrevenue')}}</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-6 col-6 m-auto pb-5">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="fa fa-city"></i></span>
                            <a href="#" style="color: #ffffff;">
                                <div class="info-box-content">
                                    <span class="info-box-text">المنطقة</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 m-auto pt-3">
                        <div class="info-box bg-gradient-navy">
                            <span class="info-box-icon"><i class="fas fa-object-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">المجموع</span>
                                <span class="info-box-number">{{ ShekelFormat(0) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
                <div class="leftSide col-md-6">
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-gradient-olive">
                            <span class="info-box-icon"><i class="fa fa-box-open"></i></span>
                            <a href="#" style="color: #ffffff;">
                                <div class="info-box-content">
                                    <span class="info-box-text">الصندوق</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-check-alt"></i></span>
                            <a href="{{ aurl('debt') }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">الديون</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{ aurl('startup') }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">المصاريف الاساسية</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{ aurl('heavy-expenses') }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">المصاريف الثقيلة</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{ aurl('rentals') }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">دفتر الايجارات</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{ aurl('other-notebooks') }}">

                                <div class="info-box-content">
                                    <span class="info-box-text">دفاتر أخرى</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    @if(admin()->user()->role("withdrawals_show"))
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{aurl('/withdrawals')}}">
                                <div class="info-box-content">
                                    <span class="info-box-text">مسحوبات شخصية</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    @endif
                    @if(admin()->user()->role("payments_show"))
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{aurl('/payments')}}">
                                <div class="info-box-content">
                                    <span class="info-box-text">دفعات التجار</span>
                                    <span class="info-box-number">{{ShekelFormat(0)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    @endif

                    <div class="col-lg-6 col-md-6 m-auto pt-3">
                        <div class="info-box bg-gradient-navy">
                            <span class="info-box-icon"><i class="fas fa-object-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">المجموع</span>
                                <span class="info-box-number">{{ ShekelFormat(0) }}</span>
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
