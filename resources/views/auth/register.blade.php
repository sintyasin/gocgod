@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Buat Akun Baru</h2>
        <div class="row">

            <div class="col-md-12">

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
                @endif
                
            <div class="panel panel-default">
                <div class="panel-heading"><div class="font_padding"> Daftar Akun! </div></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nama</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">

                                @if ($errors->has('nama'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="Province">Provinsi</label>

                            <div class="col-md-6">
                                <select id="basic" name="provinsi" class="province selectpicker show-tick form-control" data-live-search="true">
                                  <option selected="selected">-- Pilih Provinsi --</option>
                                  @foreach($province as $data)
                                  <option value="{{$data->province_id}}" id="{{$data->province_id}}">{{ $data->province_name}}</option>
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

                            <div class="col-md-6">
                                <select id="basic_city" name="kota" class="city selectpicker show-tick form-control" data-live-search="true">
                                  <option selected="selected">-- Pilih Kota --</option>
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

                            <div class="col-md-6">
                                <select id="basic_district" name="kecamatan" class="district selectpicker show-tick form-control" data-live-search="true">
                                  <option selected="selected">-- Pilih Kecamatan --</option>
                                </select>


                                @if ($errors->has('kecamatan'))
                                    <span class="help-block">
                                        <strong>Kecamatan harus diisi</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Alamat</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control"  name="alamat" value="{{ old('alamat') }}">

                                @if ($errors->has('alamat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('kodepos') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Kode Pos</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="kodepos" value="{{ old('kodepos') }}" onkeypress="return isNumber(event)">

                                @if ($errors->has('kodepos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kodepos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ ($errors->has('hari') || $errors->has('bulan') || $errors->has('tahun')) ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Tanggal Lahir</label>

                            <div class="col-md-1">
                                <input type="text" class="form-control" maxlength="2" minlength="2" placeholder="dd" name="hari" value="{{ old('hari') }}" onkeypress="return isNumber(event)">
                                @if ($errors->has('hari'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hari') }}</strong>
                                    </span>
                                @elseif (Session::has('hari'))
                                    <span class="help-block">
                                      <strong>{{ Session::get('hari') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <select name="bulan" class='form-control'>
                                  <option value='01' style="color:black;">Januari</option>
                                  <option value='02' style="color:black;">Februari</option>
                                  <option value='03' style="color:black;">Maret</option>
                                  <option value='04' style="color:black;">April</option>
                                  <option value='05' style="color:black;">Mei</option>
                                  <option value='06' style="color:black;">Juni</option>
                                  <option value='07' style="color:black;">Juli</option>
                                  <option value='08' style="color:black;">Agustus</option>
                                  <option value='09' style="color:black;">September</option>
                                  <option value='10' style="color:black;">Oktober</option>
                                  <option value='11' style="color:black;">November</option>
                                  <option value='12' style="color:black;">Desember</option>
                                </select> 
                                @if ($errors->has('bulan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bulan') }}</strong>
                                    </span>
                                 @elseif (Session::has('bulan'))
                                    <span class="help-block">
                                      <strong>{{ Session::get('bulan') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <input type="text" class="form-control" maxlength="4" minlength="4" placeholder="yyyy" name="tahun" value="{{ old('tahun') }}" onkeypress="return isNumber(event)">
                                @if ($errors->has('tahun'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tahun') }}</strong>
                                    </span>
                                @elseif (Session::has('tahun'))
                                    <span class="help-block">
                                      <strong>{{ Session::get('tahun') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name='dob' class="form-control" id="datepicker"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div> -->
                        </div>

                        <div class="form-group{{ $errors->has('telepon') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Telepon</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="telepon" value="{{ old('telepon') }}" onkeypress="return isNumber(event)">

                                @if ($errors->has('telepon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telepon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Alamat Email</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="gocgod@gocgod.com" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('passwords') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="passwords">

                                @if ($errors->has('passwords'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('passwords') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('passwords_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Konfirmasi Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="passwords_confirmation">

                                @if ($errors->has('passwords_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('passwords_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="checkPageBtn">
                                    <i class="fa fa-btn fa-user"></i> DAFTAR
                                </button>
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
<script type="text/javascript">
    $(document).ready(function() {
      $(".province").change(function()
      {
        var id=$(this).val();
        $(".city").find('option').remove();
        $(".district").find('option').remove();
        $.ajax
        ({
          type: "POST",
          url: "{{ URL::to('city')}}",
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
          url: "{{ URL::to('district')}}",
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(function() {
        var date = $('#datepicker').datepicker({ 
            dateFormat: 'yy-mm-dd',
            maxDate: new Date
        }).val();

        $( "#datepicker" ).datepicker();
    });
  
    function check() {
        var e = document.getElementById('city');
        if (e.options[e.selectedIndex].value == 0) {
            document.getElementById('newcity').style.display = 'block';
        }
        else document.getElementById('newcity').style.display = 'none';
    }
</script>
@endpush
@endsection
