@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Pesananku</h2>
        <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Pesanan berhasil diubah!</strong>
            </div>
        @endif
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
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="modalreview" tabindex="-1" role="dialog" aira-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <center>Ulasan Agen</center>
                  </div>

                  <div class="modal-body">
                  <center>
                    <form method="POST">
                    <input type="hidden" name="id" id="id" />
                    <input type="hidden" name="agent_id" id="agent_id" />

                    <div id="rateYo"></div>
                    <br>

                    <textarea class="form-control" id="review" placeholder="masukkan kritik, saran dan masukan disini"></textarea>
                    <br>
                    <br>
                    <a>
                    <button type="button" onclick="reviewandreceive()" class="boaBtn_boa_pf">
                      Submit
                    </button>
                    </a>
                    </form>
                  </center>
                  </div>
              </div>
          </div>
          </div>


          </div>

    </div>
</div>

@push('scripts')
<script>

$(function () { 
  $("#rateYo").rateYo({
    rating: 0,
    fullStar: true
  });
});

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


$('#datatableUser tbody').on( 'click', '.review', function () {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/dataorder') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var obj = JSON.parse(data);
          var id = "";
          var agent_id = "";

          id = (obj.order_id);
          agent_id = (obj.agent_id);

          $(".modal-body #id").val(id);  
          $(".modal-body #agent_id").val(agent_id);
        }
      }
    });
  
    $("#modalreview").modal();
});


$('#productDetail').on('hidden.bs.modal', function (e) {
  $(".modal-body #name").html("");
  $(".modal-body #qty").html("");
  $(".modal-body #price").html("");
})

$('#modalreview').on('hidden.bs.modal', function (e) {
  $(".modal-body #id").val("");
  $(".modal-body #agent_id").val("");
})

function reviewandreceive()
{
  var $rateYo = $("#rateYo").rateYo();
  var rating = $rateYo.rateYo("rating");
  var id = $('#id').val();
  var agent_id = $('#agent_id').val();
  if($('#review').val() != null)
  {
    var review = $('#review').val();
  }
  else
  {
    var review = ""; 
  }

  alert(rating+"-"+id+"-"+agent_id+"-"+review);


  $.ajax({
    url: '{{URL("/receive")}}',
    type: 'POST',
    data: {id: id, agent_id:agent_id, rating: rating, review:review},
    beforeSend: function(request){
      return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
      },
  })
  .success(function(data)
  {
    location.reload();
  })
  .fail(function(){
    alert('error');
  })
}

function edit(id)
{
  window.location = "{{ URL::to('/edit/order') . '/' }}" + id;
}

// function receive (id)
// {
//   $.ajax({
//     url: '{{URL("/receive")}}',
//     type: 'POST',
//     data: {id: id},
//     beforeSend: function(request){
//       return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
//       },
//   })
//   .success(function(data)
//   {
//     $("#"+id+"sending").prop("disabled", true);
//     $("#"+id+"sending").text("Received");
//     $("#"+id+"sending").css("background-color", "red");
//     location.reload();
//   })
//   .fail(function(){
//     alert('error');
//   })
// }

$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        order : [[0,'desc']],
        ajax: {
            url: '{!! route('orderlistCustomer.data') !!}',
        },
        dom: 'Bfrtip',
        columns: [
            { data: 'order_id', name: 'order_id', title:'Id Pesanan'},
            { data: 'order_date', name: 'order_date', title:'Tanggal Pemesanan', sType: 'date' },
            { data: 'agent', name: 'agent', title:'Agen' },
            { data: 'shipping_date', name: 'shipping_date', title:'Tanggal Pengiriman' },
            // { data: 'varian_name', name: 'varian_name', title:'Varian_name' },
            { data: 'shipping_fee', name: 'shipping_fee', title:'Ongkos Kirim' },
            { data: 'total', name: 'total', title:'Total' },
            { data: 'status_payment', name: 'status_payment', title:'Status Pembayaran' },
            { data: 'status_shipping', name: 'status_shipping', title:'Konfirmasi Pengiriman' },
            { data: 'ship_address', name: 'ship_address', title:'Alamat Pengiriman' },
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
                return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Rincian</button>' + '<br><br>' + 
                '@if(Auth::user()->status_user == 1)<button data-toggle="modal" class="btn btn-warning review" data-id="'+ row.order_id +'" data-agent="'+  row.agent_id +'">' + 'Diterima' + '</button>' + '<br><br> @endif' +
                '<button class="btn btn-primary" id="'+ row.order_id +'sending" onclick="edit(' + row.order_id + ')" >' + 'Ubah Order' + '</button>';
              }
              else
              {
                return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Rincian</button>' + '<br><br>' +
                '<button class="btn btn-warning" id="'+ row.order_id +'sending" onclick="receive(' + row.order_id + ')" >' + 'Diterima' + '</button>';
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