@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Bank
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Bank</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/bank') . '/' . $query->bank_id }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Bank Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Bank Name" name="bank" value="{{ $query->bank_name }}" />

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
                &nbsp; &nbsp;
                <a href={{ URL('admin/bank/list') }} class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@stop