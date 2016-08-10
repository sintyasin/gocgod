@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Insert Banner
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Insert Banner</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('insert'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been insert successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action= {{ URL('admin/post/insert/banner') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Product Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Product Name" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Product Alias</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Product Alias" name="alias" value="{{ old('alias') }}">

                @if ($errors->has('alias'))
                <span class="help-block">
                    <strong>{{ $errors->first('alias') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('desc1') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Description 1</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Description 1" name="desc1" value="{{ old('desc1') }}">

                @if ($errors->has('desc1'))
                <span class="help-block">
                    <strong>{{ $errors->first('desc1') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('desc2') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Description 2</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Description 2" name="desc2" value="{{ old('desc2') }}">

                @if ($errors->has('desc2'))
                <span class="help-block">
                    <strong>{{ $errors->first('desc2') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Price</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Price" name="price" value="{{ old('price') }}">

                @if ($errors->has('price'))
                <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Picture</label>

            <div class="col-md-5">
                <input type="file" id="picture" name="picture" value="{{ old('picture') }}">
                @if (Session::has('errorSize'))
                  <span class="help-block">
                      <strong style="color:red">{{ Session::get('errorSize') }}</strong>
                  </span>
                @endif
                @if ($errors->has('picture'))
                <span class="help-block">
                    <strong>{{ $errors->first('picture') }}</strong>
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