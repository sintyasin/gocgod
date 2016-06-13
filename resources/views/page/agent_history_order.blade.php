<table id="customerDatatable" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
<thead>
</thead>
<tbody>
</tbody>
</table>

<script>
var table = $('#customerDatatable').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        ajax: {
            url: '{!! route('agenthistoryorderlist.data') !!}',
        },
        dom: 'Bfrtip',
        order: [[ 2, "desc" ]],
        columns: [
            { data: 'order_id', name: 'order_id', title:'Order Id' },
            { data: 'customer', name: 'customer', title:'Customer' },
            { data: 'shipping_date', name: 'shipping_date', title:'Order Date', sType: 'date' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            { data: 'city_name', name: 'city_name', title:'City' },            
            { data: 'who', name: 'who', title:'Type' },
            { data: 'status_confirmed', name: 'status_confirmed', title:'Confirmed Status' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Action', render: function(data, type, row) {
              return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            }
        }

        ],
    });

$('#customerDatatable tbody').on( 'click', '.detail', function () {
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

</script>