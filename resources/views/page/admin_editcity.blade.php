@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit City
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit City</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('adminposteditcity') . '/' . $query->city_id }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">City Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="City" name="city" value="{{ $query->city_name }}" />

                @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button>     
                &nbsp; &nbsp;
                <a href={{ URL('admincitylist/new') }} class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@stop