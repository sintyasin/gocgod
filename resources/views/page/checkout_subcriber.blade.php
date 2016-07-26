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
      @if (session('error'))
        <div class="alert alert-danger fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>{{ session('error') }}</strong>
        </div>
      @endif

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
            
      <form class="form-horizontal" id="orderForm" role="form" method="POST" action="{{ url('orderall_checkout') }}">
      {!! csrf_field() !!}
        
        <div id="wrapper_table">
          <div id="subcriber">
            <br>
            <p class='form_head'>Pilih Produk</p>
            <table id="tabel" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Kuantitas</th>
                  <th>Harga</th>
                  <th>Gambar</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <?php $a=0;?>
                @foreach ($query_menu as $items)
                  <tr>
                    <td> {{$items->varian_name}} </td>
                    <td>
                      <input type="number" min="0" maxlength="2" id="{{ $a.'-qty_subcriber' }}" name = "{{ $a.'-qty_subcriber' }}" value="0" style="width:60px; color:black; text-align: center;">
                      @foreach(Cart::content() as $cart)
                      @if($cart->id == $items->varian_id)
                      <script>
                        var tmp = <?php echo $a; ?> + '-qty_subcriber';
                        document.getElementById(tmp).value= <?php echo $cart->qty; ?>
                      </script>
                      @endif
                      @endforeach
                    </td>
                    <td> Rp {{number_format($items->price, 2, ',', '.')}} </td>
                    <td> <img  src={{URL('assets/images/product') . '/' . $items->category_name . '/' .  $items->picture}} /> </td>
                    <td style="text-align: justify"> {{$items->description}} </td>
                    
                    <input type="hidden" value="{{$items->varian_name}}" id = "{{ $a.'-name' }}" name = "{{ $a.'-name' }}">
                    <input type="hidden" value="{{$items->varian_id}}" id = "{{ $a.'-id' }}" name = "{{ $a.'-id' }}">
                    <input type="hidden" value="{{$items->price}}" id = "{{ $a.'-price' }}" name = "{{ $a.'-price' }}">
                  </tr>
                  <?php $a++?>
                @endforeach
              </tbody>
            </table>
            <br>
          </div>

          <div id="alert">
          </div>

          </div>
        </form>
        <input onclick="check()" type="submit" value="Next">
    </div>
    @endif
  </div>
</div>
<!-- End checkout content -->
@push('scripts')
<script>
  $(document).ready(function() {
      var table = $('table.display').DataTable( {
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
     $('#tabel tbody').on('keyup change', '.child input, .child select, .child textarea', function(e){
         var $el = $(this);
         var rowIdx = $el.closest('ul').data('dtr-index');
         var colIdx = $el.closest('li').data('dtr-index');
         var cell = table.cell({ row: rowIdx, column: colIdx }).node();
         $('input', cell).val($el.val());
     });


  } );

  function check()
  {
    var rows = <?php if(isset($a)) echo $a; ?>;
    var bisaNext = false;
    for (var i = 0; i < rows; i++) 
    {
      var quantity = $('#'+i+'-qty_subcriber').val();
      if(quantity > 0)
      {
        bisaNext = true;
        break;
      }
    }

    if(bisaNext)
    {
      $.ajax({
        type: "POST",
        url: "{{ URL::to('addtocartsubscribe') }}",
        data: $("#orderForm").serialize(),
        success:
        function(data)
        {
          if(data == 0)
          {
            var data = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Data yang Anda masukkan tidak valid</strong></div>';
            document.getElementById('alert').innerHTML = data;
          }
          else
          {
            location.href = "orderall_checkout";
          }
        }
      });
    }
    else
    {
      var data = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Anda harus membeli minimal 1 produk</strong></div>';
      document.getElementById('alert').innerHTML = data;
    }
      

  }

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