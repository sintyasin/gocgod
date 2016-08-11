@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Agent
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Agent</li>
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
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/agent')  . '/' . $query->id }} >
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
            <div class="col-md-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button> 
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/agent/list') }}" class="btn btn-default">Cancel</a>
                <br><br>
                <button type="button" onclick="agentCoverage({{$query->id}})" class="btn btn-warning">Shipping Coverage</button>                          
            </div>
        </div>
      </form>
    </div>

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

    <!-- Modal -->
    <div id="productDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal product detail-->
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

    <!-- Modal agent shipping coverage -->
    <div id="agentDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Agent Detail</b></h4>
          </div>
          <div class="modal-body">
            <div id="name" style="min-height:30px; width:100%;"></div>
            <div id="day" style="min-height:30px; width:100%;"></div>
            <div id="ship" style="min-height:30px; width:100%;"></div>
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
function agentCoverage(id)
{
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/agent/request/detail') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var day = "<h4><b>Available day(s)</b></h4>";
          for(var i=0; i<data.day.length; i++)
          {
            switch(data.day[i]) {
              case 1:
                day += 'Senin';
                break;
              case 2:
                day += 'Selasa';
                break;
              case 3:
                day += 'Rabu';
                break;
              case 4:
                day += 'Kamis';
                break;
              case 5:
                day += 'Jumat';
                break;
              case 6:
                day += 'Sabtu';
                break;
              case 7:
                day += 'Minggu';
                break;
            } 
            //kalo bukan data terakhir kasih koma (,)
            if(i != data.day.length - 1) day += ', ';
          }

          var ship = "<br><h4><b>Shipping coverage</b></h4>";
          for(var i=0; i<data.ship.length; i++)
          {
            ship += data.ship[i]['province'] + '<br>' + data.ship[i]['city'] + '<br>' + data.ship[i]['district'];

            //kalo bukan data terakhir kasih koma (,)
            if(i != data.ship.length - 1) ship += '<br><br>';
          }

          $(".modal-body #name").html(data.name);
          $(".modal-body #day").html(day);
          $(".modal-body #ship").html(ship);
        }
      }
    });
    $("#agentDetail").modal();
}

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

            total += parseInt(obj[i].price);
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
  window.location = "{{ URL::to('/admin/edit/agent/tx') }}" + "/" + id;
}

$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: '{!! route('agenttx.data') !!}',
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
            { data: 'province_name', name: 'province_name', title:'Province' },   
            { data: 'city_name', name: 'city_name', title:'City' },
            { data: 'district_name', name: 'district_name', title:'District' },
            {className: "dt-center", width:"10%", name: 'actions', render: function(data, type, row) {
              return '<a class="btn btn-warning" onclick="editOrder(' + row.order_id + ')" >' + 'Edit' + '</a> <br><br>' + 
                    '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            } },
            { data: 'status_payment', name: 'status_payment', title:'Payment Status' },
            { data: 'status_confirmed', name: 'status_confirmed', title:'Confirmed Status' },
            { data: 'who', name: 'who', title:'Type' },
        ],
    });
});
</script>
@endpush
@stop