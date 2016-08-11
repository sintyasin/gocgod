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
            <p class='form_head'>Konfirmasi Pembayaran</p>
              <label for="phone">Nama Pelanggan</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center;"/>
              <label for="address">Alamat Pengiriman</label> <br>
              <input disabled type="text" class="form-control" name="address" value="{{ $order->ship_address}}" style="text-align:center;"/>
              <label for="Date">Tanggal Pengiriman</label><br>
              <input disabled type="text" class="form-control" name='request_date' value="{{$order->shipping_date}}" id="datepicker" autocomplete="off" /> 
            <br>
            <br>

            <!-- kalo array berarti subscribe -->
            @if(isset($total))
              <!-- total - shipping fee, soalnya total udh termasuk shipping fee -->
              <p class="plxLogin"><font size="4">Total  : Rp {{number_format($total[0]->total_price, 2, ',','.')}}</font> </p>
            <!-- ini beli single -->
            @else
              <!-- total - shipping fee, soalnya total udh termasuk shipping fee -->
              <p class="plxLogin"><font size="3">Total Harga Produk : Rp {{number_format($order->total - $order->shipping_fee, 2, ',','.')}}</font> </p>
              <p class="plxLogin"><font size="3">Ongkos Kirim  : Rp {{number_format($order->shipping_fee, 2, ',','.')}}</font> </p>
              <hr>
              <p class="plxLogin"><font size="4">Total  : Rp {{number_format($order->total, 2, ',','.')}}</font> </p>
            @endif
            
            
            <form action="http://dev.firstpay-system.com/page/payment/choose" method="post" >
            <input type=hidden name="idorder" value="{{$order->group_id}}">
            <input type=hidden name="customer_email" value="{{Auth::user()->email}}">
            <input type=hidden name="customer_name" value="gocgod">
            @if(isset($total))
              <input type=hidden name="amount" value="{{$total[0]->total_price}}">
            @else
              <input type=hidden name="amount" value="{{$order->total}}">
            @endif
            <input type=hidden name="order_datetime" value="{{$order->order_date}}">
            <input type=hidden name="username" value="gocgod">
            <input type=hidden name="signature" value="{{$signature}}">
            
            <!-- <input type=hidden name="url_notification" value="{{URL('notification')}}">
            <input type=hidden name="url_redirect" value="{{URL('myorder')}}">
            <input type=hidden name="url_inquirystatus" value="http://www.gocgod.com"> -->

            <input type=hidden name="idcustomer" value="{{$order->customer_id}}" >
            <input type=hidden name="idproduct" value="1">
            <input type=hidden name="interval" value="1440">

            <input type=hidden name="customer_address" value="{{Auth::user()->address}}">
            <input type=hidden name="customer_city" value="{{$customerCity}}">
            <input type=hidden name="customer_country" value="{{Auth::user()->country}}">
            <input type=hidden name="customer_zipcode" value="{{Auth::user()->zipcode}}">

            <br>
            <button class="btn btn-default" type="submit" style="font-weight:bold; font-family:helvetica;">KLIK UNTUK MEMBAYAR</button>
            </form>

            

          </Center>
          </div>
          </div>
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@stop