<table id="datatableUser" class="table table-striped table-bordered dt-responsive" width="100%" cellspacing="0">
<thead>
</thead>
<tbody>
</tbody>
</table>

<script>
$(function() {
    $('#datatableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('depositfinish.data') !!}',
        columns: [
            { data: 'balance_id', name: 'balance_id', title:'Balance Id' },
            { data: 'name', name: 'name', title:'Agent' },
            { data: 'amountMoney', name: 'amountMoney', title:'Amount' },
            { data: 'statusTransfer', name: 'statusTransfer', title:'Status Transfer' },
        ]
    });
});
</script>