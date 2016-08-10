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
    ajax: '{!! route('district.data') !!}',
    columns: [
        { data: 'district_id', name: 'district_id', title:'District Id' },
        { data: 'district_name', name: 'district_name', title:'District Name' },
        { data: 'city_name', name: 'city_name', title:'City Name' },
        { data: 'status', name: 'status', title:'Status' },
        {className: "dt-center", width:"17%", name: 'actions', title: 'Action', render: function(data, type, row) {
            var data = "'" + row.district_id + "','" + row.district_name + "','district'";
            
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
              if(data) table.ajax.reload(null, false);
              else alert('Failed');
            }
          });
    }
}
</script>