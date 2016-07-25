@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Order
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Order</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">    
    <!-- Modal -->
    <div id="productDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Product Detail</h4>
          </div>
          <div class="modal-body">
            <div id="name" style="min-height:30px; width:80px; float:left;"></div>
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px; float:left;"></div>
            <div id="price" style="min-height:30px; width:150px; margin-left:240px;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/order') . '/' . $query[0]->order_id }} >
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-1 control-label">Order ID</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->order_id}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Group ID</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->group_id}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Customer</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->cust}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Agent</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->agent}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Order Date</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->order_date}}" disabled />
            </div>
        </div>

        <div class="form-group{{ $errors->has('payment') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Payment Status</label>

            <div class="col-md-5">
                <select class="form-control" name="payment">
                    @if($query[0]->status_payment == 0)
                        <option value="0" selected>Unpaid</option>
                        <option value="1">Paid</option>
                        <option value="-1">Failed</option>
                    @elseif($query[0]->status_payment == 1)
                        <option value="0">Unpaid</option>
                        <option value="1" selected>Paid</option>
                        <option value="-1">Failed</option>
                     @elseif($query[0]->status_payment == -1)
                        <option value="0">Unpaid</option>
                        <option value="1" >Paid</option>
                        <option value="-1" selected>Failed</option>
                    @endif
                </select>

                @if ($errors->has('payment'))
                <span class="help-block">
                    <strong>{{ $errors->first('payment') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('confirmed') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Customer Confirmation</label>

            <div class="col-md-5">
                <select class="form-control" name="confirmed">
                    @if($query[0]->status_confirmed == 0)
                        <option value="0" selected>Unconfirmed</option>
                        <option value="1">Confirmed</option>
                    @elseif($query[0]->status_confirmed == 1)
                        <option value="0">Unconfirmed</option>
                        <option value="1" selected>Confirmed</option>
                    @endif
                </select>

                @if ($errors->has('confirmed'))
                <span class="help-block">
                    <strong>{{ $errors->first('confirmed') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('ship') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Shipping Confirmation</label>

            <div class="col-md-5">
                <select class="form-control" name="ship">
                    @if($query[0]->status_shipping == 0)
                        <option value="0" selected>Unconfirmed</option>
                        <option value="1">Confirmed</option>
                    @elseif($query[0]->status_shipping == 1)
                        <option value="0">Unconfirmed</option>
                        <option value="1" selected>Confirmed</option>
                    @endif
                </select>

                @if ($errors->has('ship'))
                <span class="help-block">
                    <strong>{{ $errors->first('ship') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="button" class="btn btn-warning" id="detail" data-id="{{ $query[0]->order_id }}" data-toggle="modal" data-target="#sampleDetail">Order Detail</button>
                <br><br>
                <button type="submit" class="btn btn-primary">Submit</button>
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/order') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@push('scripts')
<script>
$("#detail").click(function(){
    var id = <?php echo $query[0]->order_id; ?>;
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/product/order') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var obj = JSON.parse(data);
          var name = "";
          var qty = "";
          var price = "";
          var total = 0;
          for(var i=0; i<obj.length; i++)
          {
            name += (obj[i].name + "<br>") ;
            qty += ("x" + obj[i].quantity + "<br>") ;
            price += ("@Rp" + obj[i].price + "<br>");

            total += obj[i].price;
          }
          price += ("<hr style='border-color:black;'> Total : Rp" + total);
          $(".modal-body #name").html(name);
          $(".modal-body #qty").html(qty);
          $(".modal-body #price").html(price);
        }
      }
    });
    $("#productDetail").modal();
});

$('#productDetail').on('hidden.bs.modal', function (e) {
  $(".modal-body #name").html("");
  $(".modal-body #qty").html("");
  $(".modal-body #price").html("");
})
</script>
@endpush
@stop