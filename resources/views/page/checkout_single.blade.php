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
              <p class="plxLogin"><font size="3">Ongkos Kirim</font></p>
              <p class="plxLogin"><font size="4"><b>Rp <span id="shipping-fee"> {{number_format($shipping_fee, 0, ',', '.')}}</span></b></font></p>
              <p class="plxLogin"><font size="3">Total Harga</font></p>
              <p class="plxLogin"><font size="4"><b>Rp <span id="total-cart"> {{number_format(Cart::total() + $shipping_fee, 0, ',', '.')}}</span></b></font></p>
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
              <label for="Province">Pilih Provinsi</label> <br>
              <select id="basic" name="province" class="province selectpicker show-tick form-control" data-live-search="true">
                <option selected="selected">-- Pilih Provinsi --</option>
                  @foreach($province as $data)
                    @if(Auth::user()->province_id == $data->province_id)
                      <option value="{{ $data->province_id }}" selected >{{ $data->province_name }}</option>
                    @else
                      <option value="{{$data->province_id}}" id="{{$data->province_id}}">{{ $data->province_name}}</option>
                    @endif
                  @endforeach
              </select>
                @if ($errors->has('provinsi'))
                    <span class="help-block">
                        <strong>Provinsi harus diisi</strong>
                    </span>
                @endif
              </div>

              <div class="col-md-3">
              <label for="City">Pilih Kota</label> <br>
              <select id="basic_city" name="city" class="city selectpicker show-tick form-control" data-live-search="true">  
                @foreach($city as $data)
                    @if(Auth::user()->city_id == $data->city_id)
                      <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                    @else
                      <option value="{{$data->city_id}}" id="{{$data->city_id}}">{{ $data->city_name}}</option>
                    @endif
                @endforeach
              </select>
                @if ($errors->has('kota'))
                    <span class="help-block">
                        <strong>Kota harus diisi</strong>
                    </span>
                @endif
              </div>

              <div class="col-md-offset-3 col-md-3">
              <label for="district">Pilih Kecamatan</label> <br>
              <select id="basic_district" name="district" class="district selectpicker show-tick form-control" data-live-search="true">
                @foreach($district as $data)
                    @if(Auth::user()->district_id == $data->district_id)
                      <option value="{{ $data->district_id }}" selected >{{ $data->district_name }}</option>
                    @else
                      <option value="{{$data->district_id}}" id="{{$data->district_id}}">{{ $data->district_name}}</option>
                    @endif
                @endforeach
              </select>
                @if ($errors->has('kecamatan'))
                    <span class="help-block">
                        <strong>Kecamatan harus diisi</strong>
                    </span>
                @endif
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
              <label for="address">Alamat Pengiriman</label> <br>
              <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" style="text-align:center; width: 100%;"/>

              @if ($errors->has('address'))
                <span class="help-block">
                    <strong style="color:#ff3333;">{{ $errors->first('address') }}</strong>
                </span>
              @endif

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
      $(".province").change(function()
      {
        $(".city").find('option').remove();
        $(".district").find('option').remove();
        var id=$(this).val();
        $.ajax
        ({
          type: "POST",
          url: "{{ URL::to('get_city')}}",
          data: {id: id},
          beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
          cache: false,
          success: function(html)
          {
            $("#basic_city").html(html)
            .selectpicker('refresh');

            $("#basic_district").html('<option selected="selected">-- Pilih Kecamatan --</option>')
            .selectpicker('refresh');
          } 
        });
      });


      $(".city").change(function()
      {
        var id=$(this).val();
        $.ajax
        ({
          type: "POST",
          url: "{{ URL::to('get_district')}}",
          data: {id: id},
          beforeSend: function(request){
            return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
          },
          cache: false,
          success: function(html)
          {
            $("#basic_district").html(html)
            .selectpicker('refresh');
          } 
        });
      });
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
      $('#total-cart').html((data.response.total + data.response.shipping_fee).toLocaleString());
      $('#shipping-fee').html(data.response.shipping_fee.toLocaleString());
      $('#cart-count').html(data.response.qty);
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
        $('#shipping-fee').html(data.response.shipping_fee.toLocaleString());
        $('#cart-count').html(data.response.qty);
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