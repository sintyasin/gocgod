<div class = "col-xs-12 col-md-8">
  <div class="box box-primary" >
    <div class="box-body box-profile">
      

      <h3 class="profile-username text-center"> {{Auth::user()->name}} - Jumlah Uang </h3>
      <p class="text-muted text-center" style="font-weight: bold;"> Rp {{number_format(Auth::user()->balance,0, ',' , '.')}} </p>
      <center>
        <button type="button" class="boaBtnProfile" data-toggle="modal" data-target="#withdrawMoney"> Penarikan Uang </button>
      </center>
      
      <br>
      <?php $i=0; ?>
      <table class="display table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Deskripsi</th>
          </tr>
        </thead>
        <tbody>
        @foreach($querybalance as $query)
        @if($query->balance_type == 0 || $query->balance_type == 1)
        <tr>
          <td>{{$i+1}}</td>
          <td>Rp {{number_format($query->amountMoney, 0, ',', '.')}}</td>
          <td>@if($query->balance_type == 0 && $query->statusTransfer == 0)
              Sedang diproses
            @elseif ($query->balance_type == 0 && $query->statusTransfer == 1)
            Sudah di transfer
            @endif</td>
          <td>{{$query->created_at}}</td>
          <td>@if($query->balance_type == 0)
            Penarikan
            @elseif ($query->balance_type == 1)
            Pemasukan
            @endif</td>
          <td>@if($query->balance_type == 0)
            -
            @elseif ($query->balance_type == 1)
            From Order {{$query->status}}
            @endif</td>
            

          <?php $i++;?> 
        </tr> 
        @endif
        @endforeach    
        </tbody>


      </table>
    </div>
  </div>
</div>

<script>
  
  $(document).ready(function() {
      var table = $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );

</script>
