@if(Session::has('update'))
<div class="alert alert-success fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Data has been confirmed successfully!</strong>
</div>
@endif
<table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
<thead>
</thead>
<tbody>
</tbody>
</table>

<script>

var table = $('#datatableUser').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('depositunfinish.data') !!}',
    columns: [
        { data: 'balance_id', name: 'balance_id', title:'Balance Id' },
        { data: 'name', name: 'name', title:'Agent' },
        { data: 'amountMoney', name: 'amountMoney', title:'Amount' },
        { data: 'statusTransfer', name: 'statusTransfer', title:'Status Transfer' },
        {className: "dt-center", width:"17%", name: 'actions', title: 'Action', render: function(data, type, row) {
          var data = "'" + row.balance_id + "','" + row.name + "','" + row.amountMoney + "'";
          return '<a class="btn btn-warning" onclick="process(' + data + ')" >' + 'Confirm' + '</a>';
        } }
    ]
});

function process(id, name, amount) 
{
    if (confirm("Are you sure want to process " + name + "\'s Rp" + amount + "?") == true) 
    {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/admin/process/balance') }}",
            data: {id:id, _token:"<?php echo csrf_token(); ?>"},
            success:
            function(data)
            {
              if(data) table.ajax.reload(null, false);
              else alert('Failed');
            }
          });
    }
}
</script>