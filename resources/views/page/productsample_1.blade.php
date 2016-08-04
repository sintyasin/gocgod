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
            <div id="wrapper_a">
            <div id="wrapper_progress">
              <br>
              <div class="col-md-12 col-xs-12">
                  <span class='baricon'>1</span>
                  <span id="bar1" class='progress_bar' style="background-color:#38610B"></span>
                  <span class='baricon'>2</span>
              </div>
            </div>
              <form class="form-horizontal" role="form" method="POST" action="{{ url('productsample') }}">
                {!! csrf_field() !!}
                  <div id="sample_details">
                    <p class='form_head'>Request Product Sample</p>
                    <div class="col-md-12">
                    
                    <div class="input_fields_wrap">
                    <button class="add_field_button" style=" width: 150px; min-height: 40px; border-radius: 5px; background-color:white;">Add More Product</button>
                    <br>
                    <div class="col-md-12">
                    <div class="col-md-4 col-md-offset-3">
                    <label>Product 1</label>
                    <select name='0-product' style="width:70%;">
                    <?php $i = 1; ?>
                    @foreach ($query as $item)
                    <?php
                        echo "<option value= ". $item->varian_id . ">" . $item->varian_name . "</option>";
                        $i++;
                    ?>
                    @endforeach
                    </select>
                    </div>
                    <div class="col-md-1">
                    <input type="number" placeholder="quantity" min="1"  value="0" name="0-qty" style="width:80%;"/>
                    </div>
                    </div>
                    <input type="hidden" name="id" value="{{$request_data->request_id}}"/>
                    </div>

                    </div>
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

    $(document).ready(function() {

        init_multifield(10, '.input_fields_wrap', '.add_field_button', 'user_music[]');
        init_multifield(10, '.input_fields_wrap2', '.add_field_button2', 'user_music2[]');

        var max_fields = 100;  //maximum input boxes allowed
        var x = 1; //initlal text box count
        function init_multifield(max, wrap, butt, fname_p) {
            var wrapper = $(wrap); //Fields wrapper
            var add_button = $(butt); //Add button class
            var fname = fname_p;

            $(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment

                    $(wrapper).append('<div class="col-md-12"><div class="col-md-4 col-md-offset-3"><label>Product '+ x +'&nbsp</label><select name="'+(x-1)+'-product" style="width:70%"><?php $i = 1; ?>@foreach ($query as $item)<?php echo "<option value= ". $item->varian_id . ">" . $item->varian_name . "</option>";$i++;?>@endforeach</select></div><div class="col-md-1"><input type="number" placeholder="quantity" style="width:80%;" min="1"  value="0" name="'+(x-1)+'-qty"/></div><a href="#" class="remove_field" style="color:white; margin-top:15px; float:left;">Remove</a></div>'); //add input box
                }
            });

            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
            })
        }
    });
</script>
@endpush
@stop