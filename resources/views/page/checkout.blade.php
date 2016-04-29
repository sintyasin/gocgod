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
     <div aria-labelledby="headingOne" role="tabpanel" class="panel-c ollapse collapse in" id="checkoutMethod" aria-expanded="true" style="">
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
     2. Choose Products (Subscriber only)
   </a>
 </h4>
</div>
<div aria-labelledby="headingTwo" role="tabpanel" class="panel-collapse collapse" id="billingInformation" aria-expanded="false" style="height: 0px;">
 <div class="content-info">
  <div class="col-xs-12">
   <div class="billing-info">
    <div class="regSaveTime commonChack">
     <br> <h4><font color="black">Choose your products</font></h4> <br>
   </div>
   <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
      <thead>
        <tr>
          <th>Product</th>
          <th>Picture</th>
          <th>Description</th>
          <th>Price</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Cin Cau</td>
          <td><img src={{ URL('assets/images/product/minuman/cin_cau.jpg') }} style='height:200px;'/></td>
          <td>Manfaat air cin cau cukup beragam sudah biasa di gunakan dalam pengobatan tradisional untuk obat batuk, tekanan darah tinggi, diare, sembelit, menurunkan demam , mengobati panas dalam, menjaga sistem pencernaan , mengatasi perut kembung . Air cin cau hitam juga sangat membantu bagi anda yg sedang menjalani program diet</td>
          <td>60000</td>
          <td>
            <select>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Kacang Hijau</td>
          <td><img src={{ URL('assets/images/product/minuman/kacang_hijau.jpg') }} style='height:200px;'/></td>
          <td>Manfaat sari kacang hijau 1.Meningkatkan penyerapan nutrisi 2. Mencegah penyakit jantung dan stroke 3.Membersihkan pencernaan 4.Mengatasi anemia 5.Menjaga berat badan 6.Membantu pertumbuhan sel organ, otot dan otak Tanpa bahan pengawet !!!!</td>
          <td>60000</td>
          <td>
            <select>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Soya Milk</td>
          <td><img src={{ URL('assets/images/product/minuman/soya_milk.jpg') }} style='height:200px;'/></td>
          <td>Soya milk terbuat dari kacang kedelai pilihan , minuman bergizi dan berprotein sangat tinggi Tanpa bahan pengawet !!! Dan pemanis buatan Sangat cocok untuk anak-anak, dewasa, dan org tua . Kualitas terjamin</td>
          <td>75000</td>
          <td>
            <select>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
    <p><font size="3"><b>How many weeks do you want to buy?</b></font></p>
    <input type="number" min="1" value="1" style="width:40px; color:black;"> <br><br>
    <p><font size="3"><b>Choose your delivery day</b></font></p>
    <select style="color:black;">
      <option value="1">Monday</option>
      <option value="2">Tuesday</option>
      <option value="3">Wednesday</option>
      <option value="4">Thursday</option>
      <option value="2">Friday</option>
      <option value="3">Saturday</option>
      <option value="4">Sunday</option>
    </select>
    <br><br>
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
          <input type="text" class="form-control" name="phone" placeholder="Phone number" />
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
</div>
<!-- End checkout content -->
@push('scripts')
<script>

$(document).ready(function() {
    $('table.display').DataTable( {
      "autoWidth": false
    } );
} );
</script>
@endpush
@stop