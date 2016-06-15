@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>My Order History</h2>
        <div class="row">
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

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color:black;">Product Detail</h4>
                </div>
                <div class="modal-body" style="color:black;">
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
        </div>
    </div>
</div>

@push('scripts')
<script>
$('#datatableUser tbody').on( 'click', '.detail', function () {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/historydatamyorder') }}",
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

            total += (obj[i].price * obj[i].quantity);
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


$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        ajax: {
            url: '{!! route('orderlistHistoryCustomer.data') !!}',
        },
        dom: 'Bfrtip',
        columns: [
            { data: 'order_id', name: 'order_id', title:'Order Id'},
            { data: 'order_date', name: 'order_date', title:'Order Date', sType: 'date' },
            { data: 'agent', name: 'agent', title:'Agent' },
            { data: 'shipping_date', name: 'shipping_date', title:'Shipping Date', sType: 'date' },
            { data: 'shipping_fee', name: 'shipping_fee', title:'Shipping Fee' },
            { data: 'status_payment', name: 'status_payment', title:'Payment Status' },
            { data: 'status_shipping', name: 'status_shipping', title:'Shipping Confirmation' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Product', render: function(data, type, row) {
              return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            } },
        ],
    });

});

</script>
@endpush
@stop