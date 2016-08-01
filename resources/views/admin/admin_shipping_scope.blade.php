@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Scope of Shipping
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Scope of Shipping</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  
 <div class="row">
    <div class="col-lg-12">
      <div class="col-lg-12">
        <h4><b>Notes <br>
        Status: <br>
        0 (Belum Terjangkau) / 1 (Sudah Terjangkau) <br><br>
        </b></h4>
      </div>
    </div>
  </div>

  <div class="row">
   
    <div class="col-lg-12">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#" onclick="provinsi()" aria-controls="home" role="tab" data-toggle="tab">Provinsi</a></li>
        <li role="presentation"><a href="#" onclick="kota()" aria-controls="profile" role="tab" data-toggle="tab">Kabupaten / Kota</a></li>
        <li role="presentation"><a href="#" onclick="kecamatan()" aria-controls="messages" role="tab" data-toggle="tab">Kecamatan</a></li>
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
function provinsi()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/shipping/province') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

function kota()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/shipping/city') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

function kecamatan()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('/admin/shipping/district') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

$(document).ready()
{
  provinsi();
}
</script>
@endpush
@stop