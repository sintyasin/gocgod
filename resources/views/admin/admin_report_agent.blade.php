@extends('layout.admin_main_layout')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Agent Report
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Agent Report</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-6">
      <form method="GET" class="form-inline" id="report" role="form" action={{URL('admin/report/agent')}}>
        <div class="col-lg-12">
         <b>Notes:<br>
         You have to fill both start and end date to filter the data
         <br>or<br>
         Leave and submit both field empty to show this month's data</b>
        </div>

        <div class="col-lg-12">
          <br>
         Transaction Report Between
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
        <h3><b>Agent Report from {{$start}} to {{$end}}</b></h3>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="col-lg-12">
        <table class="paginated">
          <thead>
            <tr>
              <th scope="col" class="text-center">Agent</th>
              <th scope="col" class="text-center">Total Order</th>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-center">Omzet Gross</th>
              <th scope="col" class="text-center">Shipping Fee</th>
              <th scope="col" class="text-center">Omzet Net</th>
            </tr>
          </thead>
          <tbody>
            @if($query != 0)
              <?php $count = count($query); $i = 0; ?>
              @foreach($query as $data)
                @if($i == $count - 1)
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td><b>{{$data['Agent']}}</b></td>
                    <td><b>{{number_format($data['Total_Order'], 0, ',', '.')}}</b> </td>
                    <td><b>{{number_format($data['Quantity'], 0, ',', '.')}} </b></td>
                    <td><b> {{number_format($data['Omzet'], 0, ',', '.')}} </b></td>
                    <td><b> {{number_format($data['Shipping'], 0, ',', '.')}} </b></td>
                    <td><b> {{number_format($data['Net'], 0, ',', '.')}}</b> </td>
                  </tr>
                  <?php break; ?>
                @endif
                <tr>
                  <td>{{$data['Agent']}}</td>
                  <td>{{number_format($data['Total_Order'], 0, ',', '.')}} </td>
                  <td>{{number_format($data['Quantity'], 0, ',', '.')}} </td>
                  <td> {{number_format($data['Omzet'], 0, ',', '.')}} </td>
                  <td> {{number_format($data['Shipping'], 0, ',', '.')}} </td>
                  <td> {{number_format($data['Net'], 0, ',', '.')}} </td>
                </tr>

                <?php $i++; ?>
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