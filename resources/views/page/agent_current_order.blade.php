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
            url: '{!! route('customerorderlist.data') !!}',
        },
        dom: 'Bfrtip',
        order: [[ 2, "asc" ]],
        columns: [
            { data: 'order_id', name: 'order_id', title:'Id Pesanan' },
            { data: 'customer', name: 'customer', title:'Pelanggan' },
            { data: 'shipping_date', name: 'shipping_date', title:'Tanggal Pengiriman', sType: 'date' },
            { data: 'phone', name: 'phone', title:'Telepon' },
            { data: 'ship_address', name: 'ship_address', title:'Alamat Pengiriman' },
            { data: 'city_name', name: 'city_name', title:'Kota' },            
            { data: 'who', name: 'who', title:'Tipe' },
            { data: 'status_confirmed', name: 'status_confirmed', title:'Status Konfirmasi' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Action', render: function(data, type, row) {

            if(row.status_shipping == 0){

              return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +'<button class="btn btn-warning" id="'+ row.order_id +'sending" onclick="sending(' + row.order_id + ')" >' + 'Send' + '</button>';
            }
            else
            {
                return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +'<button disabled class="btn btn-warning" style="background-color:red" id="'+ row.order_id +'sending" onclick="sending(' + row.order_id + ')" >' + 'Sent' + '</button>';
            } 
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

function sending (id)
{
    $.ajax({
        url: '{{URL("/sending")}}',
        type: 'POST',
        data: {id: id},
        beforeSend: function(request){
        return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
        },
        })
        .success(function(data)
        {
            $("#"+id+"sending").prop("disabled", true);
            $("#"+id+"sending").text("Sent");
            $("#"+id+"sending").css("background-color", "red");
            table.ajax.reload();
        })
        .fail(function(){
            alert('error');
    })
}
</script>