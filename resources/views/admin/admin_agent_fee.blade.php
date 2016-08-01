@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Agent Fee
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Agent Fee</li>
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
    @endif
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/agent/fee') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('fee') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Fee (in %)</label>

            <div class="col-md-5">
                <input type="number" min="1" max="100" class="form-control" name="fee" value="{{ $query->fee }}" onkeypress="return isNumber(event)"/>

                @if ($errors->has('fee'))
                <span class="help-block">
                    <strong>{{ $errors->first('fee') }}</strong>
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
<script type="text/javascript">
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
@endpush
@stop

