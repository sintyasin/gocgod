@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>My Order</h2>
        <div class="row">
          <center>
          <div class="col-lg-12">
            
            <form class="form-horizontal" role="form" method="POST" action= {{ URL('post/edit/order') }} >
            {!! csrf_field() !!}
            <input type="hidden" name="id" value={{$query->order_id}} />
            
            <div class="form-group">
                <label class="col-md-1 control-label">Order Id</label>

                <div class="col-md-5">
                    <input disabled type="text" class="form-control" value="{{$query->order_id}}" placeholder="{{$query->order_id}}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-1 control-label">Total Price</label>

                <div class="col-md-5">
                    <input disabled type="text" class="form-control" value="Rp {{number_format($total_price->price, 2, ',', '.')}}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-1 control-label">Total Quantity</label>

                <div class="col-md-5">
                    <input disabled type="text" class="form-control" value="{{$total_quantity}}" placeholder="{{$total_quantity}}">
                </div>
            </div>


            <div class="form-group{{ $errors->has('ship') ? ' has-error' : '' }}">">
                <label class="col-md-1 control-label">Shipping Date</label>

                <div class="col-md-5">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name='ship' class="form-control" id="datepicker" value={{$query->shipping_date}} />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                    @if ($errors->has('ship'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ship') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <?php $i = 0?>
            <div class="col-lg-12">
              <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($product_all as $product)
                    <tr>
                        <td>{{$product->varian_name}}</td>
                        <td>Rp {{number_format($product->price, 2, ',','.')}}</td>
                        <td>
                        @foreach($name_product as $quantity)
                            @if($product->varian_id == $quantity->varian_id)
                            <input type="number" min="0" maxlength="2" id="" value="{{$quantity->qty}}" style="width:60px; color:black; text-align: center;">
                            @else
                            <input type="number" min="0" maxlength="2" id="" value="0" style="width:60px; color:black; text-align: center;">
                            @endif
                        @endforeach
                        </td>
                    </tr>
                  <?php $i++?>
                  @endforeach
                  </tbody>
            </table>
          </div>

            <!-- <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                <label class="col-md-1 control-label">Answer</label>

                <div class="col-md-5">
                    <textarea rows="5" class="form-control" placeholder="Answer" name="answer" >{{ $query->answer }}</textarea>

                    @if ($errors->has('answer'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer') }}</strong>
                    </span>
                    @endif
                </div>
            </div> -->

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button> 
                    &nbsp; &nbsp;
                    <a href="{{ URL::to('myorder') }}" class="btn btn-default">Cancel</a>                              
                </div>
            </div>
            
          </form>
          
          </div>
          </center>
        
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
$(function() {
    var date = $('#datepicker').datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: '<?php echo $monday; ?>',
        maxDate: '<?php echo $sunday; ?>'
    }).val();

    $( "#datepicker" ).datepicker();
});


</script>
@endpush
@stop