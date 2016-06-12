@extends('layout.main_layout')

@section('content')
<div class="container">
	<h2>Customer Order</h2>
	@if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/register')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
      </div>
    @else
	<div class="row">
	<div class="col-md-12" style="padding-bottom: 50px;">
		<table id="customerDatatable" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
          <thead>
	        </thead>
	        <tbody>
	        </tbody>
	        <tfoot>
	        </tfoot>
        </table>
	</div>
	<!-- Modal -->
    <div id="productDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color:black;">Product Detail</h4>
          </div>
          <div class="modal-body" style="color:black;">
            <div id="name" style="min-height:30px; width:80px; float:left;"></div>
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px; float:left;"></div>
            <div id="price" style="min-height:30px; width:150px; margin-left:240px;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
	</div>
	@endif
</div>

@push('scripts')
<script>
  // $(document).ready(function() {
  //     $('table.display').DataTable( {
  //       "autoWidth": false
  //     } );
  // } );
  $('#customerDatatable tbody').on( 'click', '.detail', function () {
	    var id = $(this).data('id');
	    
	    $.ajax({
	      type: "POST",
	      url: "{{ URL::to('/dataorderproduct') }}",
	      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
	      success:
	      function(data)
	      {
	        if(data != 0)
	        {
	          var obj = JSON.parse(data);
	          var name = "";
	          var qty = "";
	          var price = "";
	          var total = 0;
	          for(var i=0; i<obj.length; i++)
	          {
	            name += (obj[i].name + "<br>") ;
	            qty += ("x" + obj[i].quantity + "<br>") ;
	            price += ("@Rp" + obj[i].price + "<br>");

	            total += obj[i].price;
	          }
	          price += ("<hr style='border-color:black;'> Total : Rp" + total);
	          $(".modal-body #name").html(name);
	          $(".modal-body #qty").html(qty);
	          $(".modal-body #price").html(price);
	        }
	      }
	    });
	    $("#productDetail").modal();
	}); 

  function sending (id)
	{
	  $.ajax({
	  	url: '{{URL("/sending")}}',
	  	type: 'POST',
	  	data: {id: id},
	  	beforeSend: function(request){
        return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
      	},
	  })
	  .success(function(data)
	  {
	  	$("#"+id+"sending").prop("disabled", true);
	  	$("#"+id+"sending").text("Sent");
	  	$("#"+id+"sending").css("background-color", "red");
	  })
	  .fail(function(){
	  	alert('error');
	  })
	}

  $(function() {
    var table = $('#customerDatatable').DataTable({
        processing: true,
        serverSide: true,
        bFilter : false,
        ajax: {
            url: '{!! route('customerorderlist.data') !!}',
        },
        dom: 'Bfrtip',
        columns: [
            { data: 'order_id', name: 'order_id', title:'Order Id' },
            { data: 'customer', name: 'customer', title:'Customer' },
            { data: 'order_date', name: 'order_date', title:'Order Date', sType: 'date' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'ship_address', name: 'ship_address', title:'Ship Address' },
            { data: 'city_name', name: 'city_name', title:'City' },            
            { data: 'who', name: 'who', title:'Type' },
            { data: 'status_confirmed', name: 'status_confirmed', title:'Confirmed Status' },
            {className: "dt-center", width:"10%", name: 'actions', render: function(data, type, row) {

            if(row.status_shipping == 0){

              return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +'<button class="btn btn-warning" id="'+ row.order_id +'sending" onclick="sending(' + row.order_id + ')" >' + 'Send' + '</button>';
            }
            else
            {
            	return '<button type="button" class="btn btn-info detail" data-id="' + row.order_id + '" data-toggle="modal" data-target="#sampleDetail">Detail</button>' + '<br><br>' +'<button disabled class="btn btn-warning" style="background-color:red" id="'+ row.order_id +'sending" onclick="sending(' + row.order_id + ')" >' + 'Sent' + '</button>';
            } 
            }
        }

        ],
    });
  });

</script>
@endpush
@stop
