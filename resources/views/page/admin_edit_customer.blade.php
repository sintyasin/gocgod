@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Customer
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Customer</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/customer')  . '/' . $query->id }} >
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-1 control-label">Name</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query->name}}" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Email</label>
            <div class="col-md-5">
              <input type="text" class='form-control' value="{{$query->email}}" disabled />
            </div>
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Status User</label>

            <div class="col-md-5">
            	<select class='form-control' id='status' name='status' value="{{ old('status') }}">
            	   @if($query->status_user == 0)
                       <option value='0' selected>Agent</option>
                       <option value='1'>Customer</option>
                    @else($query->status_user == 1)
                       <option value='0'>Agent</option>
                       <option value='1' selected>Customer</option>
                    @endif
            	</select>
                @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('verification') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Verification</label>

            <div class="col-md-5">
                <select class='form-control' id='verification' name='verification' value="{{ old('verification') }}">
                    @if($query->verification == 1)
                       <option value='0'>Unverified</option>
                       <option value='1'selected>Verified</option>
                    @else
                        <option value='0' selected>Unverified</option>
                        <option value='1'>Verified</option>
                    @endif
                </select>
                @if ($errors->has('verification'))
                <span class="help-block">
                    <strong>{{ $errors->first('verification') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button> 
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/customer/list') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@stop