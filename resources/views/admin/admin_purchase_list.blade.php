@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Purchase Order
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Purchase Order</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-6">
      <form method="GET" class="form-inline" role="form" action={{URL('admin/purchase')}}>
        <div class="col-lg-12">
         <b>Notes:<br>
         You have to fill both start and end date to filter the data
         <br>or<br>
         Leave and submit both field empty to show next week data</b>
        </div>

        <div class="col-lg-12">
          <br>
         Purchase Order Between
        </div>

        <div class="col-lg-12" id="baseDateControl">
          <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="dateStart" id="dateStart" class="datepicker form-control" value= {{$start}} />
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>

        <div class="col-lg-12">
          And
        </div>

        <div class="col-lg-12">
          <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="dateEnd" id="dateEnd" class="datepicker form-control" value={{ $end }} />
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>

        <div class="col-lg-12">
          <br>
          <input class="btn btn-primary" type="submit" value="Submit" />
        </div>

      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 text-center">
        <h3><b>Purchase Order from {{$start}} to {{$end}}</b></h3>
    </div>
  </div>


  <div class="row">
    <div class="col-lg-6">
      <div class="col-lg-12 text-center">
        <br>
        <h4><b>Purchase Order per Agent</b></h4>
      </div>
      <div class="col-lg-12">
        <br>
        <table class="paginated">
          <thead>
            <tr>
              <th scope="col" class="text-center">Agent</th>
              <th scope="col" class="text-center">Product</th>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-center">Total Price</th>
            </tr>
          </thead>
          <tbody>
            @if($query != 0)
              <?php $i = 0; $namaLama = "";?>
              @foreach($query as $data)
                @if($i == 0)
                  <tr>
                    <td> {{$data->name}} </td>
                    <td> {{$data->varian}} </td>
                    <td> {{$data->qty}} </td>
                    <td> {{number_format($data->price, 0, ',', '.')}} </td>
                  </tr>
                  <?php $i++; $namaLama = $data->name;?>
                @else
                  @if($data->name == $namaLama)
                    <td></td>
                    <td> {{$data->varian}} </td>
                    <td> {{$data->qty}} </td>
                    <td> {{number_format($data->price, 0, ',', '.')}} </td>
                  @else
                    <tr>
                      <td> {{$data->name}} </td>
                      <td> {{$data->varian}} </td>
                      <td> {{$data->qty}} </td>
                      <td> {{number_format($data->price, 0, ',', '.')}} </td>
                    </tr>
                  <?php $namaLama = $data->name;?>
                  @endif
                @endif 
              @endforeach
            @endif
        </table> 
      </div>
    </div>

    <div class="col-lg-6">
      <div class="col-lg-12 text-center">
        <br>
        <h4><b>Purchase Order per Product</b></h4>
      </div>
      <div class="col-lg-12">
        <br>
        <table class="paginated">
          <thead>
            <tr>
              <th scope="col" class="text-center">Product</th>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-center">Total Price</th>
            </tr>
          </thead>
          <tbody>
            @if($query != 0)
              @foreach($product as $data)
                <tr>
                  <td> {{$data->name}} </td>
                  <td> {{$data->quantity}} </td>
                  <td> {{number_format($data->price, 0, ',', '.')}} </td>
                </tr>
              @endforeach
            @endif
        </table> 
      </div>
    </div>
  </div><!-- /.row -->

</section><!-- /.content -->
@push('scripts')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script>
$(function() {
    var date = $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

    $( "#datepicker" ).datepicker();
});

$('table.paginated').each(function() {
    var currentPage = 0;
    var numPerPage = 10;
    var $table = $(this);
    $table.bind('repaginate', function() {
        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
    });
    $table.trigger('repaginate');
    var numRows = $table.find('tbody tr').length;
    var numPages = Math.ceil(numRows / numPerPage);
    var $pager = $('<div class="pager"></div>');
    for (var page = 0; page < numPages; page++) {
        $('<span class="page-number"></span>').text(page + 1).bind('click', {
            newPage: page
        }, function(event) {
            currentPage = event.data['newPage'];
            $table.trigger('repaginate');
            $(this).addClass('active').siblings().removeClass('active');
        }).appendTo($pager).addClass('clickable');
    }
    $pager.insertBefore($table).find('span.page-number:first').addClass('active');
});
</script>

<style>
table {
    width: 100%;
    margin: 2em auto;
}

thead {
    background: #ccccb3;
    color: #000;
}

td {
    width: 10em;
    padding: 0.3em;
}

tr:nth-child(even){background-color: #d9d9d9}

tbody {
    background: #fff;
}

div.pager {
    text-align: center;
    margin: 1em 0;
}

div.pager span {
    display: inline-block;
    width: 1.8em;
    height: 1.8em;
    line-height: 1.8;
    text-align: center;
    cursor: pointer;
    background: #000;
    color: #fff;
    margin-right: 0.5em;
}

div.pager span.active {
    background: #c00;
}
</style>
@endpush
@stop