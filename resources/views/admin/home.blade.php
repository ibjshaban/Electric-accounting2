@extends('admin.index')
@push('css')
    <style>
        ul, #myUL {
            list-style-type: none;
        }

        #myUL {
            margin: 0;
            padding: 0;
        }

        .caret {
            cursor: pointer;
            -webkit-user-select: none; /* Safari 3.1+ */
            -moz-user-select: none; /* Firefox 2+ */
            -ms-user-select: none; /* IE 10+ */
            user-select: none;
            border-radius: 20%;
        }

        .caret::before {
            content: "\25B6";
            color: white;
            display: inline-block;
            margin-left: 6px;
            transform: rotate(175deg);
        }

        .caret-down::before {
            -ms-transform: rotate(90deg); /* IE 9 */
            -webkit-transform: rotate(90deg); /* Safari */
        ' transform: rotate(90 deg);
        }

        .nested {
            display: none;
        }

        .active {
            display: block;
        }
    </style>
@endpush
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
                                        <span class="info-box-number">{{ShekelFormat($general_revenue)}}</span>
                                    </div>
                                </a>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="col-lg-10 col-10 m-auto pb-5" style="overflow-y: scroll; height: 672px;">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="fa fa-city"></i></span>
                            <ul id="myUL">
                                <li><span class="caret">{{"المناطق - ".ShekelFormat($cities->sum("profit"))}}</span>
                                            <ul class="nested">
                                                @foreach($cities as $city)
                                                    <li><span class="caret">{{$city->name." - ".ShekelFormat($city->profit)}}</span>
                                                    <ul class="nested">
                                                        @foreach($city->revenue as $key=> $year)
                                                            <li><span class="caret">{{$key}}</span>
                                                            <ul class="nested">
                                                                @foreach($year as $revenue)
                                                                    <li>
                                                                        <a href="{{aurl("/revenue/".$revenue->id)}}" style="color: white">
                                                                            {{$revenue->name." - ".ShekelFormat($revenue->profit)}}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 m-auto pt-3">
                        <div class="info-box bg-gradient-navy">
                            <span class="info-box-icon"><i class="fas fa-object-group"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">المجموع</span>
                                <span class="info-box-number">{{ ShekelFormat($box_total) }}</span>
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
                                    <span class="info-box-number">{{ ShekelFormat($total_alls) }}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-money-check-alt"></i></span>
                            <a href="{{ aurl('debt') }}">
                                <div class="info-box-content">
                                    <span class="info-box-text">الديون</span>
                                    <span class="info-box-number">{{ShekelFormat($debts_total)}}</span>
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
                                    <span class="info-box-number">{{ShekelFormat($operating_expenses_total)}}</span>
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
                                    <span class="info-box-number">{{ShekelFormat($heavy_expenses_total)}}</span>
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
                                    <span class="info-box-number">{{ShekelFormat($rent_book_total)}}</span>
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
                                    <span class="info-box-number">{{ShekelFormat($other_book_total)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{aurl('/withdrawals')}}">
                                <div class="info-box-content">
                                    <span class="info-box-text">مسحوبات شخصية</span>
                                    <span class="info-box-number">{{ShekelFormat($withdrawals_totals)}}</span>
                                </div>
                            </a>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-lg-6 col-6 m-auto">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fa fa-book-open"></i></span>
                            <a href="{{aurl('/payments')}}">
                                <div class="info-box-content">
                                    <span class="info-box-text">دفعات التجار</span>
                                    <span class="info-box-number">{{ShekelFormat($payments_totals)}}</span>
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
                                <span class="info-box-number">{{ ShekelFormat($box_total) }}</span>
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

@push('js')
                <script>
                    var toggler = document.getElementsByClassName("caret");
                    var i;

                    for (i = 0; i < toggler.length; i++) {
                    toggler[i].addEventListener("click", function() {
                        this.parentElement.querySelector(".nested").classList.toggle("active");
                        this.classList.toggle("caret-down");
                    });
                }
            </script>
    @endpush
