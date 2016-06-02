@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Shipping
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Shipping</li>
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
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/ship') . '/' . $query[0]->id }} >
        {!! csrf_field() !!}

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

        <div class="form-group">
            <label class="col-md-1 control-label">Ship Address</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->ship_address}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">City</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->city_name}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Day</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->day}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Date Shipping</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query[0]->date_shipping}}" disabled />
            </div>
        </div>

        <div class="form-group{{ $errors->has('finish') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Finish</label>

            <div class="col-md-5">
                <select class="form-control" name="finish">
                    @if($query[0]->finish == 0)
                        <option value="0" selected>Not Yet</option>
                        <option value="1">Finished</option>
                    @elseif($query[0]->finish == 1)
                        <option value="0">Not Yet</option>
                        <option value="1" selected>Finished</option>
                    @endif
                </select>

                @if ($errors->has('finish'))
                <span class="help-block">
                    <strong>{{ $errors->first('finish') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="button" class="btn btn-warning" id="detail" data-id="{{ $query[0]->tx_shipping_id }}" data-toggle="modal" data-target="#sampleDetail">Order Detail</button>
                <br><br>
                <button type="submit" class="btn btn-primary">Submit</button>
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/ship') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@push('scripts')
<script>
$("#detail").click(function(){
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/product/ship') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var obj = JSON.parse(data);
          var name = "";
          var qty = "";
          var total = 0;
          for(var i=0; i<obj.length; i++)
          {
            name += (obj[i].name + "<br>") ;
            qty += ("x" + obj[i].quantity + "<br>");

            total += obj[i].quantity;
          }
          qty += ("<hr style='border-color:black;'> Total : " + total + " item");
          $(".modal-body #name").html(name);
          $(".modal-body #qty").html(qty);
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