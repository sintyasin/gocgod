@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Insert Bank
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Insert Bank</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('success'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been insert successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/bank') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Bank Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Bank Name" name="bank" value="{{ old('bank') }}" />

                @if ($errors->has('bank'))
                <span class="help-block">
                    <strong>{{ $errors->first('bank') }}</strong>
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