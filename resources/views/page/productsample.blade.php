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
              <form class="form-horizontal" role="form" method="POST" action="{{ url('eventsample') }}">
                {!! csrf_field() !!}
                  <div id="event_details">
                    <center>
                    <p class='form_head'>Event Details</p>
                    <p>Event Name</p>
                    <input type="text" name='event_name' placeholder='Event Name'/>
                    @if ($errors->has('event_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_name') }}</strong>
                    </span>
                    @endif
                    <p>Event Date</p>
                    <input type="text" name='event_date' placeholder='Example = 2016-05-31 (year-month-day)' autocomplete="off" id="datepicker"/>
                    @if ($errors->has('event_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_date') }}</strong>
                    </span>
                    @endif
                    <p>Event Venue</p>
                    <input type="text" name='event_venue' placeholder='Event Venue'/>
                    @if ($errors->has('event_venue'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_venue') }}</strong>
                    </span>
                    @endif
                    <p>Event Description</p>
                    <input type="text" name='event_description' placeholder='Event Description'/>
                    @if ($errors->has('event_description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_description') }}</strong>
                    </span>
                    @endif
                    <p>Shipping Date</p>
                    <input type="text" name='request_date' placeholder='Example = 2016-05-31 (year-month-day)' autocomplete="off" id="datepicker1"/>
                    @if ($errors->has('request_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('request_date') }}</strong>
                    </span>
                    @endif
                    <br>
                    <input type="submit" value="Next">
                  </center>
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
        var date = $('#datepicker').datepicker({ 
          dateFormat: 'yy-mm-dd' ,
          minDate: <?php echo "'". $start."'"; ?>
        }).val();

        $( "#datepicker" ).datepicker();
    });
    $(function() {
        var date = $('#datepicker1').datepicker({ 
          dateFormat: 'yy-mm-dd' ,
          minDate: <?php echo "'". $start."'"; ?>
        }).val();

        $( "#datepicker1" ).datepicker();
    });
</script>
@endpush
@stop