@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Insert Product
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Insert Product</li>
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
      <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action= {{ URL('admin/post/product') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Name</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Product Name" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category') || $errors->first('newcategory') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Category</label>

            <div class="col-md-5">
                <select onclick="javascript:check();" class="form-control" id="category" name="category" value="{{ old('category') }}">
                  @foreach($query as $data)
                    <option value={{ $data->category_id }}>{{ $data->category_name }}</option>
                  @endforeach
                    <option value="0">New Category</option>
                </select>
                <div id="newcategory" style="display:none;">
                  <br>
                  <input type='text' class="form-control" placeholder="New Category Name" name="newcategory" >

                  <br>
                  <input type='text' class="form-control" placeholder="New Category Description" name="newcategorydesc" >
                </div>
                @if ($errors->has('category'))
                <span class="help-block">
                    <strong>{{ $errors->first('category') }}</strong>
                </span>
                @endif
                @if ($errors->has('newcategory'))
                <span class="help-block">
                    <strong>{{ $errors->first('newcategory') }}</strong>
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

        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Quantity</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Quantity" name="quantity" value="{{ old('quantity') }}">

                @if ($errors->has('quantity'))
                <span class="help-block">
                    <strong>{{ $errors->first('quantity') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Weight (kg)</label>

            <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Weight (kg)" name="weight" value="{{ old('weight') }}">

                @if ($errors->has('weight'))
                <span class="help-block">
                    <strong>{{ $errors->first('weight') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Description</label>

            <div class="col-md-5">
                <textarea class="form-control" placeholder="Description" name="description" rows="5"></textarea>

                @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
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

@push('scripts')
<script type="text/javascript">

function check() {
  var e = document.getElementById('category');
  if (e.options[e.selectedIndex].value == 0) {
      document.getElementById('newcategory').style.display = 'block';
  }
  else document.getElementById('newcategory').style.display = 'none';
}
</script>
@endpush
@stop