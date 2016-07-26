@extends('layout.main_layout')

@section('content')
<div class="container">
  <br>
	<h2>Pesanan Pelanggan</h2>
	@if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/register')}} class="testimonial_custom">  Silahkan masuk terlebih dahulu atau klik link ini untuk mendaftar </a>
      </div>
    @else

    <div class="row">
   
    <div class="col-lg-12">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#" onclick="current()" aria-controls="home" role="tab" data-toggle="tab"> Pesanan Sekarang </a></li>
        <li role="presentation"><a href="#" onclick="history()" aria-controls="profile" role="tab" data-toggle="tab"> Riwayat Pesanan </a></li>
      </ul>
    </div>

    <div class="col-lg-12">
      <br><br>
      <div id="table">
      </div>
    </div>
  </div><!-- /.row -->

	<!-- <div class="row">
	<div class="col-md-12" style="padding-bottom: 50px;">
		<table id="customerDatatable" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
          <thead>
	        </thead>
	        <tbody>
	        </tbody>
	        <tfoot>
	        </tfoot>
        </table>
	</div> -->
	<!-- Modal -->
    <div id="productDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color:black;">Detail Produk</h4>
          </div>
          <div class="modal-body" style="color:black;">
            <div class="col-md-4 col-xs-5">
            <div id="name"></div>
            </div>
            <div class="col-md-3 col-xs-2">
            <div id="qty"></div>
            </div>
            <div class="col-md-4 col-xs-5">
            <div id="price"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>

      </div>
    </div>
	</div>
	@endif
</div>

@push('scripts')
<script>
function current()
  {
    $.ajax({
      type: "GET",
      url: "{{ URL::to('agent/current/order') }}",
      success:
      function(data)
      {
        $('#table').html(data);
      }
    });
  }

function history()
{
  $.ajax({
    type: "GET",
    url: "{{ URL::to('agent/history/order') }}",
    success:
    function(data)
    {
      $('#table').html(data);
    }
  });
}

$(document).ready()
{
  current();
}
  

</script>
@endpush
@stop
