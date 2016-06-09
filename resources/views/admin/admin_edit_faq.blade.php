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
    <div class="col-lg-12">
      <form class="form-horizontal" role="form" method="POST" action= {{ URL('admin/post/edit/faq')  . '/' . $query->question_id }} >
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
            <label class="col-md-1 control-label">Question</label>

            <div class="col-md-5">
                <textarea rows="3" class="form-control" placeholder="Question" name="question">{{ $query->question }}</textarea>

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
                <textarea rows="5" class="form-control" placeholder="Answer" name="answer" >{{ $query->answer }}</textarea>

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
                &nbsp; &nbsp;
                <a href="{{ URL::to('admin/faq/list') }}" class="btn btn-default">Cancel</a>                              
            </div>
        </div>
      </form>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@stop