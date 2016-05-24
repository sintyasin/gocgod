@extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="container">
  <div class="padding_outer">
    <h2> CheckOut </h2>
  
    @if (Auth::guest())
      <a href={{ URL('/login')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
      <hr>
      <hr>
      <hr>
    @else

    <div class="stepper">
            <div id="wrapper">
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
              </div>

              <br>
              <br>
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('productsample') }}">
                {!! csrf_field() !!}
                  <div id="checkout_method">
                    <p class='form_head'>Checkout Method</p>
                    <p>Who are you?</p>
                    <input type="radio" name="buyer" value=0><label>Single Buyer</label><br>
                    <input type="radio" name="buyer" value=1><label>Subcriber</label>
                    

                    <input type="button" value="Next" onclick="show_next('checkout_method','choose_products','bar1');">
                  </div>
                        
                  <div id="product_details">
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
                    <input type="button" value="Previous" onclick="show_prev('account_details','bar1');">
                    <input type="Submit" value="Submit">
                  </div>
              </form>
            </div>
        </div>



<!--     <div class="checkout-content-area page-section-padding"> -->
      <div class="container">
       <div class="row">
        <div class="checkout-content">
         <div class="col-xs-12">
          <div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group">
           <div class="panel sauget-accordion">
            <div id="headingOne" role="tab" class="panel-heading">
             <h4 class="panel-title">
              <a aria-controls="checkoutMethod" aria-expanded="true" href="#checkoutMethod" data-parent="#accordion" data-toggle="collapse" class="">
               1. Checkout Method
             </a>
           </h4>
         </div>
         <div aria-labelledby="headingOne" role="tabpanel" class="panel-c ollapse collapse in" id="checkoutMethod" aria-expanded="true" style="">
           <div class="content-info">
            <div class="col-xs-12 col-sm-9">
             <div class="checkout-reg">
              <div class="checkReg commonChack">
               <div class="checkTitle">
                <h6 class="ct-design">CHECKOUT AS A SINGLE BUYER OR SUBCRIBER</h6>
              </div>
              <p>Who are you?</p>
              <form method = "POST">
                <input type="radio" name="buyer" value=0><label>Single Buyer</label><br>
                <input type="radio" name="buyer" value=1><label>Subcriber</label>

                <div class="regSaveTime commonChack">
               <p>*Free Shipping Fee For Subcriber or Buy More Than 5 Items<br/>
              </div>
               <button class="checkPageBtn" aria-controls="shippingMethod" aria-expanded="false" href="#shippingMethod" data-parent="#accordion" data-toggle="collapse" class="collapsed" id="single" disabled="disabled">CONTINUE AS SINGLE</button>
               <button class="checkPageBtn" aria-controls="billingInformation" aria-expanded="false" href="#billingInformation" data-parent="#accordion" data-toggle="collapse" class="collapsed" id="subcriber" disabled="disabled">CONTINUE AS SUBCRIBER</button>
              </form>
            </div>
            
           </div>
         </div>

       </div>
     </div>
    </div>
    </div>
    <div class="panel sauget-accordion">
      <div id="headingTwo" role="tab" class="panel-heading">
       <h4 class="panel-title">
        <!-- <a aria-controls="billingInformation" aria-expanded="false" href="#billingInformation" data-parent="#accordion" data-toggle="collapse" class="collapsed"> -->
        <a>
         2. Choose Products (Subscriber only)
       </a>
     </h4>
    </div>
    <div aria-labelledby="headingTwo" role="tabpanel" class="panel-collapse collapse" id="billingInformation" aria-expanded="false" style="height: 0px;">
     <div class="content-info">
      <div class="col-xs-12">
       <div class="billing-info">
        <div class="regSaveTime commonChack">
         <div class="checkTitle">
            <h6 class="ct-design">CHECKOUT AS A SINGLE BUYER OR SUBCRIBER</h6>
          </div>
       </div>
       <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
          <thead>
            <tr>
              <th>Product</th>
              <th>Picture</th>
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
              <td> <img src = {{URL::asset("assets/images/product/". $queryCategory[$i]->category_name . "/" . $items->picture)}} /> </td>
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
            </tr> -->
          </tbody>
        </table>
        <p><font size="3"><b>How many weeks do you want to buy?</b></font></p>
        <input type="number" min="1" value="1" style="width:40px; color:black;"> <br><br>
        <br><br>
       <a class="checkPageBtn" aria-controls="shippingMethod" aria-expanded="false" href="#shippingMethod" data-parent="#accordion" data-toggle="collapse" class="collapsed">CONTINUE</a>
     </div>
    </div>
    </div>
    </div>
    </div>
    <div class="panel sauget-accordion">
      <div id="headingThree" role="tab" class="panel-heading">
       <h4 class="panel-title">
        <a>
         3. Order Details
       </a>
     </h4>
    </div>
    <div aria-labelledby="headingThree" role="tabpanel" class="panel-collapse collapse" id="shippingMethod" aria-expanded="false">
     <div class="content-info">
      <div class="col-xs-12">
       <div class="shiping-method">
        <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
          <thead>
            <tr>
              <th>Product</th>
              <th>Picture</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Sub Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cin Cau</td>
              <td><img src={{ URL('assets/images/product/minuman/cin_cau.jpg') }} style='height:200px;'/></td>
              <td>60000</td>
              <td align="center">
                <input type="number" min="1" value="1" style="width:40px; color:black;"> <br><br>
                <button type="button" class="btn btn-primary">Update</button>
              </td>
              <td>60000</td>
              <td align="center">
                <button type="button" class="btn btn-danger">Delete</button>
              </td>
            </tr>
            <tr>
              <td>Soya Milk</td>
              <td><img src={{ URL('assets/images/product/minuman/soya_milk.jpg') }} style='height:200px;'/></td>
              <td>75000</td>
              <td align="center">
                <input type="number" min="1" value="2" style="width:40px; color:black;"> <br><br>
                <button type="button" class="btn btn-primary">Update</button>
              </td>
              <td>150000</td>
              <td align="center">
                <button type="button" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        <p class="plxLogin"><font size="3">Total Price</font></p>
        <p class="plxLogin"><font size="4"><b>Rp 210.000.00</b></font></p>
        <div class="block-area-button">
         <a class="checkPageBtn" href="#">Continue</a>
       </div>                                                  
     </div>
    </div>
    </div>
    </div>
    </div>
    <div class="panel sauget-accordion">
      <div id="headingFive" role="tab" class="panel-heading">
       <h4 class="panel-title">
        <a aria-controls="orderReview" aria-expanded="false" href="#orderReview" data-parent="#accordion" data-toggle="collapse" class="collapsed">
         4. Delivery Address
       </a>
     </h4>
    </div>
    <div aria-labelledby="headingFive" role="tabpanel" class="panel-collapse collapse" id="orderReview" aria-expanded="false">
     <div class="content-info">
      <div class="review-bar">
       <div class="col-xs-12 col-sm-6">
        <div class="product">
          <form action="">
            <font color="black">
            <div class="form-group">
              <label for="address">Select your delivery addres</label> <br>
              <input type="radio" name="address" value="male" checked> Use my account's address<br>
              <input type="radio" name="address" value="female"> Other address<br>
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="phone">Enter recipient phone number</label> <br>
              <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" />
            </div>
            </font>
          </form>
          <div class="block-area-button">
            <a class="checkPageBtn" href="#">Done</a>
          </div>   
       </div>
     </div>
    </div>
    </div>
    </div>
    </div>
    <div class="panel sauget-accordion">
      <div id="headingFour" role="tab" class="panel-heading">
       <h4 class="panel-title">
        <a aria-controls="paymentInformation" aria-expanded="false" href="#paymentInformation" data-parent="#accordion" data-toggle="collapse" class="collapsed">
         5. Payment Information
       </a>
     </h4>
    </div>
    <div aria-labelledby="headingFour" role="tabpanel" class="panel-collapse collapse" id="paymentInformation" aria-expanded="false">
     <div class="content-info">
      <div class="col-xs-12">
        <h3 class="payment_total"> Total Order + Shipping Fee = </h3>
       <div class="checkout-option">
        <div class="method-input-box">
         <p><input type="radio" name="payment" value="check"><label>Check / Money order </label></p>
         <p><input type="radio" name="payment" value="card" checked><label>Credit Card (saved) </label></p>                                      
       </div>
       <div class="master-card-info">
         <form action="#">
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
    </form>
    <div class="block-area-button">
      <a class="checkPageBtn" href="#">Continue</a>
    </div>                                                  
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    @endif
<!--     </div> -->
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

$("input:radio[name=buyer]").click(function(){
  var value = $(this).val();
  if(value == 0){
    $("button[id=single]").prop('disabled', false);
  }
  else if(value == 1){
    $("button[id=subcriber]").prop('disabled', false);
  }
});

</script>
@endpush
@stop