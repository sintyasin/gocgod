@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    User
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-12 col-xs-3">
      <table id="datatableUser" class="table stripe hover row-border order-column">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Date of birth</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status User</th>
            <th>Verification</th>
            <th>Balance</th>
            <th>Bank Account</th>
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

$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('customerlist.data') !!}',
        columns: [
            { data: 'name', name: 'name', title:'Name' },
            { data: 'address', name: 'address', title:'Address' },
            { data: 'city_name', name: 'city_name', title:'City' },
            { data: 'date_of_birth', name: 'date_of_birth', title:'Date of birth' },            
            { data: 'email', name: 'email', title:'Email' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'status_user', name: 'status_user', title:'Status User' },
            { data: 'verification', name: 'verification', title:'Verification' },
            { data: 'balance', name: 'balance', title:'Balance' },
            { data: 'bank_account', name: 'bank_account', title:'Bank Account' },
        ]
    });
});
</script>
@endpush
@stop