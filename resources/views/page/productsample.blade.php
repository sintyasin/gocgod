@extends('layout.main_layout')

@section('content')
<div class="container">
	<div class="padding_outer">
		<h2>Request Product Sample</h2>

		<form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('#') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Product</label>

                <div class="col-md-6">
                    <select class='form-control' name='product'>
                    <?php $i = 1; ?>
                    @foreach ($query as $item)
                    <?php
                        echo "<option value= ". $i . ">" . $item->varian_name . "</option>";
                    	$i++;
                    ?>
                    @endforeach
                    </select>
                    @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Input Your Name" name="name" value="{{ old('name') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Address</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}">

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Date of Birth</label>

                <div class="col-md-6">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name='dob' class="form-control" id="datepicker"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Phone</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Input Your Phone Number" name="phone" value="{{ old('phone') }}">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input type="email" class="form-control" placeholder="Input Your Email" name="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">City</label>

                <div class="col-md-6">
                    <select class='form-control' name='city'>
                    <?php
                        echo "<option value='1'>" . "Jakarta" . "</option>";
                        echo "<option value='2'>" . "Tangerang" . "</option>";
                    ?>
                    </select>
                    @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="checkPageBtn">
                         Send me the pack!
                    </button>
                </div>
            </div>
        </form>

	</div>
</div>
@stop