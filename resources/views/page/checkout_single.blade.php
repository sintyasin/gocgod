  @extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="container">
  <div class="padding_outer">
    <h2>Shopping Cart</h2>
  
    @if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/register')}} class="testimonial_custom"> Silahkan masuk terlebih dahulu atau klik link ini untuk mendaftar </a>
      </div>
    @else
    <div class="stepper">
      <div id="wrapper_progress">
        <br>
        <div class="col-md-12 col-xs-12">
          <span class='baricon'>1</span>
          <span id="bar1" class='progress_bar'></span>
          <span class='baricon'>2</span>
          <!-- <span id="bar5" class='progress_bar'></span>
          <span class='baricon'>6</span> -->
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      </div>
            
      <form class="form-horizontal" role="form" method="POST" action="{{ url('order_single') }}">
      {!! csrf_field() !!}
        <div id="wrapper_table">
          <div id="product_details">
            <p class='form_head'>Detail Order</p>
            <div class="shiping-method">
              <div id="table">
              </div>

              <p>*Gratis ongkos kirim untuk pembelian dengan total kuantitas lebih dari 5</p>
              <br>
              <p class="plxLogin"><font size="3">Total Harga</font></p>
              <p class="plxLogin"><font size="4"><b>Rp <span id="total-cart"> {{number_format(Cart::total(), 2, ',', '.')}}</span></b></font></p>                                             
            </div>
            <br>
            <div id="alert">
            </div>
             <input type="button" value="Next" onclick="check()">
          </div>
        </div>
        <div id="wrapper">
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="delivery_address">
          <Center>
            <p class='form_head'>Data Pelanggan</p>
              <label for="phone">Nama Pelanggan</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center;"/>
              <label for="address">Alamat Pengiriman</label> <br>
              <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" style="text-align:center;"/>
              <label for="address">Kota</label> <br>
              <select class="form-control" id="city" name="city" >
                @foreach($city as $data)
                  @if(Auth::user()->city_id == $data->city_id)
                    <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                  @else
                    <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                  @endif
                @endforeach
              </select>
              <label for="zipcode">Kode Pos Pengiriman</label> <br>
              <input type="text" class="form-control" name="zipcode" value="{{ Auth::user()->zipcode }}" style="text-align:center;"/>
              <label for="Agent">Pilih Agent</label> <br>
              <select class="form-control" id="agent" name="agent" >
              @foreach($agent as $data)
                @if(Auth::user()->city_id == $data->city_id)
                  <option value="{{ $data->id }}" selected >{{$data->name}} - {{ $data->city_name }}</option>
                @else
                  <option value="{{ $data->id }}">{{$data->name}} - {{ $data->city_name }}</option>
                @endif
              @endforeach
              </select>
              
              <label for="Date">Tanggal Pengiriman</label><br>
              <input type="text" class="form-control" name='request_date' placeholder='Example = 2016-05-31 (year-month-day)' id="datepicker" autocomplete="off" /> 
              <label for="payment">Pembayaran</label>
              <br>
              <input type="radio" name="payment" id="payment" value="0" checked> <label>Bank Transfer     </label> 
              <input type="radio" name="payment" id="payment" value="1"> <label>FirstPay</label><br>  
            <br>
            <br>

            <br>


            <input type="button" value="Previous" onclick="show_prev('product_details','bar1');">
            <input type="submit" value="Submit" style="color:white; border: solid white;">
          </Center>
          </div>
          </div>
          

        </form>
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@push('scripts')
<script>
  $(document).ready(function() {
      tabel();
  } );

   $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd', minDate: <?php echo "'". $start."'"; ?>  }).val();
        $( "#datepicker" ).datepicker();
    });

   function tabel()
   {
    $.ajax({
      type: "GET",
      url: "{{ URL::to('customercart')}}",
      success:
      function(data)
      {
        $('#table').html(data);
      }
    });
   }

  function updatecart(x)
  {
    var rowId = $('#'+x+'-rowid').val();
    var id = $('#'+x+'-id').val();
    var quantity = $('#'+x+'-qty_subcriber').val();

    $.ajax({
      url: '{{URL("/updatecart_single")}}',
      type:'POST',
      data: {rowId:rowId, qty: quantity, id:id},
      beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
    })
    .success(function(data){
      $('#'+x+'-subtotal').html(data.response.subtotal);
      $('#total-cart').html(data.response.total);
      alert("Update Data berhasil!");
    })
    .fail(function(){
      alert('error');
    })
  }

  function deletecart(x)
  {
    if (confirm("Apakah Anda ingin menghapus produk yang dipilih ?") == true) 
    {
      var rowId = $('#'+x+'-rowid').val();
      var id = $('#'+x+'-id').val();
      var quantity = $('#'+x+'-qty_subcriber').val();

      $.ajax({
        url: '{{URL("/deletecart_single")}}',
        type:'POST',
        data: {rowId:rowId, qty: quantity},
        beforeSend: function(request){
              return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
            },
      })
      .success(function(data){
        /*var t = $('#order_details').DataTable();
        t.row(x).remove().draw();*/
        tabel();
        $('#total-cart').html(data.response.total);
        alert("Delete Data berhasil!");
      })
      .fail(function(){
        alert('error');
      })
    }
  }

  function check()
  {
    var table = $('#order_details').DataTable({retrieve: true});

    if(table.rows().data().length > 0) 
    show_next('product_details',  'delivery_address','bar1');
    else
    {
      var data = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Anda harus membeli minimal 1 produk</strong></div>';
      document.getElementById('alert').innerHTML = data;
    }
  }


</script>
@endpush
@stop