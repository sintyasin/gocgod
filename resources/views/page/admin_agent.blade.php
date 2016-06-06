@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Agent
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Agent</li>
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

function editAgent(id)
{
  window.location = "{{ URL::to('admin/edit/agent') }}" + "/" + id;
}

$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('agentlist.data') !!}',
        columns: [
            { data: 'id', name: 'id', title:'Agent Id' },
            { data: 'name', name: 'name', title:'Name' },
            { data: 'address', name: 'address', title:'Address' },
            { data: 'city_name', name: 'city_name', title:'City' },
            { data: 'date_of_birth', name: 'date_of_birth', title:'Date of birth' },            
            { data: 'email', name: 'email', title:'Email' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'verification', name: 'verification', title:'Verification' },
            { data: 'balance', name: 'balance', title:'Balance' },
            { data: 'bank_account', name: 'bank_account', title:'Bank Account' },
            {className: "dt-center", width:"10%", name: 'actions', render: function(data, type, row) {
              return '<a class="btn btn-warning" onclick="editAgent(' + row.id + ')" >' + 'Edit' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop