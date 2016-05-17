@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Product Testimonial Request
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Product Testimonial Request</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if($status == "successReject")
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Testimoni has been rejected successfully!</strong>
    </div>
    @elseif($status == "successApprove")
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
            <th>Member</th>
            <th>Product</th>
            <th>Testimonials</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div><!-- /.row -->

</section><!-- /.content -->

@push('scripts')
<script>
var rows_selected = [];
function reject() 
{
  if (confirm("Are you sure want to reject these ?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be rejected');
    else
      window.location = "{{ URL::to('/adminprocesstestimoni') }}" + "/reject/" + rows_selected;
  }   
}

function approve() 
{
  if (confirm("Are you sure want to approve these ?") == true) 
  {
    if(rows_selected.length <= 0) alert('You haven\'t choose items to be approved');
    else
      window.location = "{{ URL::to('/adminprocesstestimoni') }}" + "/approve/" + rows_selected;
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

$(function() {
  var table = $('#datatableUser').DataTable({
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
      ajax: '{!! route('processtestimonial.data') !!}',
      columns: [
          { className: "dt-center", width:"8%", orderable: false, name: 'checkbox', render: function (data, type, full, meta){
             return '<input type="checkbox">';
          }},
          { data: 'name', name: 'name', title:'Member' },
          { data: 'varian_name', name: 'varian_name', title:'Product' },
          { data: 'testimonial', name: 'testimonial', title:'Testimonials' },
          {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
            return '<a class="btn btn-info" onclick="approve()" >' + 'Approve' + '</a> &nbsp; &nbsp;' +
                   '<a class="btn btn-danger" onclick="reject()">' + 'Reject' + '</a>';
          } }
      ]
  });

  // Handle click on checkbox
   $('#datatableUser tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data['testimonial_id'];

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
   $('#datatableUser').on('click', 'tbody td, thead th:first-child', function(e){
      $(this).parent().find('input[type="checkbox"]').trigger('click');
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
