@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Customer
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Customer</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated!</strong>
    </div>
    @endif

    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/customer')  . '/' . $query->id }} >
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-1 control-label">Name</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query->name}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Email</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query->email}}" disabled />
            </div>
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Status User</label>

            <div class="col-md-5">
            	<select class='form-control' id='status' name='status' value="{{ old('status') }}">
            	   @if($query->status_user == 0)
                       <option value='0' selected>Agent</option>
                       <option value='1'>Customer</option>
                    @else($query->status_user == 1)
                       <option value='0'>Agent</option>
                       <option value='1' selected>Customer</option>
                    @endif
            	</select>
                @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('verification') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Verification</label>

            <div class="col-md-5">
                <select class='form-control' id='verification' name='verification' value="{{ old('verification') }}">
                    @if($query->verification == 1)
                       <option value='0'>Unverified</option>
                       <option value='1'selected>Verified</option>
                    @else
                        <option value='0' selected>Unverified</option>
                        <option value='1'>Verified</option>
                    @endif
                </select>
                @if ($errors->has('verification'))
                <span class="help-block">
                    <strong>{{ $errors->first('verification') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button> 
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/customer/list') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>

      <div class="col-lg-12">
        <h2>Order Transaction</h2> <br>
      </div>

      <div class="col-lg-12">
        <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
          <thead>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </div>


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


  </div><!-- /.row -->
</section><!-- /.content -->

@push('scripts')
<script>
$('#datatableUser tbody').on( 'click', '.detail', function () {
    var id = $(this).data('id');
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

function editOrder(id)
{
  window.location = "{{ URL::to('/admin/edit/customer/tx') }}" + "/" + id;
}

$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: '{!! route('customertx.data') !!}',
            data: function (d) {
                d.id = <?php echo $query->id; ?>;
            }
        },
        columns: [
            { data: 'order_id', name: 'order_id', title:'Order Id' },
            { data: 'customer', name: 'customer', title:'Customer' },
            { data: 'agent', name: 'agent', title:'Agent' },
            { data: 'order_date', name: 'order_date', title:'Order Date', sType: 'date' },
            { data: 'group_id', name: 'group_id', title:'Group Id' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            { data: 'city_name', name: 'city_name', title:'City' },            
            { data: 'who', name: 'who', title:'Type' },
            { data: 'status_payment', name: 'status_payment', title:'Payment Status' },
            { data: 'status_confirmed', name: 'status_confirmed', title:'Confirmed Status' },
            {className: "dt-center", width:"10%", name: 'actions', render: function(data, type, row) {
              return '<a class="btn btn-warning" onclick="editOrder(' + row.order_id + ')" >' + 'Edit' + '</a> <br><br>' + 
                    '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            } }
        ],
    });
});
</script>
@endpush
@stop