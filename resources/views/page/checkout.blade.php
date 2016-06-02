@extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="container">
  <div class="padding_outer">
    <h2> CheckOut </h2>
  

    @if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/login')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
      </div>
    @else

    <div class="stepper">
      <div id="wrapper_progress">
        <br>
        <div class="col-md-12 col-xs-12">
          <span class='baricon'>1</span>
          <span id="bar1" class='progress_bar'></span>
          <span class='baricon'>2</span>
          <span id="bar2" class='progress_bar'></span>
          <span class='baricon'>3</span>
          <span id="bar3" class='progress_bar'></span>
          <span class='baricon'>4</span>
          <span id="bar4" class='progress_bar'></span>
          <span class='baricon'>5</span>
          <span id="bar5" class='progress_bar'></span>
          <span class='baricon'>6</span>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      </div>
            
      <form class="form-horizontal" role="form" method="POST" action="{{ url('orderall') }}">
        <div id="wrapper">
          {!! csrf_field() !!}
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="checkout_method">
            <br>
            <p class='form_head'>Checkout Method</p>
            <p>Who are you?</p>
            <input type="radio" name="buyer" id="single" value="single" checked="checked"><label> &nbsp; Single Buyer</label><br>
            <input type="radio" name="buyer" id="subcribe" value="subscribe"><label> &nbsp; Subcriber</label>
            <br><br><p>*Free Shipping Fee For Subcriber or Buy More Than 5 Items</p>
            <input type="button" value="Next" onclick="show_next1('checkout_method');">
            <br>
            <br>
          </div>
        </div>
        
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
        <div id="wrapper_table">
          <div id="subcriber">
            <br>
            <p class='form_head'>Choose Products (Subscriber only)</p>
            <table class="display table table-striped table-bordered dt-responsive" width="100%">
              <thead>
                <tr>
                  <th>Product</th>
<!--                   <th>Picture</th> -->
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Day</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach ($query_menu as $items)
                  <tr>
                    <td> {{$items->varian_name}} </td>
<!--                     <td> <img src = {{URL::asset("assets/images/product/". $queryCategory[$i]->category_name . "/" . $items->picture)}} /> </td> -->
                    <td style="text-align: justify"> {{$items->description}} </td>
                    <td> Rp{{number_format($items->price, 2, ',', '.')}} </td>
                    <td>
                      <select>
                        <option value="">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                      </select>
                    </td>
                    <td>
                      <select style="color:black;">
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="2">Friday</option>
                        <option value="3">Saturday</option>
                        <option value="4">Sunday</option>
                      </select>
                    </td>
                  </tr>
                  <?php $i++?>
                @endforeach
              </tbody>
            </table>
            <br>
            <input type="button" value="Previous" onclick="show_prev('checkout_method', 'bar1');">
            <input type="button" value="Next" onclick="show_next('subcriber', 'product_details' ,'bar2');">
          </div>
        
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="product_details">
            <p class='form_head'>Order Details</p>
            <div class="shiping-method">
              <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>rowid</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(Cart::content() as $row)
                  <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->rowid}}</td>
                    <td>{{$row->price}}</td>
                    <td align="center">
                      <input type="hidden" id="id" value="{{$row->rowid}}">
                      <!-- <input type="text" value="{{ $row->qty }}" id="qty" class="qty" maxlength="2" min="1" data-row="{{ $row->rowid }}" data-kode="{{ $row->id }}" data-line="{{ $i.'-'.$row->rowid }}" onkeypress="return isNumber(event)" style="text-align:center;"> -->
                      <input type="number" min="1" maxlength="2" id="qty" value="{{$row->qty}}" data-row="{{ $row->rowid }}" style="width:60px; color:black;"> <br><br>
                      <button type="button" class="btn btn-primary" onclick="updatecart()"> Update</button>
                    </td>
                    <?php $a = $row->price * $row->qty?>
                    
                    <td>{{$row->Subtotal}}</td>
                    <td align="center">
                      <button type="button" onclick="deletecart()" class="btn btn-danger">Delete</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <p class="plxLogin"><font size="3">Total Price</font></p>
              <p class="plxLogin"><font size="4"><b>Rp 210.000.00</b></font></p>                                             
            </div>
            <br>
            <input type="button" value="Previous" onclick="show_prev('subcriber','bar2');">
            <input type="button" value="Next" onclick="show_next('product_details', 'delivery_address','bar3');">
          </div>
        </div>
        <div id="wrapper">
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="delivery_address">
            <p class='form_head'>Request Product Sample</p>
              <label for="address">Select your delivery addres</label> <br>
              <input type="radio" name="address" value="male" checked> Use my account's address<br>
              <input type="radio" name="address" value="female"> Other address<br>    
              <div class="col-md-6">
              <textarea class="form-control" rows="3"  style="display:block; margin-left: auto; margin-right: auto;"></textarea>
              </div>
              <br>
              <label for="phone">Enter recipient phone number</label> <br>
              <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" />
              
            <br>
            <input type="button" value="Previous" onclick="show_prev('product_details','bar3');">
            <input type="button" value="Next" onclick="show_next('delivery_address', 'choose_agent', 'bar4');">
          </div>

        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->            
          <div id="choose_agent">
            <p class='form_head'>Request Product Sample</p>
            <p>Product</p>
            <select  name='product'>
            <!--  -->
            </select>
            <p>Quantity</p>
            <select  name='quantity'>
                <option value="10"> 10 </option> 
                <option value="15"> 15 </option>
                <option value="20"> 20 </option>
            </select>
            <br>
            <input type="button" value="Previous" onclick="show_prev('delivery_address','bar4');">
            <input type="button" value="Next" onclick="show_next('choose_agent', 'payment','bar5');">
          </div>

        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="payment">
            <p class='form_head'>Total Order + Shipping Fee</p>
            <div class="checkout-option">
              <div class="method-input-box">
                <p><input type="radio" name="payment" value="check"><label>Check / Money order </label></p>
                <p><input type="radio" name="payment" value="card" checked><label>Credit Card (saved) </label></p>               
              </div>
              <div class="master-card-info">
              <!-- <form action="#"> -->
                <div class="form-group">
                  <label>Name on Card</label>
                  <input type="text" class="form-control">            
                </div>      
                <div class="cardtype form-group">
                  <label>Credit Card Type</label>
                  <select class="form-control">
                    <option>--Please Select--</option>
                    <option>American Express</option>
                    <option>Visa</option>
                    <option>MasterCard</option>
                    <option>Discover</option>
                  </select>
                </div>
                <div class="form-group">
                 <label>Credit Card Number</label>
                 <input type="text" class="form-control">            
                </div>  
                <div class="expirationdate form-group">
                 <label>Expiration Date</label>
                 <select class="form-control month-select">
                  <option>Month</option>
                  <option>01 - January</option>
                  <option>02 - February</option>
                  <option>03 - March</option>
                  <option>04 - April</option>
                  <option>05 - May</option>
                  <option>06 - June</option>
                  <option>07 - July</option>
                  <option>08 - August</option>
                  <option>09 - September</option>
                  <option>10 - October</option>
                  <option>11 - November</option>
                  <option>12 - December</option>
                 </select><br/>
                 <select class="form-control year-select">
                  <option>Year</option>
                  <option>2015</option>
                  <option>2016</option>
                  <option>2017</option>
                  <option>2018</option>
                  <option>2019</option>
                  <option>2020</option>
                  <option>2021</option>
                  <option>2022</option>
                  <option>2023</option>
                  <option>2024</option>
                  <option>2025</option>
                 </select>
                </div>
                <div class="verificationcard form-group">
                 <label>Card Verification Number</label>
                 <input type="text" class="form-control"><br/>
                 <a href="#">What is this?</a>
                </div>                                             
              </div>
            </div>
            <input type="button" value="Previous" onclick="show_prev('choose_agent','bar5');">
            <input type="Submit" value="Submit">
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
      $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
  
  $(document).ready(function(){
    $('.qty-box').on('input propertychange paste', function(e) {
      var rowId = $(this).data('row');
      var kode  = $(this).data('kode');
      var elem  = $(this);
      var line  = $(this).data('line');


      if(elem.val() > 0){
        $.ajax({
          type: 'post',
          url: '{{URL("/updateCart")}}',
          dataType: 'json',
          data: {rowId:rowId, qty:elem.val(), kode:kode},
          success: function (data) {
            // if (data.success) {
            //   $('#'+line+'-subtotal').html(data.success.data.subtotal);
            //   $('#total-cart').html(data.success.data.total);
            //   $('#cart-counter').html(data.success.data.count);
            // } else if 
            if (data.error) {
              Materialize.toast(data.error.message.warning, 3000)
              elem.val('');
            }
          }
        });
      }
      e.preventDefault();
    });

    $('[data-action="removeCart"]').click(function(e) {
      var produk = $(this).data('product');
      var kode = $(this).data('kode');
      var nama = $(this).data('nama');
      var ctn  = $('#notes').val();
      var element = this;

      //tempNotes(ctn);

      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '{{ URL::to("shop/cart/remove/") }}',
        data: {produk:produk, kode:kode},
        success: function (data) {
          $(element).closest ('tr').replaceWith('<tr><td colspan="6"><i>Product <a href="/shop/item/'+data.success.data.item+'">'+nama+'</a> removed from cart</i></td></tr>');
          $('#total-cart').html(data.success.data.total);
          $('#cart-counter').html(data.success.data.count);
        },
      });
      e.preventDefault();
    });
  });

  // $(document).ready(function(){
  //   $('.qty-box').on('input propertychange paste', function(e) {
  //     var rowId = $(this).data('row');
  //     var kode  = $(this).data('kode');
  //     var elem  = $(this);
  //     var line  = $(this).data('line');

  //     if(elem.val() > 0){
  //       $.ajax({
  //         type: 'post',
  //         url: '{{ URL("/updatecart")}}',
  //         dataType: 'json',
  //         data: {rowId:rowId, qty:elem.val(), kode:kode},
  //         success: function (data) {
  //           if (data.success) {
  //             $('#'+line+'-subtotal').html(data.success.data.subtotal);
  //             $('#total-cart').html(data.success.data.total);
  //             $('#cart-counter').html(data.success.data.count);
  //           } else if (data.error) {
  //             Materialize.toast(data.error.message.warning, 3000)
  //             elem.val('');
  //           }
  //         }
  //       });
  //     }
  //     e.preventDefault();
  //     });
  // });



  function updatecart()
  {

    var rowId = $('#id').val();
    var quantity = $('#qty').val();

    $.ajax({
      url: '{{URL("/updatecart")}}',
      type:'POST',
      data: {rowId:rowId, qty: quantity},
      beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
    })
    .done(function(){
      alert("Update Data berhasil!");
    })
    .fail(function(){
      alert('error');
    })
  }

  function deletecart()
  {

    var rowId = $('#id').val();
    var quantity = $('#qty').val();

    $.ajax({
      url: '{{URL("/deletecart")}}',
      type:'POST',
      data: {rowId:rowId, qty: quantity},
      beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
    })
    .done(function(){
      alert("Delete Data berhasil!");
    })
    .fail(function(){
      alert('error');
    })
  }

</script>
@endpush
@stop