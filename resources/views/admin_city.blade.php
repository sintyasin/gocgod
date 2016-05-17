@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    City
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">City</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    @if($status == "successDelete")
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been deleted!</strong>
    </div>
    @elseif($status == 'successUpdate')
    <div class="alert alert-success fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Data has been updated successfully!</strong>
    </div>
    @endif
    <div class="col-lg-12">
      <table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>City</th>
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
function deleteCity(name, id) 
{
  if (confirm("Are you sure want to delete: \n" + name + " ?") == true) 
  {
    window.location = "{{ URL::to('/admindeletecity') }}" + "/" + id;
  } 
}

function editCity(id) 
{
  window.location = "{{ URL::to('/admineditcity') }}" + "/" + id;
}

$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('citylist.data') !!}',
        columns: [
            { data: 'city_name', name: 'city_name', title:'City' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "'" + row.city_name + "'";
              return '<a class="btn btn-warning" onclick="editCity(' + row.city_id + ')" >' + 'Edit' + '</a> &nbsp;' +
                     '<a class="btn btn-danger" onclick="deleteCity(' + data + "," + row.city_id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop