@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Insert FAQ
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Insert FAQ</li>
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
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/faq') }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Question</label>

            <div class="col-md-5">
                <textarea rows="3" class="form-control" placeholder="Question" name="question">{{ old('question') }}</textarea>

                @if ($errors->has('question'))
                <span class="help-block">
                    <strong>{{ $errors->first('question') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Answer</label>

            <div class="col-md-5">
                <textarea rows="5" class="form-control" placeholder="Answer" name="answer" >{{ old('answer') }}</textarea>

                @if ($errors->has('answer'))
                <span class="help-block">
                    <strong>{{ $errors->first('answer') }}</strong>
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