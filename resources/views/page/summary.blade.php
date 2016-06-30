  @extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="container">
  <div class="padding_outer">
    <h2> CheckOut </h2>
  
    @if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/register')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
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
            <p class='form_head'>Summary</p>
              <label for="phone">Customer's Name</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center;"/>
              <label for="address">Recipient's Address</label> <br>
              <input disabled type="text" class="form-control" name="address" value="{{ $order->ship_address}}" style="text-align:center;"/>
              <label for="Date">Shipping Date</label><br>
              <input disabled type="text" class="form-control" name='request_date' value="{{$order->shipping_date}}" id="datepicker" autocomplete="off" /> 
              <label for="payment">Payment</label>
              <br>
              <input disabled type="text" class="form-control" name="address" value="Bank Transfer" style="text-align:center;"/><br>  
            <br>
            <br>

            <p class="plxLogin"><font size="3">Total Product Price : Rp {{number_format($order->total, 2, ',','.')}}</font> </p>
            <p class="plxLogin"><font size="3">Shipping Fee  : Rp {{number_format($order->shipping_fee, 2, ',','.')}}</font> </p>
            <hr>
            <p class="plxLogin"><font size="4">Total  : Rp {{number_format($order->shipping_fee + $order->total, 2, ',','.')}}</font> </p>
            
            <p class="plxLogin"><font size="3">Please Transfer to <br>GOCGOD<br></font> </p>

          </Center>
          </div>
          </div>
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@stop