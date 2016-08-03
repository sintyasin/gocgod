@extends('layout.admin_profile_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Profile
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Profile</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @elseif(Session::has('password'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Password updated successfully!</strong>
    </div>
    @endif

    <div class="col-lg-6">
        <div class="col-md-12">
            <h2 class="text-center">Personal Information</h2>
        </div>

      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/profile') }} >
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-2 control-label">Name</label>

            <div class="col-md-8">
                <input type="text" class="form-control" value="{{ $query->name }}" disabled/>
            </div>
        </div>

        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Date Of Birth</label>

            <div class="col-md-8">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' name="dob" class="datepicker form-control" value="{{ $query->date_of_birth }}"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>

                @if ($errors->has('dob'))
                <span class="help-block">
                    <strong>{{ $errors->first('dob') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label" for="Province">Provinsi</label>

            <div class="col-md-8">
                <select id="basic" name="provinsi" class="province selectpicker show-tick form-control" data-live-search="true">
                  @foreach($province as $data)
                      @if(auth('admin')->user()->province_id == $data->province_id)
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
            <label class="col-md-2 control-label" for="city">Kota</label>

            <div class="col-md-8">
                <select id="basic_city" name="kota" class="city selectpicker show-tick form-control" data-live-search="true">
                  <option value="{{$city->city_id}}" selected="selected">{{$city->city_name}}</option>
                </select>


                @if ($errors->has('kota'))
                    <span class="help-block">
                        <strong>Kota harus diisi</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('kecamatan') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label" for="district">Kecamatan</label>

            <div class="col-md-8">
                <select id="basic_district" name="kecamatan" class="district selectpicker show-tick form-control" data-live-search="true">
                  <option value="{{$district->district_id}}" selected="selected">{{$district->district_name}}</option>
                </select>


                @if ($errors->has('kecamatan'))
                    <span class="help-block">
                        <strong>Kecamatan harus diisi</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Address</label>

            <div class="col-md-8">
                <textarea class="form-control" name="address" rows="3">{{ $query->address }}</textarea>

                @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Phone</label>

            <div class="col-md-8">
                <input type="text" class="form-control" name="phone" value="{{ $query->phone }}">

                @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Email</label>

            <div class="col-md-8">
                <input type="email" class="form-control" name="email" value="{{ $query->email }}">

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4">
                <button type="submit" class="btn btn-primary">Submit</button>     
                &nbsp; &nbsp;
                <a href={{ URL('admin/product/list') }} class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>

    <div class="col-lg-6">

        <div class="col-md-12">
            <h2 class="text-center">Change my password</h2>
        </div>

        {!! Form::open(array('url' => 'admin/change/password', 'method' => 'post', 'class' => 'form-horizontal')) !!}
            

            <div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Current Password</label>

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
                <label class="col-md-2 control-label">New Password</label>

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
                <label class="col-md-2 control-label">Confirm New Password</label>

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
                <div class="col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Submit</button>     
                    &nbsp; &nbsp;
                    <a href={{ URL('admin/product/list') }} class="btn btn-default">Cancel</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@push('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
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

  var date = $('.datepicker').datepicker({ 
    dateFormat: 'yy-mm-dd',
    maxDate: new Date
    }).val();

    $( ".datepicker" ).datepicker();
});
</script>
@endpush
@stop

