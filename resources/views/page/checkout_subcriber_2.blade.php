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
            <p class='form_head'>Order Details</p>
            <div class="shiping-method">
              <table id="order_details" class="display table table-striped table-bordered dt-responsive" width="100%">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=0?>
                  @foreach(Cart::instance('subcriber')->content() as $row)
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
                      <button type="button" class="btn btn-primary" onclick="updatecart({{ $i }})"> Update</button>
                      <button type="button" onclick="deletecart({{ $i }})" class="btn btn-danger">Delete</button>
                    </td>
                  </tr>
                  <?php $i++; ?>
                  @endforeach
                </tbody>
              </table>
              <p class="plxLogin"><font size="3">Total Price</font></p>
              <p class="plxLogin"><font size="4"><b>Rp <span id="total-cart"> {{number_format(Cart::total(), 2, ',', '.')}}</span></b></font></p>                                             
            </div>
            <br>
             <input type="button" value="Next" onclick="show_next('product_details', 'delivery_address','bar2');">
          </div>
        </div>
        <div id="wrapper">
        <!-- ================================================================================================ -->
        <!-- ================================================================================================ -->
          <div id="delivery_address">
          <Center>
            <p class='form_head'>Data Customer</p>
              <label for="phone">Customer's Name</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center;"/>
              <label for="address">Recipient's Address</label> <br>
              <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" style="text-align:center;"/>
              <label for="address">City</label> <br>
              <select class="form-control" id="city" name="city" >
                @foreach($city as $data)
                  @if(Auth::user()->city_id == $data->city_id)
                    <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                  @else
                    <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                  @endif
                @endforeach
              </select>
              <label for="Agent">Choose an Agent</label> <br>
              <select class="form-control" id="agent" name="agent" >
              @foreach($agent as $data)
                @if(Auth::user()->city_id == $data->city_id)
                  <option value="{{ $data->id }}" selected >{{$data->name}} - {{ $data->city_name }}</option>
                @else
                  <option value="{{ $data->id }}">{{$data->name}} - {{ $data->city_name }}</option>
                @endif
              @endforeach
              </select>

              <label for="week">How many weeks?</label><br>
              <input type="number" class="form-control" name='week'/>

              <label for="Date">Request Shipping Date</label><br>
              <input type="text" class="form-control" name='request_date' placeholder='Example = 2016-05-31 (year-month-day)' id="datepicker"/>   

              <label>The shipping day will be same with the first choosed day, you can change the day for the next shipping at "My Order" menu.</label>
            <br>


            <input type="button" value="Previous" onclick="show_prev('product_details','bar3');">
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
      var table = $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );

   $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd', minDate: 'today+3' }).val();
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
      t.row(x).remove().draw(false);
      $('#total-cart').html(data.response.total);
      alert("Delete Data berhasil!");
    })
    .fail(function(){
      alert('error');
    })
  }

</script>
@endpush
@stop