@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2>Request Product Sample</h2>

        @if (Auth::guest())
            <a href={{ URL('/register')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        @elseif(Auth::user()->status_user == 1)
            <p style="color: black; text-align: center; font-size: 20px; font-family: nexa_xboldregular"> Only Agent can fill this form </p>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        @else
        <div class="stepper">
            <div id="wrapper">
            <div id="wrapper_progress">
              <br>
              <div class="col-md-12 col-xs-12">
                  <span class='baricon'>1</span>
                  <span id="bar1" class='progress_bar'></span>
                  <span class='baricon'>2</span>
              </div>
            </div>
              <form class="form-horizontal" role="form" method="POST" action="{{ url('productsample') }}">
                {!! csrf_field() !!}
                  <div id="sample_details">
                    <p class='form_head'>Request Product Sample</p>
                    <p>Product</p>
                <select  name='product'>
                    <?php $i = 1; ?>
                    @foreach ($query as $item)
                    <?php
                        echo "<option value= ". $i . ">" . $item->varian_name . "</option>";
                        $i++;
                    ?>
                    @endforeach
                    </select>
                    <p>Quantity</p>
                    <select  name='quantity'>
                        <option value="10"> 10 </option> 
                        <option value="15"> 15 </option>
                        <option value="20"> 20 </option>
                    </select>
                    <br>
                    <input type="Submit" value="Submit">
                  </div>
              </form>
            </div>
        </div>
        @endif

	</div>
</div>

@push('scripts')
<script type="text/javascript">
    $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

        $( "#datepicker" ).datepicker();
    });
</script>
@endpush
@stop