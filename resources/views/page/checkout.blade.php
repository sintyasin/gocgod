@extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="checkout-content-area page-section-padding">
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
     <div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse in" id="checkoutMethod" aria-expanded="true" style="">
       <div class="content-info">
        <div class="col-xs-12 col-sm-9">
         <div class="checkout-reg">
          <div class="checkReg commonChack">
           <div class="checkTitle">
            <h6 class="ct-design">CHECKOUT AS A SINGLE BUYER OR SUBCRIBER</h6>
          </div>
          <p>Who are you?</p>
          <input type="radio"><label>Checkout as Single Buyer</label><br>
          <input type="radio"><label>Checkout as Subcriber</label>
        </div>
        <div class="regSaveTime commonChack">
         <p>*Free Shipping Fee For Subcriber or Buy More Than 5 Items<br/>
        </div>
         <a class="checkPageBtn" href="#">CONTINUE</a>
       </div>
     </div>
     <div class="col-xs-12 col-sm-3">
       <div class="checkout-login">
        <div class="checkTitle">
         <h6 class="ct-design">Login</h6>
       </div>
       <p class="alrdyReg">Already Registered</p>
       <p class="plxLogin">Please log in below</p>
       <div class="loginFrom">
         <input type="text" placeholder="Email Address"><br>
         <input type="text" placeholder="Password">
       </div>
       <a class="checkPageBtn" href="#">Login</a>
     </div>
   </div>
 </div>
</div>
</div>
<div class="panel sauget-accordion">
  <div id="headingTwo" role="tab" class="panel-heading">
   <h4 class="panel-title">
    <a aria-controls="billingInformation" aria-expanded="false" href="#billingInformation" data-parent="#accordion" data-toggle="collapse" class="collapsed">
     2. Billing Information
   </a>
 </h4>
</div>
<div aria-labelledby="headingTwo" role="tabpanel" class="panel-collapse collapse" id="billingInformation" aria-expanded="false" style="height: 0px;">
 <div class="content-info">
  <div class="col-xs-12">
   <div class="billing-info">
    <div class="regSaveTime commonChack">
     <p>Select a billing address from your address book or enter a new address.</p>
   </div>
   <select class="form-control plx month-select">
     <option class="plxLogin">Boot Experts, Bonosrie D- Block, Dkaka,  1201, Bangladesh</option>
     <option class="plxLogin">Add New Address</option>
   </select>
   <div class="method-input-box">
     <input type="radio"><label>Ship to this address</label><br>
     <input type="radio"><label>Ship to different address</label>
   </div>
   <a class="checkPageBtn" href="#">CONTINUE</a>
 </div>
</div>
</div>
</div>
</div>
<div class="panel sauget-accordion">
  <div id="headingThree" role="tab" class="panel-heading">
   <h4 class="panel-title">
    <a aria-controls="shippingMethod" aria-expanded="false" href="#shippingMethod" data-parent="#accordion" data-toggle="collapse" class="collapsed">
     3. Shipping Method
   </a>
 </h4>
</div>
<div aria-labelledby="headingThree" role="tabpanel" class="panel-collapse collapse" id="shippingMethod" aria-expanded="false">
 <div class="content-info">
  <div class="col-xs-12">
   <div class="shiping-method">
    <p class="plxLogin"><small>Flat Rate</small></p>
    <p class="plxLogin">Fixed $40.00</p>
    <div class="block-area-button">
     <a class="checkPageBtn" href="#">Continue</a>
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
     4. Payment Information
   </a>
 </h4>
</div>
<div aria-labelledby="headingFour" role="tabpanel" class="panel-collapse collapse" id="paymentInformation" aria-expanded="false">
 <div class="content-info">
  <div class="col-xs-12">
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
<div class="panel sauget-accordion">
  <div id="headingFive" role="tab" class="panel-heading">
   <h4 class="panel-title">
    <a aria-controls="orderReview" aria-expanded="false" href="#orderReview" data-parent="#accordion" data-toggle="collapse" class="collapsed">
     5. Order Review
   </a>
 </h4>
</div>
<div aria-labelledby="headingFive" role="tabpanel" class="panel-collapse collapse" id="orderReview" aria-expanded="false">
 <div class="content-info">
  <div class="review-bar">
   <div class="col-xs-12 col-sm-6">
    <div class="product">
     <p class="ct-design"><strong>Blouse</strong></p>
     <p class="plxLogin">Short-sleeved blouse with feminine draped sleeve detail.</p>
   </div>
 </div>
 <div class="col-xs-12 col-sm-6">
  <div class="product-review">
   <label>Quality:</label>
   <p>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
  </p>
  <form>
    <div class="form-group">
     <label for="exampleInputEmail1">Title:</label>
     <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
   </div>
   <div class="form-group">
     <label>Comment:</label>
     <textarea class="form-control" rows="3"></textarea>
   </div>
   <button type="submit" class="checkPageBtn">Submit</button>
 </form>
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
</div>
<!-- End checkout content -->
@stop