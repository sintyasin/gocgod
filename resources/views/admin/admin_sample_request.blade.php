@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Sample Request
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Sample Request</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('reject'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Testimoni has been rejected successfully!</strong>
    </div>
    @elseif(Session::has('approve'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Testimoni has been approved successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><input name="select_all" value="1" type="checkbox" /></th>
            <th>Agent</th>
            <th>Phone</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Venue</th>
            <th>Description</th>
            <th>Request Date</th>
            <th>Shipping Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

    <div class="col-lg-12">
      <button class="btn btn-info" onclick="approveSelected()">Approve Selected Items</button> &nbsp; &nbsp;
      <button class="btn btn-danger" onclick="rejectSelected()">Reject Selected Items</button>
    </div>




    <!-- Modal -->
    <div id="sampleDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Product Detail</h4>
          </div>
          <div class="modal-body">
            <div id="name" style="min-height:30px; width:80px; float:left;"></div>
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px;"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
  </div><!-- /.row -->
</section><!-- /.content -->

@push('scripts')
<script>
var rows_selected = [];
var table;
$('#datatableUser tbody').on( 'click', '.detail', function () {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/sample/request/detail') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var obj = JSON.parse(data);
          var name = "";
          var qty = "";
          for(var i=0; i<obj.length; i++)
          {
            name += (obj[i].name + "<br>") ;
            qty += ("x" + obj[i].quantity + "<br>") ;
          }
          $(".modal-body #name").html(name);
          $(".modal-body #qty").html(qty);
        }
      }
    });
    $("#sampleDetail").modal();
}); 

$('#productDetail').on('hidden.bs.modal', function (e) {
  $(".modal-body #name").html("");
  $(".modal-body #qty").html("");
})

function reject(id, name, desc) 
{
  if (confirm("Are you sure want to reject request for event " + name + ":\n" + desc + "?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/sample/request') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>", action:"reject"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw();
          alert('Data has been rejected');
        }
        else alert('Failed');
      }
    });
  }   
}

function approve(id, name, desc) 
{
  if (confirm("Are you sure want to approve request for event " + name + ":\n" + desc + "?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/sample/request') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>", action:"approve"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw();
          alert('Data has been approved');
        }
        else alert('Failed');
      }
    });
  } 
}

function rejectSelected() 
{
  if (confirm("Are you sure want to reject these ?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be rejected');
    else
    {
      $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/sample/request') }}",
      data: {id:rows_selected, _token:"<?php echo csrf_token(); ?>", action:"reject"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw();
          rows_selected = [];
          alert('Data has been rejected');
        }
        else alert('Failed');
      }
    });
    }
  }   
}

function approveSelected() 
{
  if (confirm("Are you sure want to approve these ?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be approved');
    else
    {
      $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/sample/request') }}",
      data: {id:rows_selected, _token:"<?php echo csrf_token(); ?>", action:"approve"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw();
          rows_selected = [];
          alert('Data has been approved');
        }
        else alert('Failed');
      }
    });
    }
  } 
}

function updateDataTableSelectAllCtrl(table){
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

      var i=0;
$(function() {
    table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        rowCallback: function(row, data, dataIndex){
         // Get row ID
         var rowId = data[0];

         // If row ID is in the list of selected row IDs
         if($.inArray(rowId, rows_selected) !== -1){
            $(row).find('input[type="checkbox"]').prop('checked', true);
            $(row).addClass('selected');
         }
      },
        ajax: '{!! route('samplerequest.data') !!}',
        columns: [
            { className: "dt-center", width:"8%", orderable: false, name: 'checkbox', render: function (data, type, full, meta){
               return '<input type="checkbox">';
            }},
            { data: 'name', name: 'name', title:'Agent' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'event_name', name: 'event_name', title:'Event Name' },
            { data: 'event_date', name: 'event_date', title:'Event Date' },
            { data: 'event_venue', name: 'event_venue', title:'Venue' },
            { data: 'event_description', name: 'event_description', title:'Description' },
            { data: 'request_date', name: 'request_date', title:'Request Date' },
            { data: 'shipping_date', name: 'shipping_date', title:'Shipping Date' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "`" + row.request_id + "`,`" + row.event_name + "`,`" + row.event_description + "`";
              return '<button class="btn btn-info" onclick="approve(' + data + ')" >' + 'Approve' + '</button> &nbsp; &nbsp;' +
                   '<button class="btn btn-danger" onclick="reject(' + data + ')">' + 'Reject' + '</button> <br><br>' + 
                   '<button type="button" class="btn btn-warning detail" data-id="' + row.request_id + '" data-toggle="modal" data-target="#sampleDetail">Product Detail</button>';
            } }
        ]
    });

    // Handle click on checkbox
   $('#datatableUser tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data['request_id'];

      // Determine whether row ID is in the list of selected row IDs 
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle click on table cells with checkboxes
   /*$('#datatableUser').on('click', 'tbody td, thead th:first-child', function(e){
      var button = $(this).parent().find(button);

      if
      // $("#tombol").click(function(){
      //   alert(i);
      // }); i++;
      // if($('#tombol').data('clicked')) {
      //   $(this).parent().find('input[type="checkbox"]').trigger('click');
      // }
   });*/
    $('#datatableUser tbody').delegate("td", "click", function(e) {
      $(this).parent().find('input[type="checkbox"]').trigger('click');
    }); 

    $('#datatableUser tbody').on( 'click', 'button', function (e) {
      e.preventDefault();
      e.stopPropagation();
    });


  




   // Handle click on "Select all" control
   $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
      if(this.checked){
         $('#datatableUser tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#datatableUser tbody input[type="checkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle table draw event
   table.on('draw', function(){
      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
   });
});

</script>
@endpush
@stop

