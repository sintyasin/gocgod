<table id="order_details" class="display table table-striped table-bordered dt-responsive" width="100%">
  <thead>
    <tr>
      <th>Produk</th>
      <th>Kuantitas</th>
      <th>Harga</th>
      <th>Sub Total</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php $i=0?>
    @foreach(Cart::content() as $row)
    <tr>
      <td>{{$row->name}}</td>
      <td align="center">
        <input type="number" min="1" maxlength="2" id="{{ $i.'-qty_subcriber' }}" value="{{$row->qty}}" style="width:60px; color:black; text-align: center;">
      </td>
      <td>Rp {{number_format($row->price, 0, ',', '.')}}</td>
      
      <td><span id="{{ $i.'-subtotal' }}">Rp {{number_format($row->subtotal, 0, ',', '.')}}</span></td>
      <td align="center">
        <div style="text-align:center;">
          <button type="button" class="btn btn-primary" onclick="updatecart({{ $i }})"> Ubah</button>
          <button type="button" onclick="deletecart({{ $i }})" class="btn btn-danger">Hapus</button>
        </div>
      </td>
      <input type="hidden" id="{{ $i.'-rowid' }}" value="{{$row->rowid}}">
      <input type="hidden" id="{{ $i.'-id' }}" value="{{$row->id}}">
    </tr>
    <?php $i++; ?>
    @endforeach
  </tbody>
</table>

<script>
$(document).ready(function() {
  var table = $('#order_details').DataTable( {
        'columnDefs': [
         {
            'targets': [1],
            'render': function(data, type, row, meta){
               if(type === 'display'){
                  var api = new $.fn.dataTable.Api(meta.settings);

                  var $el = $('input', api.cell({ row: meta.row, column: meta.col }).node());

                  var $html = $(data).wrap('<div/>').parent();

                  if($el.prop('tagName') === 'INPUT'){
                     $('input', $html).attr('value', $el.val());
                  } 

                  data = $html.html();
               }
               return data;
            }
         }
      ],
      'responsive': true
      } );


      // Update original input/select on change in child row
     $('#order_details tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
         var $el = $(this);
         var rowIdx = $el.closest('ul').data('dtr-index');
         var colIdx = $el.closest('li').data('dtr-index');
         var cell = table.cell({ row: rowIdx, column: colIdx }).node();
         $('input', cell).val($el.val());
     });
});
</script>