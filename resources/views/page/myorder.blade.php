@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>My Order</h2>
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
                <div class="modal-body">
                  <div id="name" style="color:black; min-height:30px; width:80px; float:left;"></div>
                  <div id="qty" style="color:black; min-height:30px; width:80px; margin-left:80px; float:left;"></div>
                  <div id="price" style="color:black; min-height:30px; width:150px; margin-left:240px;"></div>
                  <table id="ProductDetail" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
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
      url: "{{ URL::to('/dataorderproduct') }}",
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

function edit(id)
{
  window.location = "{{ URL::to('/edit/order') . '/' }}" + id;
}

function receive (id)
{
  $.ajax({
    url: '{{URL("/receive")}}',
    type: 'POST',
    data: {id: id},
    beforeSend: function(request){
      return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
      },
  })
  .success(function(data)
  {
    $("#"+id+"sending").prop("disabled", true);
    $("#"+id+"sending").text("Received");
    $("#"+id+"sending").css("background-color", "red");
    location.reload();
  })
  .fail(function(){
    alert('error');
  })
}

$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        ajax: {
            url: '{!! route('orderlistCustomer.data') !!}',
        },
        dom: 'Bfrtip',
        columns: [
            { data: 'order_id', name: 'order_id', title:'Order Id'},
            { data: 'order_date', name: 'order_date', title:'Order Date', sType: 'date' },
            { data: 'agent', name: 'agent', title:'Agent' },
            { data: 'shipping_date', name: 'shipping_date', title:'Shipping Date' },
            // { data: 'varian_name', name: 'varian_name', title:'Varian_name' },
            { data: 'shipping_fee', name: 'shipping_fee', title:'Shipping Fee' },
            { data: 'total', name: 'total', title:'Total' },
            { data: 'status_payment', name: 'status_payment', title:'Payment Status' },
            { data: 'status_shipping', name: 'status_shipping', title:'Shipping Confirmation' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Action', render: function(data, type, row) {
              //BUAT DAPETIN HARI MINGGU
              var today = new Date();
              var dayOfWeekStartingSundayZeroIndexBased = today.getDay(); // 0 : Sunday ,1 : Monday,2,3,4,5,6 : Saturday
              var sunday = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+7);

              var ship = new Date(row.shipping_date);
              ship.setHours(0,0,0,0);
              sunday.setHours(0,0,0,0);

              if(ship > sunday)
              {
                return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +
                '<button class="btn btn-warning" id="'+ row.order_id +'sending" onclick="receive(' + row.order_id + ')" >' + 'Receive' + '</button>' + '<br><br>' +
                '<button class="btn btn-primary" id="'+ row.order_id +'sending" onclick="edit(' + row.order_id + ')" >' + 'Edit' + '</button>';
              }
              else
              {
                return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +
                '<button class="btn btn-warning" id="'+ row.order_id +'sending" onclick="receive(' + row.order_id + ')" >' + 'Receive' + '</button>';
              }
            }
          },         
            
        ],
    });
});

 // '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>'

</script>
@endpush
@stop