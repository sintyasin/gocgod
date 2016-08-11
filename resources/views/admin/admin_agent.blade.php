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

function editAgent(id)
{
  window.location = "{{ URL::to('admin/edit/agent') }}" + "/" + id;
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
            switch(parseInt(data.day[i])) {
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

$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('agentlist.data') !!}',
        columns: [
            { data: 'id', name: 'id', title:'Agent Id' },
            { data: 'name', name: 'name', title:'Name' },
            { data: 'city_name', name: 'city_name', title:'City' },
            { data: 'address', name: 'address', title:'Address' },
            { data: 'date_of_birth', name: 'date_of_birth', title:'Date of birth' },            
            { data: 'email', name: 'email', title:'Email' },
            { data: 'phone', name: 'phone', title:'Phone' },
            { data: 'rating', name: 'rating', title:'Rating' },
            { data: 'balance', name: 'balance', title:'Balance' },
            {className: "dt-center", width:"10%", name: 'actions', title:'Actions', render: function(data, type, row) {
              return '<a class="btn btn-warning" onclick="editAgent(' + row.id + ')" >' + 'Edit' + '</a><br><br>' + 
              '<button type="button" class="btn btn-info detail" data-id="' + row.id + '" data-toggle="modal" data-target="#sampleDetail">Shipping Coverage</button>';
            } },
            { data: 'verification', name: 'verification', title:'Verification' },
            { data: 'bank_account', name: 'bank_account', title:'Account Number' },
            { data: 'bank_name', name: 'bank_name', title:'Bank' },
            { data: 'country', name: 'country', title:'Country' },
            { data: 'province_name', name: 'province_name', title:'Province' },
            { data: 'district_name', name: 'district_name', title:'District' },
            { data: 'zipcode', name: 'zipcode', title:'Zip Code' },
        ]
    });
});
</script>
@endpush
@stop