@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Shipping Transaction
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Shipping Transaction</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <h4><b>Filter Shipping Transaction</b></h4>
    </div>
  </div>

  <div class="row">
    <form method="POST" id="search-form" class="form-inline" role="form">

      <div class="col-lg-3">
        <div class="col-lg-12">
          Between
        </div>

        <div class="col-lg-12" id="baseDateControl">
          <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="dateStart" id="dateStart" class="datepicker form-control" placeholder="Start Date"/>
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>

        <div class="col-lg-12">
          And
        </div>

        <div class="col-lg-12">
          <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="dateEnd" id="dateEnd" class="datepicker form-control" placeholder="End Date"/>
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>

      </div>


      <div class="col-lg-3">
        <div class="col-lg-12">
          Shipping Id
        </div>

        <div class="col-lg-5">
          <div class='form-group'>
              <input type='text' name="id" id="id" class="form-control" placeholder="Shipping Id"/>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        
        <div class="col-lg-12">
          Customer Name
        </div>

        <div class="col-lg-12">
          <div class='form-group'>
              <input type='text' name="customer" id="customer" class="form-control" placeholder="Customer"/>
          </div>
        </div>

      </div>
      <div class="col-lg-3">
        <div class="col-lg-12">
          Agent Name
        </div>

        <div class="col-lg-12">
          <div class='form-group'>
              <input type='text' name="agent" id="agent" class="form-control" placeholder="Agent"/>
          </div>
        </div>
      </div>

    <div class="col-lg-offset-5 col-lg-5">
      <br>
      <input class="btn btn-primary" type="submit" value="Submit" />
    </div>

    </form>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <br><br>
    </div>
  </div>

  <div class="row">
    @if(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Shipping Id</th>
            <th>Customer</th>
            <th>Agent</th>
            <th>Order Date</th>
            <th>Ship Address</th>
            <th>City</th>
            <th>Start Date</th>
            <th>Day</th>
            <th>Total Week</th>
            <th>Shipping Date</th>
            <th>Finish</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
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
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px;"></div>
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
<!-- untuk export datatables ke excel -->
<script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js "></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script>
$('#datatableUser tbody').on( 'click', '.detail', function () {
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

function editOrder(id)
{
  window.location = "{{ URL::to('/admin/edit/ship') }}" + "/" + id;
}
$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        ajax: {
            url: '{!! route('shiplist.data') !!}',
            data: function (d) {
                d.dateStart = $('input[name=dateStart]').val();
                d.dateEnd = $('input[name=dateEnd]').val();
                d.customer = $('input[name=customer]').val();
                d.agent = $('input[name=agent]').val();
                d.id = $('input[name=id]').val();
            }
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print',
        ],
        columns: [
            { data: 'tx_shipping_id', name: 'tx_shipping_id', title:'Shipping Id' },
            { data: 'customer', name: 'customer', title:'Customer' },
            { data: 'agent', name: 'agent', title:'Agent' },
            { data: 'order_date', name: 'order_date', title:'Order Date' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            { data: 'city_name', name: 'city_name', title:'City' },            
            { data: 'start_date', name: 'start_date', title:'Start Date' },
            { data: 'day', name: 'day', title:'Day' },
            { data: 'total_week', name: 'total_week', title:'Total Week' },
            { data: 'date_shipping', name: 'date_shipping', title:'Shipping Date' },
            { data: 'finish', name: 'finish', title:'Finish' },
            {className: "dt-center", width:"10%", name: 'actions', render: function(data, type, row) {
              return '<a class="btn btn-warning" onclick="editOrder(' + row.id + ')" >' + 'Edit' + '</a> <br><br>' + 
                    '<button type="button" class="btn btn-info detail" data-id="' + row.tx_shipping_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            } }
        ]
    });

    $('#search-form').on('submit', function(e) {
        table.draw();
        e.preventDefault();
    });
});

$(function() {
    var date = $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

    $( "#datepicker" ).datepicker();
});
</script>
@endpush
@stop