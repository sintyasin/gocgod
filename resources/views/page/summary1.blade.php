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
        
      </div>
            
        <div id="wrapper">
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="">
          <Center>
            <p class='form_head'>Rincian Pembelanjaan</p>
              <label for="phone">Nama Pelanggan</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center;"/>
              <label for="address">Alamat Pengiriman</label> <br>
              <input disabled type="text" class="form-control" name="address" value="{{ $order->ship_address}}" style="text-align:center;"/>
              <label for="payment">Pembayaran</label>
              <br>
              <input disabled type="text" class="form-control" name="address" value="Bank Transfer" style="text-align:center;"/><br>  
            <br>
            <br>

            <p class="plxLogin"><font size="3">Total Harga Produk : Rp {{number_format($orderprice[0]->total_price, 2, ',','.')}}</font> </p>
            <p class="plxLogin"><font size="3">Ongkos Kirim  : Rp {{number_format(0, 2, ',','.')}}</font> </p>
            <hr>
            <p class="plxLogin"><font size="4">Total  : Rp {{number_format($orderprice[0]->total_price, 2, ',','.')}}</font> </p>
            
            <p class="plxLogin"><font size="3">Silahkan transfer ke <br>GOCGOD<br></font> </p>

            <a href="{{ url('/menu') }}"><input type="button" style="width:150px;" value="Kembali Berbelanja"> </a>

          </Center>
          </div>
          </div>
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@stop