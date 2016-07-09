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
                                <input type="text" class="form-control" name="kodepos" value="{{ old('kodepos') }}">

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
                                <input type="text" class="form-control" placeholder="dd" name="hari" value="{{ old('hari') }}">
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
                                <input type="text" class="form-control" placeholder="yyyy" name="tahun" value="{{ old('tahun') }}">
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
                                <input type="text" class="form-control" name="telepon" value="{{ old('telepon') }}">

                                @if ($errors->has('telepon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telepon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

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

                        <div class="form-group{{ $errors->has('kota') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Kota</label>

                            <div class="col-md-6">
                                <select onclick="javascript:check();" class='form-control' id="city" name='kota'>
                                @foreach($city as $data)
                                    <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                                @endforeach
                                  <option value="0">Kota Baru</option>
                              </select>
                              <div id="newcity" style="display:none;">
                                <br>
                                <input type='text' class="form-control" placeholder="Nama kota" name="kotabaru" >
                              </div>
                              @if ($errors->has('kota'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('kota') }}</strong>
                              </span>
                              @endif
                              @if ($errors->has('kotabaru'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('kotabaru') }}</strong>
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
