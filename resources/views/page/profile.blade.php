@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
  <div class="container">
    <h2>Informasi Akun</h2>

    @if (session('error'))
     <div class="alert alert-danger fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>{{ session('error') }}</strong>
    </div>
    @elseif(session('success'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <div class="col-md-3">
      
      @if(Auth::user()->status_user == 0)
      <center>
      <button type="button" role="presentation" class="boaBtn_boa_pf" onclick="data()">
        Informasi Akun
      </button>
      </center>
      @endif

      <!-- Button trigger modal -->
      <center>
      <button type="button" class="boaBtn_boa_pf" data-toggle="modal" data-target="#myModal">
        Ubah Informasi
      </button>
      </center>

      <!-- Modal Ubah Informasi-->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal_header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Ubah Informasi
            </div>
            <div class="modal-body">
              
              <form class="form-horizontal" role="form" method="POST" action= {{ URL('edit_profile') }} >
                {!! csrf_field() !!}

                <div class="form-group">
                  <label class="col-md-4 control-label">Nama</label>

                  <div class="col-md-8">
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled/>
                  </div>
                </div>

                <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Tanggal Lahir</label>

                  <div class="col-md-8">
                    <div class='input-group date' id='datetimepicker1'>
                      <input type='text' name="dob" class="datepicker form-control" value="{{ Auth::user()->date_of_birth }}" disabled/>
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="Province">Provinsi</label>

                    <div class="col-md-8">
                        <select id="basic" name="provinsi" class="province selectpicker show-tick form-control" data-live-search="true">
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
                </div>

                <div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="city">Kota</label>

                    <div class="col-md-8">
                        <select id="basic_city" name="kota" class="city selectpicker show-tick form-control" data-live-search="true">
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
                </div>

                <div class="form-group{{ $errors->has('kecamatan') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="district">Kecamatan</label>

                    <div class="col-md-8">
                        <select id="basic_district" name="kecamatan" class="district selectpicker show-tick form-control" data-live-search="true">
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
                </div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Alamat</label>

                  <div class="col-md-8">
                    <textarea class="form-control" name="address" rows="3">{{ Auth::user()->address }}</textarea>

                    @if ($errors->has('address'))
                    <span class="help-block">
                      <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Kode Pos</label>

                  <div class="col-md-8">
                    <input type="text" class="form-control" name="zipcode" value="{{ Auth::user()->zipcode }}" onkeypress="return isNumber(event)">

                    @if ($errors->has('address'))
                    <span class="help-zipcode">
                      <strong>{{ $errors->first('zipcode') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Telepon</label>

                  <div class="col-md-8">
                    <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}" onkeypress="return isNumber(event)">

                    @if ($errors->has('phone'))
                    <span class="help-block">
                      <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Email</label>

                  <div class="col-md-8">
                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">

                    @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                  <Center>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>     
                    &nbsp; &nbsp;
                    <a href={{ URL('profile/') }} class="btn btn-default">Cancel</a>
                  </Center>
                  </div>
                </div>
              </form>


            </div>
          </div>
        </div>
      </div>


      <!-- Button trigger modal -->
      <center>
      <button type="button" class="boaBtn_boa_pf" data-toggle="modal" data-target="#myPassword">
        Ubah Password
      </button>
      </center>

      <!-- Modal Ubah Password-->
      <div class="modal fade" id="myPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal_header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Ubah Password
            </div>
            <div class="modal-body">
              
              {!! Form::open(array('url' => 'edit_password', 'method' => 'post', 'class' => 'form-horizontal')) !!}
              

              <div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Password Awal</label>

                <div class="col-md-8">
                  <input type='password' name="pass" class="form-control"/>

                  @if ($errors->has('pass'))
                  <span class="help-block">
                    <strong>{{ $errors->first('pass') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Password Baru</label>

                <div class="col-md-8">
                  <input type='password' name="newpassword" class="form-control"/>

                  @if ($errors->has('newpassword'))
                  <span class="help-block">
                    <strong>{{ $errors->first('newpassword') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('newpassword_confirmation') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Konfirmasi Password Baru</label>

                <div class="col-md-8">
                  <input type='password' name="newpassword_confirmation" class="form-control"/>

                  @if ($errors->has('newpassword_confirmation'))
                  <span class="help-block">
                    <strong>{{ $errors->first('newpassword_confirmation') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                <center>
                  <button type="submit" class="btn btn-primary">SUBMIT</button>     
                  &nbsp; &nbsp;
                  <a href={{ URL('profile/') }} class="btn btn-default">Cancel</a>
                </center>
                </div>

              </div>
              {!! Form::close() !!}

            </div>
          </div>
        </div>
      </div>

      @if(Auth::user()->status_user == 0)
      <Center>
      <button type="button" role="presentation" class="boaBtn_boa_pf" onclick="dataagent()">
        Informasi Agent
      </button>
      </Center>

      

      <Center>
      <button type="button" data-toggle="modal" data-target="#bankinformation" class="boaBtn_boa_pf">
        Ubah Informasi Bank
      </button>
      </Center>

      <!-- Modal Ubah Informasi Bank-->
      <div class="modal fade" id="bankinformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal_header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Ubah Informasi Bank
            </div>
            <div class="modal-body">
              
              <form class="form-horizontal" role="form" method="POST" action="{{ url('change_bank') }}">
                {!! csrf_field() !!}

                <input type="hidden" value="0" name = "userType">                        

                <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Bank </label>

                  <div class="col-md-6">
                    <select class="form-control" name="bank" >

                      @foreach($bank as $data)
                      @if(Auth::user()->bank_id == $data->bank_id)
                      <option value="{{ $data->bank_id }}">{{ $data->bank_name }}</option>
                      @else
                      <option value="{{ $data->bank_id }}">{{ $data->bank_name }}</option>
                      @endif
                      @endforeach
                    </select>
                    @if ($errors->has('bank'))
                    <span class="help-block">
                      <strong>{{ $errors->first('bank') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Nomor rekening</label>

                  <div class="col-md-6">
                    <input type="text" class="form-control" value="{{Auth::user()->bank_account}}" name="bank_account" onkeypress="return isNumber(event)">

                    @if ($errors->has('bank_account'))
                    <span class="help-block">
                      <strong>{{ $errors->first('bank_account') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                  <center>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>     
                    &nbsp; &nbsp;
                    <a href={{ URL('profile') }} class="btn btn-default">Cancel</a>
                  </center>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

      <center>
      <button type="button" class="boaBtn_boa_pf" role="presentation" onclick="balance()">
        Total Uang
      </button>
      </center>
      @endif
    </div>

    <div id="profile">	
    </div>

    <!-- Modal Withdraw money / penarikan uang-->
    <div class="modal fade" id="withdrawMoney" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal_header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Penarikan Uang
          </div>
          <div class="modal-body">
            
            <form class="form-horizontal" role="form" method="POST" action="{{ url('withdrawMoney')}}">
              {!! csrf_field() !!}

              <div class="form-group">
                <center>
                  <div class="col-md-12">
                    <label class="control-label" style="padding-bottom: 30px;"><b>TOTAL UANG: Rp {{number_format(Auth::user()->balance, 0, ',', '.')}}</b>
                    </label>
                  </div>
                  <div class="col-md-12">
                    <label class="control-label" style="padding-bottom: 10px;">Berapa jumlah uang yang ingin ditarik?
                    </label>
                  </div>
                  <div class="col-md-12">
                    <input type="text" class="form-control" style="width:50%" name="money" onkeypress="return isNumber(event)">
                  </div>
                </center>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                <center>
                  <button type="submit" class="btn btn-primary">SUBMIT</button>     
                  &nbsp; &nbsp;
                  <a href={{ URL('profile/') }} class="btn btn-default">Cancel</a>
                </center>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>


<div class="modal fade" id="agentDay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal_header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Ubah Hari
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" role="form" method="POST" action="{{ url('change_agentday') }}">
          {!! csrf_field() !!}     

          <div class="form-group{{ $errors->has('hari') ? ' has-error' : '' }}">
              <label class="col-md-4 control-label">Hari</label>
              <div class="col-md-6">
                  <select class="selectpicker form-control" id="day" name="hari[]"  multiple title="-- Pilih hari --">
                    <option value="1">Senin</option>
                    <option value="2">Selasa</option>
                    <option value="3">Rabu</option>
                    <option value="4">Kamis</option>
                    <option value="5">Jumat</option>
                    <option value="6">Sabtu</option>
                    <option value="7">Minggu</option>
                </select>

                @if ($errors->has('hari'))
                <span class="help-block">
                  <strong>Hari harus diisi</strong>
              </span>
              @endif
              </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
            <center>
              <button type="submit" class="btn btn-primary">SUBMIT</button>     
              &nbsp; &nbsp;
              <a href={{ URL('profile') }} class="btn btn-default">Cancel</a>
            </center>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="agentOrigin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal_header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Ubah Jangkauan
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" role="form" method="POST" action="{{ url('change_agentorigin') }}">
          {!! csrf_field() !!}     

    <?php $i=0; ?>
    <div class="input_fields_wrap">

        <center>
          <button class="add_field_button" style="width: 150px; min-height: 40px; border-radius: 5px; color:black;">Tambah Alamat</button>
        </center>

        @foreach($origin as $daerah)
        <div class="col-md-12">
        <div class="form-group">
            <br>
            <label class="col-md-4 control-label">Provinsi</label>
            <div class="col-md-6">
                <select id="{{$i}}-basic" name="{{$i}}-provinsi" data-id="{{$i}}" class="province selectpicker show-tick form-control" data-live-search="true" onchange="provinsi({{$i}})">
                    <option selected="selected" value="{{$daerah->province_id}}">{{$daerah->province_name}}</option>
                    @foreach($province_check as $data)
                    <option value="{{$data->province_id}}" id="{{$data->province_id}}">{{ $data->province_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label">Kota</label>
            <div class="col-md-6">
                <select id="{{$i}}-basic_city" name="{{$i}}-kota" data-id="{{$i}}" class="city selectpicker show-tick form-control" data-live-search="true" onchange="city({{$i}})">
                    <option selected="selected" value="{{$daerah->city_id}}">{{$daerah->city_name}}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Kecamatan</label>
            <div class="col-md-6">
                <select id="{{$i}}-basic_district" name="{{$i}}-kecamatan" data-id="{{$i}}" class="district selectpicker show-tick form-control" data-live-search="true">
                    <option selected="selected" value="{{$daerah->district_id}}">{{$daerah->district_name}}</option>
                </select>
            </div>

            @if($i > 0)
            <div class="col-md-2">
                <a href="#" class="remove_first" sytle="margin-top:15px; float:right;"> Remove </a>
            </div>
            @endif

        </div>
        <?php $i++ ?>
        </div>     
    
    @endforeach
    </div>
          <div class="form-group">
            <div class="col-md-12">
            <center>
              <button type="submit" class="btn btn-primary">SUBMIT</button>     
              &nbsp; &nbsp;
              <a href={{ URL('profile') }} class="btn btn-default">Cancel</a>
            </center>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

</div>

@push('scripts')
<script>

  $(document).ready(function(){
    data();
    init_multifield('.input_fields_wrap', '.add_field_button');

    var max_fields = 20;  //maximum input boxes allowed
    var x = <?php echo $i; ?>+1; //initlal text box count
    function init_multifield(wrap, butt) {
        var wrapper = $(wrap); //Fields wrapper
        var add_button = $(butt); //Add button class
        
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                var provinsi= '<div class="form-group"><br><label class="col-md-4 control-label">Provinsi</label><div class="col-md-6"><select style="display:block !important;" id="'+(x-1)+'-basic" name="'+(x-1)+'-provinsi" data-id="'+(x-1)+'" class="province selectpicker show-tick form-control" data-live-search="true" onchange="provinsi(' + (x-1) + ')"><option selected="selected">-- Pilih Provinsi --</option>   @foreach($province_check as $data)<option value="{{$data->province_id}}" id="{{$data->province_id}}">{{ $data->province_name}}</option>@endforeach</select></div></div>';

                var kota= '<div class="form-group"><label class="col-md-4 control-label">Kota</label><div class="col-md-6"><select style="display:block !important;" id="'+(x-1)+'-basic_city" name="'+(x-1)+'-kota" data-id="'+(x-1)+'" class="city selectpicker show-tick form-control" data-live-search="true" onchange="city('+(x-1)+')"><option selected="selected">-- Pilih Kota --</option></select></div></div>';

                var kecamatan= '<div class="form-group"><label class="col-md-4 control-label">Kecamatan</label><div class="col-md-6"><select style="display:block !important;" id="'+(x-1)+'-basic_district" name="'+(x-1)+'-kecamatan" data-id="'+(x-1)+'" class="district selectpicker show-tick form-control" data-live-search="true"><option selected="selected">-- Pilih Kecamatan --</option></select></div><div class="col-md-2"><a href="#" class="remove_field" style="margin-top:15px; float:right;">Remove</a></div></div>';

                $(wrapper).append('<div class="col-md-12">' + provinsi + kota + kecamatan  +'</div>');

                $("#"+(x-1)+"-basic").selectpicker('refresh');
                $("#"+(x-1)+"-basic_city").selectpicker('refresh');
                $("#"+(x-1)+"-basic_district").selectpicker('refresh');
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove();
        })

        $('.remove_first').click(function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove();
        })
    }
  });

  function provinsi(no)
  {
      var id = $('select[name=' + no + '-provinsi]').val();
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
          $("#"+no+"-basic_city").html(html)
          .selectpicker('refresh');

          $("#"+no+"-basic_district").html('<option selected="selected">-- Pilih Kecamatan --</option>')
          .selectpicker('refresh');
      } 
      })
  }

  function city(no)
  {
      var id = $('select[name=' + no + '-kota]').val();
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
          $("#"+no+"-basic_district").html(html)
          .selectpicker('refresh');
      } 
      });
  };

  function balance()
   {
    $.ajax({
      type: "GET",
      url: "{{ URL::to('table_total')}}",
      success:
      function(data)
      {
        $('#profile').html(data);
      }
    });
   }

   function data()
   {
    $.ajax({
      type: "GET",
      url: "{{ URL::to('data_profile')}}",
      success:
      function(data)
      {
        $('#profile').html(data);
      }
    });
   }

   function dataagent()
   {
    $.ajax({
      type: "GET",
      url: "{{ URL::to('data_agent')}}",
      success:
      function(data)
      {
        $('#profile').html(data);
      }
    });
   }



  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }

  function check() {
    var e = document.getElementById('city');
    if (e.options[e.selectedIndex].value == 0) {
      document.getElementById('newcity').style.display = 'block';
    }
    else document.getElementById('newcity').style.display = 'none';
  }
</script>
@endpush
@stop
