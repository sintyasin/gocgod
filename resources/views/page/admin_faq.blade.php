@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    FAQ
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">FAQ</li>
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
            <th>Question</th>
            <th>Answer</th>
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
function deleteFaq(name, id) 
{
  if (confirm("Are you sure want to delete question: \n" + name + " ?") == true) 
  {
    window.location = "{{ URL::to('/admindeletefaq') }}" + "/" + id;
  } 
}

function editFaq(id) 
{
  window.location = "{{ URL::to('/admineditfaq') }}" + "/" + id;
}

$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('faqlist.data') !!}',
        columns: [
            { data: 'question', width:"30%", name: 'question', title:'Question' },
            { data: 'answer', name: 'answer', title:'Answer' },
            {className: "dt-center", width:"17%", name: 'actions', render: function(data, type, row) {
              var data = "'" + row.question + "'";
              return '<a class="btn btn-warning" onclick="editFaq(' + row.question_id + ')" >' + 'Edit' + '</a> &nbsp;' +
                     '<a class="btn btn-danger" onclick="deleteFaq(' + data + ', ' + row.question_id + ')" >' + 'Delete' + '</a>';
            } }
        ]
    });
});
</script>
@endpush
@stop