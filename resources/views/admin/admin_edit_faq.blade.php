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
    @if(Session::has('delete'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been deleted!</strong>
    </div>
    @elseif(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/faq')  . '/' . $query->question_id }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <div class="box box-info">
                <div class="box-header">
                  <b><h3 class="box-title">Question</h3></b>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
              <div class="box-body pad">
                  <textarea id="editor1" placeholder="Question" name="question" rows="10" cols="80">
                    {{$query->question}}
                  </textarea>

                  @if ($errors->has('question'))
                  <span class="help-block">
                      <strong>{{ $errors->first('question') }}</strong>
                  </span>
                  @endif
              </div>
            </div><!-- /.box -->
          </div>
        </div>

        <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
          <div class="col-md-10">
              <div class="box box-info">
                <div class="box-header">
                  <b><h3 class="box-title">Answer</h3></b>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
              <div class="box-body pad">
                  <textarea id="editor2" placeholder="Answer" name="answer" rows="10" cols="80">
                    {{$query->answer}}
                  </textarea>

                  @if ($errors->has('answer'))
                  <span class="help-block">
                      <strong>{{ $errors->first('answer') }}</strong>
                  </span>
                  @endif
              </div>
            </div><!-- /.box -->
          </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit</button> 
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/faq/list') }}" class="btn btn-default">Cancel</a>                              
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->
@push('scripts')
<script src="{{ URL::asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
@endpush
@stop