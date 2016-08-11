@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Admin
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Admin</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/admin') . '/' . $query[0]->id }} >
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-1 control-label">Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" value="{{ $query[0]->name }}" disabled/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Phone</label>

            <div class="col-md-5">
                <input type="text" class="form-control" value="{{ $query[0]->phone }}" disabled/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-1 control-label">Email</label>

            <div class="col-md-5">
                <input type="text" class="form-control" value="{{ $query[0]->email }}" disabled/>
            </div>
        </div>

        <div class="form-group{{ $errors->has('super') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Admin Type</label>

            <div class="col-md-5">
                <select class="form-control" name="super" >
                    @if($query[0]->super == 0)
                        <option value="0" selected>Admin</option>
                        <option value="1">Super Admin</option>
                    @else
                        <option value="0">Admin</option>
                        <option value="1" selected>Super Admin</option>
                    @endif
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
                <textarea rows="4" class="form-control" name="info">{{ $query[0]->information }}</textarea>

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
                &nbsp; &nbsp;
                <a href={{URL('admin/list')}} class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@stop