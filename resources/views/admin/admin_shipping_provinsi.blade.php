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
    ajax: '{!! route('province.data') !!}',
    columns: [
        { data: 'province_id', name: 'province_id', title:'Province Id' },
        { data: 'province_name', name: 'province_name', title:'Province Name' },
        { data: 'status', name: 'status', title:'Status' },
        {className: "dt-center", width:"17%", name: 'actions', title: 'Action', render: function(data, type, row) {
            var data = "'" + row.province_id + "','" + row.province_name + "','provinsi'";
            
            if(row.status == 0)
                return '<a class="btn btn-success" onclick="process(' + data + ')" >' + 'Terjangkau' + '</a>';
            else
                return '<a class="btn btn-danger" onclick="process(' + data + ')" >' + 'Tidak Terjangkau' + '</a>';
        } }
    ]
});

function process(id, name, type) 
{
    if (confirm("Are you sure want to change " + name + "\'s status?") == true) 
    {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/admin/process/shipping/scope') }}",
            data: {id:id, type:type, _token:"<?php echo csrf_token(); ?>"},
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