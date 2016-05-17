@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Insert City
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Insert City</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if($status == "success")
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been insert successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('adminpostcity') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">City Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" />

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
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@stop