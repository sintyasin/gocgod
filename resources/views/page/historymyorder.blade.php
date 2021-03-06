@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Riwayat Pesanan</h2>
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
                  <h4 class="modal-title" style="color:black;">Perincian Produk</h4>
                </div>
                <div class="modal-body" style="color:black;">
                  <div class="col-md-4 col-xs-5">
                  <div id="name"></div>
                  </div>
                  <div class="col-md-3 col-xs-2">
                  <div id="qty"></div>
                  </div>
                  <div class="col-md-4 col-xs-5">
                  <div id="price"></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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

            total += (parseInt(obj[i].price) * parseInt(obj[i].quantity));
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
        order : [[3,'desc']],
        ajax: {
            url: '{!! route('orderlistHistoryCustomer.data') !!}',
        },
        dom: 'Bfrtip',
        columns: [
            { data: 'order_id', name: 'order_id', title:'Id Pesanan'},
            { data: 'order_date', name: 'order_date', title:'Tanggal Pemesanan', sType: 'date' },
            { data: 'agent', name: 'agent', title:'Agen' },
            { data: 'shipping_date', name: 'shipping_date', title:'Tanggal Pengiriman', sType: 'date' },
            { data: 'shipping_fee', name: 'shipping_fee', title:'Ongkos Kirim' },
            { data: 'status_payment', name: 'status_payment', title:'Status Pembayaran' },
            { data: 'status_shipping', name: 'status_shipping', title:'Konfirmasi Pengiriman' },
            { data: 'ship_address', name: 'ship_address', title:'Alamat Pengiriman' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Produk', render: function(data, type, row) {
              return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>';
            } },
        ],
    });

});

</script>
@endpush
@stop