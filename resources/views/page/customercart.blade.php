<table id="order_details" class="display table table-striped table-bordered dt-responsive" width="100%">
  <thead>
    <tr>
      <th>Produk</th>
      <th>Harga</th>
      <th>Kuantitas</th>
      <th>Sub Total</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php $i=0?>
    @foreach(Cart::content() as $row)
    <tr>
      <td>{{$row->name}}</td>
      <td>Rp {{$row->price}}</td>
      <td align="center">
        <input type="hidden" id="{{ $i.'-rowid' }}" value="{{$row->rowid}}">
        <input type="hidden" id="{{ $i.'-id' }}" value="{{$row->id}}">
        <input type="number" min="1" maxlength="2" id="{{ $i.'-qty_subcriber' }}" value="{{$row->qty}}" style="width:60px; color:black; text-align: center;">
        
      </td>
      <td><span id="{{ $i.'-subtotal' }}">Rp {{$row->subtotal}}</span></td>
      <td align="center">
        <button type="button" class="btn btn-primary" onclick="updatecart({{ $i }})"> Ubah</button>
        <button type="button" onclick="deletecart({{ $i }})" class="btn btn-danger">Hapus</button>
      </td>
    </tr>
    <?php $i++; ?>
    @endforeach
  </tbody>
</table>