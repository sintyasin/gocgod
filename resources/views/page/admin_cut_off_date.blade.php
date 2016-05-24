@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Cut Off Date
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Cut Off Date</li>
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
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/cut/off/date') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Cut Off Date</label>

            <div class="col-md-5">
                <select name="date" class="form-control">
                    @for ($i = 1; $i <= 7; $i++)
                        @if($query->cut_off == $i)
                            <option value={{$i}} selected>{{$i}}</option>
                        @else
                            <option value={{$i}}>{{$i}}</option>
                        @endif
                    @endfor
                </select>

                @if ($errors->has('date'))
                <span class="help-block">
                    <strong>{{ $errors->first('date') }}</strong>
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