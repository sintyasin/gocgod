  @extends('layout.main_layout')

@section('content')
<!-- Start checkout content -->
<div class="container">
  <div class="padding_outer">
    <h2>Shopping Cart</h2>
  
    <?php $i=0?>
    @if (Auth::guest())
      <div class="clicktoregister">
        <a href={{ URL('/register')}} class="testimonial_custom"> Silahkan masuk terlebih dahulu atau klik link ini untuk mendaftar </a>
      </div>
    @else
    <div class="stepper">
      <div id="wrapper_progress">
        <br>
        <div class="col-md-12 col-xs-12">
          <span class='baricon'>1</span>
          <span id="bar1" class='progress_bar'></span>
          <span class='baricon'>2</span>
          <span id="bar2" class='progress_bar'></span>
          <span class='baricon'>3</span>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      </div>
            
      <form class="form-horizontal" role="form" method="POST" action="{{ url('orderall_checkout') }}">
      {!! csrf_field() !!}
        
        <div id="wrapper_table">
          <div id="subcriber">
            <br>
            <p class='form_head'>Pilih Produk</p>
            <table class="display table table-striped table-bordered dt-responsive" width="100%">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Gambar</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th>Kuantitas</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $a=0;?>
                @foreach ($query_menu as $items)
                  <tr>
                    <td> {{$items->varian_name}} </td>
                    <td> </td>
                    <td style="text-align: justify"> {{$items->description}} </td>
                    <td> Rp {{number_format($items->price, 2, ',', '.')}} </td>
                    <td>
                      <input type="hidden" value="{{$items->varian_name}}" id = "{{ $a.'-name' }}">
                      <input type="hidden" value="{{$items->varian_id}}" id = "{{ $a.'-id' }}">
                      <input type="hidden" value="{{$items->price}}" id = "{{ $a.'-price' }}">
                      <input type="number" min="0" maxlength="2" id="{{ $a.'-qty_subcriber' }}" value="0" style="width:60px; color:black; text-align: center;">
                      @foreach(Cart::content() as $cart)
                      @if($cart->id == $items->varian_id)
                      <script>
                        var tmp = <?php echo $a; ?> + '-qty_subcriber';
                        document.getElementById(tmp).value= <?php echo $cart->qty; ?>
                      </script>
                      @endif
                      @endforeach
                    </td>
                    <td>
                    <button type="button" id="button_{{$a}}" class="btn btn-primary" onclick="addtosubcriber({{ $a }})"> Tambah ke Cart</button>
                    </td>
                  </tr>
                  <?php $a++?>
                @endforeach
              </tbody>
            </table>
            <br>
            <input type="submit" value="Next">
          </div>
          </div>
        </form>
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@push('scripts')
<script>
  $(document).ready(function() {
      var table = $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );

  function addtosubcriber(x)
  {
    var quantity = $('#'+x+'-qty_subcriber').val();
    var name = $('#'+x+'-name').val();
    var price = $('#'+x+'-price').val();
    var id = $('#'+x+'-id').val();
    
    if (quantity < 1) alert('You are still not purchase this products!');
    else{
    $.ajax({
      url: '{{ URL("/addtocartsubcriber")}}',
      type: 'POST',
      data: {id: id, qty: quantity, name: name, price: price},
      beforeSend: function(request){
        return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
      },
    })
    .success(function(data){
      $("#button_"+x).prop("disabled",true);
      alert('Added to cart!');
    })
    .fail(function(){
      alert('error');
    })
    }
  }
</script>
@endpush
@stop