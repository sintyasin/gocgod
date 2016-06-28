@extends('layout.main_layout')

@section('content')



<div class="container">
	<div class="padding_outer">
		<h2>Become An Agent</h2>
	</div>

	<div class="container">
		<div class="padding_outer">
			<!-- Button trigger modal -->
            @if(Auth::guest())
            <a href={{ URL('/login')}} class="testimonial_custom"> Please Log in or Click here to Register </a>
			@elseif(Auth::user()->status_user == 0)
            <button type="button" class="boaBtn_boa" data-toggle="modal" data-target="#myModal" disabled="disabled">
			  Become Our Agent
			</button>
            @else
            <button type="button" class="boaBtn_boa" data-toggle="modal" data-target="#myModal">
              Become Our Agent
            </button>
            @endif

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal_header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	BECOME OUR AGENT
			      </div>
			      <div class="modal-body">
			        
			      	<form class="form-horizontal" role="form" method="POST" action="{{ url('request_agent') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('userType') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Become An </label>

                            <div class="col-md-6">
                                <select class='form-control' name='userType'>
                                <?php
                                    echo "<option value='0'>" . "Agent" . "</option>";
                                ?>
                                </select>
                                @if ($errors->has('userType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userType') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                          <label class="col-md-4 control-label">Bank </label>

                          <div class="col-md-6">
                              <select class="form-control" name="bank" >
                                @foreach($bank as $data)
                                    <option value="{{ $data->bank_id }}">{{ $data->bank_name }}</option>
                                @endforeach
                                </select>
                              @if ($errors->has('bank'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('bank') }}</strong>
                              </span>
                              @endif
                          </div>
                      </div>

                        <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Bank Account Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Input Your Bank Account Number" name="bank_account">

                                @if ($errors->has('bank_account'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bank_account') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="checkPageBtn">
                                    <i class="fa fa-btn fa-user"></i> REGISTER
                                </button>
                            </div>
                        </div>
                    </form>


			      </div>
			    </div>
			  </div>
			</div>



		</div>
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
