@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add New Admin
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Add New Admin</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('success'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>New admin has been added successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/add/admin') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" />

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Date Of Birth</label>

            <div class="col-md-5">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' name="dob" placeholder="Date Of Birth" class="datepicker form-control" value="{{ old('dob') }}"/>
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

        <div class="form-group{{ $errors->has('city') || $errors->first('newcity') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">City</label>

            <div class="col-md-5">
                <select onclick="javascript:check();" class="form-control" id="city" name="city" >
                  @foreach($city as $data)
                      <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                  @endforeach
                    <option value="0">New City</option>
                </select>
                <div id="newcity" style="display:none;">
                  <br>
                  <input type='text' class="form-control" placeholder="New city name" name="newcity" >
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
            <label class="col-md-1 control-label">Address</label>

            <div class="col-md-5">
                <textarea class="form-control" placeholder="Address" name="address" rows="3">{{ old('address') }}</textarea>

                @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Phone</label>

            <div class="col-md-5">
                <input type="text" placeholder="Phone Number" class="form-control" name="phone" value="{{ old('phone') }}">

                @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Email</label>

            <div class="col-md-5">
                <input type="email" placeholder="email@email.com" class="form-control" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Password</label>

            <div class="col-md-5">
                <input type="password" placeholder="Password" class="form-control" name="password" >

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Confirmed Password</label>

            <div class="col-md-5">
                <input type="password" placeholder="Confirmed Password" class="form-control" name="password_confirmation" >

                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('super') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Admin Type</label>

            <div class="col-md-5">
                <select class="form-control" name="super" >
                    <option value="0" selected>Admin</option>
                    <option value="1">Super Admin</option>
                </select>
                @if ($errors->has('super'))
                <span class="help-block">
                    <strong>{{ $errors->first('super') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('info') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Admin Information</label>

            <div class="col-md-5">
                <textarea rows="4" placeholder="Admin Information" class="form-control" name="info" value="{{ old('info') }}"></textarea>

                @if ($errors->has('info'))
                <span class="help-block">
                    <strong>{{ $errors->first('info') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button>             
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@push('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
$(function() {
    var date = $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

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
@stop