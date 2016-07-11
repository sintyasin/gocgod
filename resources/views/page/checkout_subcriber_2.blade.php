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
          <span id="bar1" class='progress_bar' style="background-color:#38610B"></span>
          <span class='baricon'>2</span>
          <span id="bar2" class='progress_bar'></span>
          <span class='baricon'>3</span>
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
            
      <form class="form-horizontal" role="form" method="POST" action="{{ url('orderall') }}">
      {!! csrf_field() !!}
        <div id="wrapper_table">
          <div id="product_details">
            <p class='form_head'>Rincian Pesanan</p>
            <div class="shiping-method">
              <table id="order_details" class="display table table-striped table-bordered dt-responsive" width="100%">
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Sub Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=0?>
                  @foreach(Cart::content() as $row)
                  <tr>
                    <td>{{$row->name}}</td>
                    <td>Rp {{$row->price}}</td>
                    <td align="center">
                      <input type="hidden" id="{{ $i.'-rowid' }}" value="{{$row->rowid}}">
                      <input type="hidden" id="{{ $i.'-id' }}" value="{{$row->id}}">
                      <input type="number" min="1" maxlength="2" id="{{ $i.'-qty_subcriber' }}" value="{{$row->qty}}" style="width:60px; color:black; text-align: center;">
                      
                    </td>
                    <td><span id="{{ $i.'-subtotal' }}">Rp {{$row->subtotal}}</span></td>
                    <td align="center">
                      <button type="button" class="btn btn-primary" onclick="updatecart({{ $i }})"> Ubah</button>
                      <button type="button" onclick="deletecart({{ $i }})" class="btn btn-danger">Hapus</button>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  @endforeach
                </tbody>
              </table>
              <p class="plxLogin"><font size="3">Total Harga</font></p>
              <p class="plxLogin"><font size="4"><b>Rp <span id="total-cart"> {{number_format(Cart::total(), 2, ',', '.')}}</span></b></font></p>                                             
            </div>
            <br>
            <div id="alert">
            </div>
              <input onclick="back()" type="button" value="Back"> 
             <input type="button" value="Next" onclick="check()">
          </div>
        </div>
        <div id="wrapper">
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="delivery_address">
          <Center>
            <p class='form_head'> Data Pelanggan <p>
              <label for="name">Nama Pelanggan</label> <br>
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
              

              <label for="week">Berlangganan Berapa Minggu?</label><br>
              <input type="number" min="2" value="2" class="form-control" name='week'/>

              <label for="Date">Tanggal Pengiriman </label><br>
              <input type="text" class="form-control" name='request_date' placeholder='Contoh = 2016-05-31 (tahun-bulan-tanggal)' autocomplete="off" id="datepicker"/>   

              <label>Hari pengiriman akan sama dengan hari dari tanggal pengiriman pertama yang dipilih. <br> Anda dapat mengubah tanggal pengiriman pada minggu selanjutnya di menu "Orderku".</label>
              <br><br>  
              <label for="payment">Pembayaran</label>
              <br>
              <input type="radio" name="payment" id="payment" value="0" checked> <label>Bank Transfer     </label> 
              <input type="radio" name="payment" id="payment" value="1"> <label>FirstPay</label><br>  
            <br>
            <br>

            <br>

            <input type="button" value="Back" onclick="show_prev('product_details','bar3');">
            <input type="submit" value="Kirim" style="color:white; border: solid white;">
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
var table;
  $(document).ready(function() {
      table = $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );


  function back()
  {
    window.location = 'checkout_subcriber';
  }


   $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd', minDate: <?php echo "'". $start."'"; ?> }).val();
        $( "#datepicker" ).datepicker();
    });

  function updatecart(x)
  {
    var rowId = $('#'+x+'-rowid').val();
    var id = $('#'+x+'-id').val();
    var quantity = $('#'+x+'-qty_subcriber').val();

    $.ajax({
      url: '{{URL("/updatecart")}}',
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
    var rowId = $('#'+x+'-rowid').val();
    var id = $('#'+x+'-id').val();
    var quantity = $('#'+x+'-qty_subcriber').val();
    $.ajax({
      url: '{{URL("/deletecart")}}',
      type:'POST',
      data: {rowId:rowId, qty: quantity},
      beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
    })
    .success(function(data){
      var t = $('#order_details').DataTable();
      t.row(x).remove().draw();
      $('#total-cart').html(data.response.total);
      alert("Delete Data berhasil!");
    })
    .fail(function(){
      alert('error');
    })
  }

  function check()
  {
    if(table.rows().data().length > 0) 
      show_next('product_details', 'delivery_address','bar2');
    else
    {
      var data = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Anda harus membeli minimal 1 produk</strong></div>';
      document.getElementById('alert').innerHTML = data;
    }

  }


</script>
@endpush
@stop