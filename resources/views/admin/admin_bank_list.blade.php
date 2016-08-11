@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Bank List
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Bank List</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if(Session::has('delete'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been deleted!</strong>
    </div>
    @elseif(Session::has('update'))
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Bank</th>
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
var table;
function deleteBank(name, id) 
{
  if (confirm("Are you sure want to delete: \n" + name + " ?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('admin/delete/bank') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw(false);
          alert('Data has been deleted');
        }
        else alert('Failed');
      }
    });
  } 
}

function editBank(id) 
{
  window.location = "{{ URL::to('/admin/edit/bank') }}" + "/" + id;
}

$(function() {
    table = $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('bank.data') !!}',
        columns: [
            { data: 'bank_name', name: 'bank_name', title:'Bank' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "`" + row.bank_name + "`";
              return '<a class="btn btn-warning" onclick="editBank(' + row.bank_id + ')" >' + 'Edit' + '</a> &nbsp;' +
                     '<a class="btn btn-danger" onclick="deleteBank(' + data + "," + row.bank_id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop