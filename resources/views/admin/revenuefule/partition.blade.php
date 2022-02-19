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
                </div>
            </h3>
            <div class="card-tools row">
                <div class="col">كمية سولار المخزن : {{$stock_fuel_amount}}</div>
                <div class="col">
                    <div class="form-group">
                        <select name="stock" class="form-control"  onchange="changeStock(this)">
                            <option >المخزن</option>
                            @foreach($stocks as $stock)
                                <option {{$stock->id == request()->stock? 'selected' :''}}  value="{{$stock->id}}">
                                    {{$stock->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col row">
                    <div class="form-group col">
                         <input type="text" class="form-control"  placeholder="كمية الفصلة" id="partition_input">
                    </div>
                </div>
                <div class="col row">
                    <div class="form-group col">
                        <button onclick="fuel_distribution()" id="fuel_distribution_button" class="btn btn-success">افصل</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            {!! Form::open(['url'=>aurl('/revenuefule-revenue/'.$revenue_id.'/partition'),'method'=>'post','id'=>'MainForm','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            <input type="hidden" value="{{request()->stock}}" name="stock_id">
            <div class="row col-12">
                <div class="row row-cols-5 col-12 mb-5">
                    <div class="col">الايرادة</div>
                    <div class="col">الكمية</div>
                    <div class="col">ملاحظات</div>
                    <div class="col"></div>
                </div>
                @if($revenueFules)
                    @foreach($revenueFules as $fule)
                    <div class="row row-cols-5 col-12 mb-5 detail element" data-filling_date="{{$fule->filling_date}}" data-quantity="{{$fule->quantity}}" data-id="{{$fule->id}}">
                        <div class="col">
                            <div class="form-group">
                                <select name="revenue[]"  class="form-control" required>
                                    <option class="revenue_first_item" disabled>الإيرادة</option>
                                    @foreach(\App\Models\revenue::where('city_id',$city_id)->where('status',1)->orderByDesc('created_at')->get() as $revenue)
                                        <option class="revenue_item" value="{{$revenue->id}}" {{$revenue->id == $fule->revenue_id? 'selected' :''}} >{{$revenue->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <input required id="quantity{{$fule->id}}" type="number" step="0.001" min="0" class="form-control " name="amount[]" value="{{$fule->quantity}}" placeholder="الكمية (لتر)" oninput="changeAllPrice(this)">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control " value="{{$fule->note}}" name="note[]" placeholder="ملاحظات">
                        </div>
                        <div class="col">
                            <p>{{$fule->filling_name}}</p>
                        </div>
                        <div class="col">
                            <p>{{$fule->filling_date}}</p>
                        </div>
                    </div>
                 @endforeach

                <div class="d-flex flex-row-reverse  mx-3 mb-3">
                    <button type="button" class="btn btn-primary btn-flat" onclick="addNewDetails()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                @endif
            </div>
        <!-- /.card-body -->
            <div class="card-footer"><button type="submit" name="save" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> {{ trans('admin.save') }}</button>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#MainForm').on('submit', function(){
            var amount = 0;
            $('input[name="amount[]"]').each(function()
            {
                var am= $(this).val()? $(this).val(): 0
                amount += parseFloat(am);
            });
            var filling_amount= {{$revenueFules? $revenueFules->sum('quantity') : 100}};

            if (amount == filling_amount){
                return true;
            }
            else {
                alert('الكمية الكلية لا تساوي مجموع كميات التوزيع');
                return false;
            }
        });
        function changeStock(e){
            var id=$(e).val()
            if (typeof parseInt(id) == 'number'){
                window.location.href = '/admin/revenuefule-revenue/'+{{$revenue_id}}+'/partition?stock='+id
            }

        }
        function addNewDetails(){
            $('.element').last().after(
                '<div class="row row-cols-5 col-12 mb-5 detail element" >' +
                '<div class="col">' +
                '<div class="form-group">' +
                '<select name="revenue[]"  class="form-control" required>' +
                '<option class="revenue_first_item" disabled>الإيرادة</option>' +
                @foreach(\App\Models\revenue::where('city_id',$city_id)->where('status',1)->orderByDesc('created_at')->get() as $revenue)
                    '<option class="revenue_item" value="{{$revenue->id}}" >{{$revenue->name}}</option>'+
            @endforeach
        '</select>'+
        '</div>'+
                '</div>'+
            '<div class="col">'+
                '<input required type="number" step="0.001" min="0" class="form-control " name="amount[]"  placeholder="الكمية (لتر)" oninput="changeAllPrice(this)">'+
           '</div>'+
            '<div class="col">'+
                '<input type="text" class="form-control "  name="note[]" placeholder="ملاحظات">'+
            '</div>'+
            '<div class="col">'+
                '<button type="button" class="btn btn-primary btn-flat" onclick="removeDetail(this)">'+
                    '<i class="fa fa-minus"></i>'+
                '</button>'+
            '</div>'+
        '</div>'
            )
        }
        function removeDetail(e){
            $(e).parent().parent().remove();
        }
        function fuel_distribution(){
            var partition_input= parseFloat($('#partition_input').val());

            if (partition_input > 0){
                var elements = $('.element').sort(function(a,b){
                    return (
                        (new Date($(a).data("filling_date"))) <
                        (new Date($(b).data("filling_date")))) ? 1 : -1;
                });
                for (let $el of elements){
                     var el_quantity= parseFloat($($el).data('quantity'));
                    if (partition_input >= el_quantity){
                        add_new_div(el_quantity);
                        partition_input= partition_input - el_quantity;
                        $($el).remove();
                        if (partition_input == 0){
                            break;
                        }
                    }
                    else{
                        add_new_div(partition_input);
                        $($el).find('#quantity'+$($el).data('id')).val(el_quantity- partition_input);
                        $($el).data('quantity', el_quantity-partition_input);
                        break;
                    }
                }
                $('#fuel_distribution_button').prop('disabled', true);
                $('#partition_input').attr('disabled','disabled');
            }
        }

        function add_new_div($quantity){
            $('.element').last().after(
                '<div class="row row-cols-5 col-12 mb-5 detail element" >' +
                '<div class="col">' +
                '<div class="form-group">' +
                '<select name="revenue[]"  class="form-control" required>' +
                '<option class="revenue_first_item" disabled>الإيرادة</option>' +
                @foreach(\App\Models\revenue::where('city_id',$city_id)->where('status',1)->orderByDesc('created_at')->get() as $revenue)
                    '<option class="revenue_item" value="{{$revenue->id}}" >{{$revenue->name}}</option>'+
                @endforeach
                    '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col">'+
                '<input required type="number" value="'+$quantity+'" step="0.001" min="0" class="form-control " name="amount[]"  placeholder="الكمية (لتر)" oninput="changeAllPrice(this)">'+
                '</div>'+
                '<div class="col">'+
                '<input type="text" class="form-control "  name="note[]" placeholder="ملاحظات">'+
                '</div>'+
                '<div class="col">'+
                '<button type="button" class="btn btn-primary btn-flat" onclick="removeDetail(this)">'+
                '<i class="fa fa-minus"></i>'+
                '</button>'+
                '</div>'+
                '</div>'
            )
        }
    </script>
@endpush
