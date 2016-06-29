@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Order Confirmation
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Order Confirmation</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div><!-- /.row -->

</section><!-- /.content -->

@push('scripts')
<script>
var table;
function confirmation(id)
{
  if(confirm("Are you sure want to process confirmation id " + id + " ?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/process/order/confirmation') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(success)
      {
        if(success) table.draw();
        else alert('Failed');
      }
    });
  } 
}
$(function() {
    table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        order: [[2, 'desc']],
        ajax: '{!! route('orderconfirm.data') !!}',
        columns: [
            { data: 'confirmation_id', name: 'confirmation_id', title:'Confirmation ID' },
            { data: 'group_id', name: 'group_id', title:'Group ID' },
            { data: 'payment_date', name: 'payment_date', title:'Payment Date' },
            { data: 'amount', name: 'amount', title:'Amount' },
            { data: 'account_name', name: 'account_name', title:'Account Name' },            
            { data: 'account_number', name: 'account_number', title:'Account Number' },
            { data: 'confirmation_status', name: 'confirmation_status', title:'Confirmation Status' },
            {className: "dt-center", width:"10%", name: 'actions', title: 'Action', render: function(data, type, row) {
              
              if(row.confirmation_status == 0)
                return '<a class="btn btn-warning" onclick="confirmation(' + row.confirmation_id + ')" >' + 'Confirm' + '</a>';
              else return '';
            } }
        ]
    });
});
</script>
@endpush
@stop