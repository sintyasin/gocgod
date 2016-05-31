@extends('layout.main_layout')

@section('content')
<div class="container">
	<h2>Customer Order</h2>
	<div class="col-md-6" style="padding-bottom: 50px;">
	</div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
      $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );
</script>
@endpush
@stop
