@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Pesananku</h2>
        <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>{{ session('success') }}</strong>
            </div>
         @elseif (session('error'))
         <div class="alert alert-danger fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>{{ session('error') }}</strong>
        </div>
        @elseif(session('ok'))
        <div class="alert alert-success fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>{{ session('ok') }}</strong>
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

          <div class="modal fade" id="paid" tabindex="-1" role="dialog" aira-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <center>Konfirmasi Pembayaran</center>
                  </div>

                  <div class="modal-body">
                  <center>
                    <form role="form" method="POST" action="{{ url('confirmation_pay') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id_pay" id="id_pay" />
                    <input type="hidden" name="total" id="total" />

                    <p> <span>Nama Akun Pembayaran</span>
                    <input type="text" autocomplete="off" class="form-control" name="pay_accountname">
                    </p>

                    <p> <span>Nomor Akun</span>
                    <input type="text" class="form-control" name="pay_accountnumber" autocomplete="off" onkeypress="return isNumber(event)">
                    </p>

                    <p> <span>Total Uang</span>
                    <input type="text" autocomplete="off" class="form-control" name="pay_amount" onkeypress="return isNumber(event)">
                    </p>

                    <p> <span>Tanggal Pembayaran</span>
                    <input type="text" name="payment_date" class="form-control" id="datepicker" autocomplete="off" onkeypress="return isNumber(event)">
                    </p>
                    
                    <a>
                    <button type="submit" class="boaBtn_boa_pf">
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
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(function () { 
  $("#rateYo").rateYo({
    rating: 0,
    fullStar: true
  });
});

$(function() {
    var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd'}).val();
    $( "#datepicker" ).datepicker();
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

$('#datatableUser tbody').on( 'click', '.pay', function () {
    var id = $(this).data('id');
    var total = $(this).data('total');

    $(".modal-body #id_pay").val(id);
    $(".modal-body #total").val(total);
    
    $("#paid").modal();
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

function paid(id)
{
  $.ajax({
    url: '{{URL("/paid")}}',
    type: 'POST',
    data: {id: id},
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

$(function() {
    var table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        order : [[3,'asc']],
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

              var pay;
              if(row.confirmation_status == 0 && row.status_payment == 'Belum dibayar')
              {
                pay = '<button class="btn btn-success pay" data-toggle="modal" data-id="'+ row.group_id+'" data-total="'+row.total+'">' + 'Konfirm Bayar' + '</button> <br><br>';
              }
              else
              {
                pay = '';
              }
              var get;
              if(<?php echo Auth::user()->status_user ?> == 1 && (row.status_payment == 'Sudah dibayar' || row.confirmation_status == 1))
              {
                get = '<button data-toggle="modal" class="btn btn-warning review" data-id="'+ row.order_id +'" data-agent="'+  row.agent_id +'">' + 'Diterima' + '</button>' + '<br><br>'
              }
              else
              {
                get = '';
              }

              if(ship > sunday)
              {
               
                return '<div style="text-align:left;"><button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Rincian</button>' + '<br><br>' +
                pay +
                get +
                '<button class="btn btn-primary" id="'+ row.order_id +'sending" onclick="edit(' + row.order_id + ')" >' + 'Ubah Order' + '</button></div>';
              }
              else
              {
                return '<div style="text-align:left;"><button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Rincian</button>' + '<br><br>' +
                pay+
                get + '</div>';
              }
            }
          },         
            
        ],
    });
});
</script>
@endpush
@stop