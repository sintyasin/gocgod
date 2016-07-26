@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
  <div class="container">
    <h2>Informasi Akun</h2>

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

      <!-- Modal -->
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

                <div class="form-group{{ $errors->has('city') || $errors->first('newcity') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Kota</label>

                  <div class="col-md-8">
                    <select onclick="javascript:check();" class="form-control" id="city" name="city" >
                      @foreach($city as $data)
                      @if(Auth::user()->city_id == $data->city_id)
                      <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                      @else
                      <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                      @endif
                      @endforeach
                      <option value="0">Kota Baru</option>
                    </select>
                    <div id="newcity" style="display:none;">
                      <br>
                      <input type='text' class="form-control" name="newcity" >
                    </div>
                    @if ($errors->has('city'))
                    <span class="help-block">
                      <strong>{{ $errors->first('city') }}</strong>
                    </span>
                    @endif
                    @if ($errors->has('newcity'))
                    <span class="help-block">
                      <strong>{{ $errors->first('newcity') }}</strong>
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

      <!-- Modal -->
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
      <button type="button" data-toggle="modal" data-target="#bankinformation" class="boaBtn_boa_pf">
        Ubah Informasi Bank
      </button>
      </Center>

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
</div>

@push('scripts')
<script>

  $(document).ready(function(){
    data();
  });

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
