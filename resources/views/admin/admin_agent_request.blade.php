@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Agent Request
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Agent Request</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('reject'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Agent request has been rejected successfully!</strong>
    </div>
    @elseif(Session::has('approve'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Agent request has been approved successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><input name="select_all" value="1" type="checkbox" /></th>
            <th>Name</th>
            <th>Date Of Birth</th>
            <th>City</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Bank</th>
            <th>Account Number</th>
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
    <div id="agentDetail" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Agent Detail</b></h4>
          </div>
          <div class="modal-body">
            <div id="name" style="min-height:30px; width:100%;"></div>
            <div id="day" style="min-height:30px; width:100%;"></div>
            <div id="ship" style="min-height:30px; width:100%;"></div>
            <!-- <div id="name" style="min-height:30px; width:80px; float:left;"></div>
            <div id="qty" style="min-height:30px; width:80px; margin-left:80px; float:left;"></div>
            <div id="price" style="min-height:30px; width:150px; margin-left:240px;"></div> -->
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
function reject(agent, id) 
{
  if (confirm("Are you sure want to reject agent\'s request " + agent + "?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/agent/request') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>", action:'reject'},
      success:
      function(success)
      {
        if(success)
        {
          table.draw(false);
          alert('Agent has been rejected');
        }
        else alert('Failed');
      }
    });
  }   
}

function approve(agent, id) 
{
  if (confirm("Are you sure want to approve agent\'s request " + agent + "?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/agent/request') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>", action:'approve'},
      success:
      function(success)
      {
        if(success)
        {
          table.draw(false);
          alert('Agent has been approved');
        }
        else alert('Failed');
      }
    });
  } 
}

function rejectSelected() 
{
  if (confirm("Are you sure want to reject selected review?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be rejected');
    else
    {
      $.ajax({
        type: "POST",
        url: "{{ URL::to('/admin/process/agent/request') }}",
        data: {id:rows_selected, _token:"<?php echo csrf_token(); ?>", action:'reject'},
        success:
        function(success)
        {
          if(success)
          {
            table.draw(false);
            rows_selected = [];
            alert('Agent has been rejected');
          }
          else alert('Failed');
        }
      });
    }
  }   
}

function approveSelected() 
{
  if (confirm("Are you sure want to approve selected review?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be approved');
    else
    {
      $.ajax({
        type: "POST",
        url: "{{ URL::to('/admin/process/agent/request') }}",
        data: {id:rows_selected, _token:"<?php echo csrf_token(); ?>", action:'approve'},
        success:
        function(success)
        {
          if(success)
          {
            table.draw(false);
            rows_selected = [];
            alert('Agent has been approved');
          }
          else alert('Failed');
        }
      });
    }
  } 
}

$('#datatableUser tbody').on( 'click', '.detail', function () {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/agent/request/detail') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(data)
      {
        if(data != 0)
        {
          var day = "<h4><b>Available day(s)</b></h4>";
          for(var i=0; i<data.day.length; i++)
          {
            switch(data.day[i]) {
              case 1:
                day += 'Senin';
                break;
              case 2:
                day += 'Selasa';
                break;
              case 3:
                day += 'Rabu';
                break;
              case 4:
                day += 'Kamis';
                break;
              case 5:
                day += 'Jumat';
                break;
              case 6:
                day += 'Sabtu';
                break;
              case 7:
                day += 'Minggu';
                break;
            } 
            //kalo bukan data terakhir kasih koma (,)
            if(i != data.day.length - 1) day += ', ';
          }

          var ship = "<br><h4><b>Shipping coverage</b></h4>";
          for(var i=0; i<data.ship.length; i++)
          {
            ship += data.ship[i]['province'] + '<br>' + data.ship[i]['city'] + '<br>' + data.ship[i]['district'];

            //kalo bukan data terakhir kasih koma (,)
            if(i != data.ship.length - 1) ship += '<br><br>';
          }

          $(".modal-body #name").html(data.name);
          $(".modal-body #day").html(day);
          $(".modal-body #ship").html(ship);
        }
      }
    });
    $("#agentDetail").modal();
}); 

$('#agentDetail').on('hidden.bs.modal', function (e) {
  $(".modal-body #name").html("");
  $(".modal-body #day").html("");
  $(".modal-body #ship").html("");
})

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
        ajax: '{!! route('agentrequest.data') !!}',
        columns: [
            { className: "dt-center", width:"8%", orderable: false, name: 'checkbox', render: function (data, type, full, meta){
               return '<input type="checkbox">';
            }},
            { data: 'name', name: 'name', title:'Name' },
            { data: 'date_of_birth', name: 'date_of_birth', title:'Date Of Birth' },
            { data: 'city_name', name: 'city_name', date_of_birth:'City' },
            { data: 'address', name: 'address', title:'Address' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'email', name: 'email', date_of_birth:'Email' },
            { data: 'bank_name', name: 'bank_name', title:'Bank' },
            { data: 'accno', name: 'accno', title:'Account Number' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "`" + row.name + "`,`" + row.reqagent_id + "`";
              return '<button class="btn btn-info" onclick="approve(' + data + ')" >' + 'Approve' + '</button> &nbsp; &nbsp;' +
                   '<button class="btn btn-danger" onclick="reject(' + data + ')">' + 'Reject' + '</button> <br><br>' + 
                   '<button type="button" class="btn btn-warning detail" data-id="' + row.member_id + '" data-toggle="modal">Detail</button>';
            } }
        ]
    });

    // Handle click on checkbox
   $('#datatableUser tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data['reqagent_id'];

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

