@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Banner
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Banner</li>
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
      <table id="producttable" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
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
function deleteBanner(name, id) 
{
  if (confirm("Are you sure want to delete " + name + " ?") == true) 
  {
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/admin/delete/banner') }}",
      data: {id:id, _token:"<?php echo csrf_token(); ?>"},
      success:
      function(success)
      {
        if(success)
        {
          table.draw(false);
          alert('Banner has been deleted');
        }
        else alert('Failed');
      }
    });
  } 
}

function editBanner(id) 
{
  window.location = "{{ URL::to('/admin/edit/banner') }}" + "/" + id;
}

$(function() {
    table = $('#producttable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('banner.data') !!}',
        columns: [
            { data: 'name', name: 'name', title:'Name' },
            { data: 'alias', name: 'alias', title:'Alias' },
            { data: 'description1', name: 'description1', title:'Description 1' },
            { data: 'description2', name: 'description2', title:'Description 2' },
            { data: 'price', name: 'price', title:'Price' },
            { data: 'picture', name: 'picture', title:'Picture', render: function(data, type, row) {
              var x = "<img src={{ URL::asset('assets/images/slider/') }}";
              x += '/' + data + " style='height:100px;' />";

              return x;
            } },
            {className: "dt-center", name: 'actions', render: function(data, type, row) {
              var data = "`" + row.name + "`";
              return '<br> <a class="btn btn-warning" onclick="editBanner(' + row.id + ')" >' + 'Edit' + '</a> <br><br>' +
                     '<a class="btn btn-danger" onclick="deleteBanner(' + data + ', ' + row.id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop