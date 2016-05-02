@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Sign In or Create An Account</h2>
        <div class="row">
        <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><div class="font_padding"> Sign In Here! </div></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

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

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" placeholder="Input Your Password" name="password">

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-3">
                                    <div class="font_forgot">
                                    <button type="submit" class="checkPageBtn">
                                        <i class="fa fa-btn fa-sign-in"></i> LOG IN
                                    </button>

                                    
                                    <a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><div class="font_padding"> Register Here! </div></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        {!! csrf_field() !!}

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

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" placeholder="Input Your Password" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" placeholder="Input The Same Password" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
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

                        <div class="form-group{{ $errors->has('userType') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">User</label>

                            <div class="col-md-6">
                                <select class='form-control' name='userType'>
                                <?php
                                    echo "<option value='0'>" . "Agent" . "</option>";
                                    echo "<option value='1'>" . "Customer" . "</option>";
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
                            <label class="col-md-4 control-label">Bank Account Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Input Your Bank Account Number" name="bank" value="{{ old('bank') }}">

                                @if ($errors->has('bank'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bank') }}</strong>
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
@push('scripts')
<script type="text/javascript">
    $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

        $( "#datepicker" ).datepicker();
    });
</script>
@endpush
@endsection
