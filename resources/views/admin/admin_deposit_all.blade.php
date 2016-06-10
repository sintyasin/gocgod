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
    ajax: '{!! route('deposit.data') !!}',
    columns: [
        { data: 'balance_id', name: 'balance_id', title:'Balance Id' },
        { data: 'name', name: 'name', title:'Agent' },
        { data: 'amountMoney', name: 'amountMoney', title:'Amount' },
        { data: 'balance_type', name: 'balance_type', title:'Type' },
        { data: 'order_id', name: 'order_id', title:'Order Id' },
        { data: 'statusTransfer', name: 'statusTransfer', title:'Status Transfer' },
        {className: "dt-center", width:"17%", name: 'actions', title: 'Action', render: function(data, type, row) {
            var data = "'" + row.balance_id + "','" + row.name + "','" + row.amountMoney + "'";
            
            if(row.balance_type == 0 && row.statusTransfer == 0)
                return '<a class="btn btn-warning" onclick="process(' + data + ')" >' + 'Confirm' + '</a>';
            else
                return '';
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
              if(data) table.ajax.reload();
              else alert('Failed');
            }
          });
    }
}
</script>