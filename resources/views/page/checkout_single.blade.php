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

    @if (session('error'))
      <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ session('error') }}</strong>
      </div>
    @endif


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
              <p class="plxLogin"><font size="4"><b>Rp <span id="total-cart"> {{number_format(Cart::total(), 0, ',', '.')}}</span></b></font></p>                                             
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
            <div class="col-md-12">
            <p class='form_head'>Data Pelanggan</p>
            

              <div class="col-md-6 col-md-offset-3">
              <label for="name">Nama Pelanggan</label> <br>
              <input disabled type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" style="text-align:center; width:100%"/>
              </div>

              <div class="col-md-offset-3 col-md-3">
              <label for="Agent">Pilih Provinsi</label> <br>
              <select id="basic" class="selectpicker show-tick form-control" data-live-search="true" style="width:100%">
                <option value="">State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
              </select>
              <!-- </select> -->
              </div>


              <div class="col-md-6 col-md-offset-3">
              <label for="address">Alamat Pengiriman</label> <br>
              <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" style="text-align:center; width: 100%;"/>

              @if ($errors->has('address'))
                <span class="help-block">
                    <strong style="color:#ff3333;">{{ $errors->first('address') }}</strong>
                </span>
              @endif

              </div>

              <div class="col-md-offset-3 col-md-3  ">              
              <label for="address">Kota</label> <br>
              <select class="form-control" id="city" name="city" style="width:100%">
                @foreach($city as $data)
                  @if(Auth::user()->city_id == $data->city_id)
                    <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                  @else
                    <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                  @endif
                @endforeach
              </select>
              </div>

              <div class="col-md-3">
              <label for="zipcode">Kode Pos Pengiriman</label> <br>
              <input type="text" class="form-control" name="zipcode" value="{{ Auth::user()->zipcode }}" style="text-align:center; width:100%;" onkeypress="return isNumber(event)"/>

              @if ($errors->has('zipcode'))
                <span class="help-block">
                    <strong style="color:#ff3333;">{{ $errors->first('zipcode') }}</strong>
                </span>
              @endif

              </div>

              <div class="col-md-6 col-md-offset-3">
              <label for="Agent">Pilih Kecamatan</label> <br>
<!--               <select class="form-control" id="agent" name="agent" style="width:100%" > -->
              <select class="ui search dropdown">
                <option value="">State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
              </select>
              <!-- </select> -->
              </div>

              <div class="col-md-6 col-md-offset-3">
              <label for="Date">Tanggal Pengiriman</label><br>
              <input type="text" class="form-control" name='request_date' placeholder='Example = 2016-05-31 (year-month-day)' id="datepicker" autocomplete="off" style="width:100%;" />

              @if ($errors->has('request_date'))
                <span class="help-block">
                    <strong style="color:#ff3333;">{{ $errors->first('request_date') }}</strong>
                </span>
              @endif

              </div> 

              <br><br> 
              <div class="col-md-12">
              <label for="payment" style="font-size:20px;">Pembayaran</label>
              <br>
              <input type="radio" name="payment" id="payment" value="0" checked> <label>Bank Transfer     </label>
               
              <input type="radio" name="payment" id="payment" value="1"> <label>FirstPay</label><br>  
              
            <br>
            <br>

            <br>


            <input type="button" value="Previous" onclick="show_prev('product_details','bar1');">
            <input type="submit" value="Submit" style="color:white; border: solid white;">
            </div>
            </div>
          </Center>
          </div>
          </div>
          

        </form>

    </div>
    @endif
    
  </div>
</div>
<br>
<br>
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

   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

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
      $('#'+x+'-subtotal').html('Rp ' + data.response.subtotal.toLocaleString());
      $('.dtr-data').find('#'+x+'-subtotal').html('Rp ' + data.response.subtotal.toLocaleString());
      $('#total-cart').html(data.response.total.toLocaleString());
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
        tabel();
        $('#total-cart').html(data.response.total.toLocaleString());
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