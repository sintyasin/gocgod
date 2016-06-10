@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Deposit Withdrawal
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Deposit Withdrawal</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="col-lg-12">
        <h4><b>Notes <br>
        Type: <br>
        0 (Withdraw) / 1 (Agent Fee) <br><br>

        Status Transfer:<br>
        0 (Not Yet) / 1 (Finish) <br> &nbsp;
        </b></h4>
      </div>
    </div>
  </div>

  <div class="row">
   
    <div class="col-lg-12">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#" onclick="alldata()" aria-controls="home" role="tab" data-toggle="tab">All Deposit</a></li>
        <li role="presentation"><a href="#" onclick="finish()" aria-controls="profile" role="tab" data-toggle="tab">Proccessed Deposit</a></li>
        <li role="presentation"><a href="#" onclick="unfinish()" aria-controls="messages" role="tab" data-toggle="tab">Unproccessed Deposit</a></li>
      </ul>
    </div>

    <div class="col-lg-12">
      <br><br>
      <div id="table">
      </div>
    </div>
  </div><!-- /.row -->

</section><!-- /.content -->
@push('scripts')
<script>
function unfinish()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/deposit/unfinish') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

function finish()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/deposit/finish') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

function alldata()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/deposit/all') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

$(document).ready()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/deposit/all') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}
</script>
@endpush
@stop