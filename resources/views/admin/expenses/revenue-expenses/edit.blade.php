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
                        <a href="{{aurl('revenue-expenses/'.$expenses->revenue_id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                        <a href="{{aurl('expenses/'.$expenses->id)}}" class="dropdown-item" style="color:#343a40">
                            <i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('revenue-expenses/'.$expenses->revenue_id.'/create')}}">
                            <i class="fa fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$expenses->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$expenses->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$expenses->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['expenses.destroy', $expenses->id]
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

            {!! Form::open(['url'=>aurl('/revenue-expenses/edit/'.$expenses->id),'method'=>'put','id'=>'expenses','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            <div class="row">

                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.name'),['class'=>'control-label']) !!}
                        {!! Form::text('name', $expenses->name ,['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <!-- Date range -->
                    <div class="form-group">
                        {!! Form::label('date',trans('admin.date')) !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
                            </div>
                            {!! Form::text('date', $expenses->date ,['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.date'),'readonly'=>'readonly']) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>

            </div>
            <!-- /.row -->
            <hr>

            <div class="row col-12">
                <div class="row row-cols-5 col-12 mb-5 element">
                    <div class="col">الصنف</div>
                    <div class="col">رقم الصنف</div>
                    <div class="col">الكمية</div>
                    <div class="col">سعر الوحدة</div>
                    <div class="col">سعر الكمية</div>
                    <div class="col"></div>
                </div>
                @foreach($expenses->item() as $it)
                <div class="row row-cols-5 col-12 mb-5 detail element" >
                    <div class="col">
                        <input value="{{$it->item}}" required type="text" class="form-control " name="item[]" placeholder="الصنف">
                    </div>
                    <div class="col">
                        <input value="{{$it->item_number}}" required type="text" class="form-control " name="item_number[]" placeholder="رقم الصنف">
                    </div>
                    <div class="col">
                        <input value="{{$it->amount}}" required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية" oninput="changeAllPrice(this)">
                    </div>
                    <div class="col">
                        <input value="{{$it->price}}" required type="number" step="0.001" min="0" class="form-control " name="price[]" placeholder="سعر الوحدة" oninput="changeAllPrice(this)">
                    </div>
                    <div class="col all_price" data-price="{{($it->amount*$it->price)}}">{{ShekelFormat($it->amount*$it->price)}}</div>
                    <div class="col">
                        <button type="button" name="add" class="btn btn-primary btn-flat" onclick="removeDetail(this)">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                @endforeach
                <div class="row row-cols-5 col-12 mb-5" >
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>
                    <div class="col">
                    </div>
                    <div class="col bg-success p-3" id="all_total">المجموع: {{ShekelFormat($expenses->price)}}</div>
                    <div class="col">
                    </div>
                </div>
                <div class="d-flex flex-row-reverse  mx-3">
                    <button type="button" name="add" class="btn btn-primary btn-flat" onclick="addNewDetails()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
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

@push('js')
    <script>
        function changeAllPrice(e){
            var parent= $(e).parent().parent();
            var amount=  parent.find('input[name="amount[]"]').val() ?? 0;
            var price=  parent.find('input[name="price[]"]').val() ?? 0;

            parent.find(".all_price").text('₪ '+(amount* price).toFixed(2));
            parent.find(".all_price").data('price',(amount* price).toFixed(2));

            var sum = 0;
            $('.all_price').each(function()
            {
                sum += parseFloat($(this).data('price'));
            });
            $('#all_total').text('المجموع: ₪ '+parseFloat(sum).toFixed(2))
        }
        function addNewDetails(){
            $('.element').last().after(
                '<div class="row row-cols-5 col-12 mb-5 detail element"  > '+
                '<div class="col"> <input required type="text" class="form-control " name="item[]" placeholder="الصنف">' +
                ' </div> <div class="col"> <input required type="text" class="form-control " name="item_number[]" placeholder="رقم الصنف">' +
                ' </div> <div class="col"> ' +
                '<input required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية" oninput="changeAllPrice(this)"> ' +
                '</div> <div class="col"> ' +
                '<input required type="number" step="0.001" min="0" class="form-control " name="price[]" placeholder="سعر الوحدة" oninput="changeAllPrice(this)"> ' +
                '</div> <div class="col all_price" data-price="0">0.00 ₪</div> ' +
                '<div class="col"> ' +
                '<button type="button" name="add" class="btn btn-primary btn-flat" onclick="removeDetail(this)">' +
                ' <i class="fa fa-minus"></i> </button> </div> </div>');
        }
        function removeDetail(e){
            $(e).parent().parent().remove();
        }
    </script>
@endpush
