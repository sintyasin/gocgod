@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Category
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Category</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('adminpostcategory') . '/' . $query->category_id }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Category Name</label>

            <div class="col-md-5">
                <input disabled type="text" class="form-control" placeholder="Category Name" name="name" value="{{ $query->category_name }}" />

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Description</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Description" name="description" value="{{ $query->description }}" />

                @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                &nbsp; &nbsp;
                <a href="{{ URL::to('admincategorylist', array('status' => 'new')) }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@stop