@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Profile</h2>

    	<div class="col-md-3">
        @if(Auth::user()->status_user == 0)
        <button type="button" class="boaBtn_boa_pf" onclick="show_balance('profile')">
          My Profile
        </button>
        @endif

        <!-- Button trigger modal -->
        <button type="button" class="boaBtn_boa_pf" data-toggle="modal" data-target="#myModal">
          Edit Profile Data
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Edit Profile Data
              </div>
              <div class="modal-body">
                
                <form class="form-horizontal" role="form" method="POST" action= {{ URL('edit_profile') }} >
                  {!! csrf_field() !!}

                  <div class="form-group">
                      <label class="col-md-4 control-label">Name</label>

                      <div class="col-md-8">
                          <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled/>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                      <label class="col-md-4 control-label">Date Of Birth</label>

                      <div class="col-md-8">
                          <div class='input-group date' id='datetimepicker1'>
                              <input type='text' name="dob" class="datepicker form-control" value="{{ Auth::user()->date_of_birth }}" disabled/>
                              <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                          </div>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('city') || $errors->first('newcity') ? ' has-error' : '' }}">
                      <label class="col-md-4 control-label">City</label>

                      <div class="col-md-8">
                          <select onclick="javascript:check();" class="form-control" id="city" name="city" >
                            @foreach($city as $data)
                              @if(Auth::user()->city_id == $data->city_id)
                                <option value="{{ $data->city_id }}" selected >{{ $data->city_name }}</option>
                              @else
                                <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                              @endif
                            @endforeach
                              <option value="0">New City</option>
                          </select>
                          <div id="newcity" style="display:none;">
                            <br>
                            <input type='text' class="form-control" placeholder="New city name" name="newcity" >
                          </div>
                          @if ($errors->has('city'))
                          <span class="help-block">
                              <strong>{{ $errors->first('city') }}</strong>
                          </span>
                          @endif
                          @if ($errors->has('newcity'))
                          <span class="help-block">
                              <strong>{{ $errors->first('newcity') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                      <label class="col-md-4 control-label">Address</label>

                      <div class="col-md-8">
                          <textarea class="form-control" name="address" rows="3">{{ Auth::user()->address }}</textarea>

                          @if ($errors->has('address'))
                          <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                      <label class="col-md-4 control-label">Phone</label>

                      <div class="col-md-8">
                          <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

                          @if ($errors->has('phone'))
                          <span class="help-block">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label class="col-md-4 control-label">Email</label>

                      <div class="col-md-8">
                          <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">

                          @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-md-offset-4">
                          <button type="submit" class="btn btn-primary">Submit</button>     
                          &nbsp; &nbsp;
                          <a href={{ URL('profile/'.Auth::user()->id) }} class="btn btn-default">Cancel</a>
                      </div>
                  </div>
                  </form>


              </div>
            </div>
          </div>
        </div>


        <!-- Button trigger modal -->
        <button type="button" class="boaBtn_boa_pf" data-toggle="modal" data-target="#myPassword">
          Edit Password
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Edit Password
              </div>
              <div class="modal-body">
                
                {!! Form::open(array('url' => 'edit_password', 'method' => 'post', 'class' => 'form-horizontal')) !!}
            

                    <div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Current Password</label>

                        <div class="col-md-8">
                            <input type='password' name="pass" class="form-control"/>

                            @if ($errors->has('pass'))
                            <span class="help-block">
                                <strong>{{ $errors->first('pass') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">New Password</label>

                        <div class="col-md-8">
                            <input type='password' name="newpassword" class="form-control"/>

                            @if ($errors->has('newpassword'))
                            <span class="help-block">
                                <strong>{{ $errors->first('newpassword') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('newpassword_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Confirm New Password</label>

                        <div class="col-md-8">
                            <input type='password' name="newpassword_confirmation" class="form-control"/>

                            @if ($errors->has('newpassword_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('newpassword_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Submit</button>     
                            &nbsp; &nbsp;
                            <a href={{ URL('profile/'.Auth::user()->id) }} class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                {!! Form::close() !!}

              </div>
            </div>
          </div>
        </div>

        @if(Auth::user()->status_user == 0)
        <button type="button" class="boaBtn_boa_pf" onclick="show_balance('balance')">
          My Balance
        </button>
        @endif
    	</div>

      <div id="profile">
    	<div class = "col-md-8">
       		<div class="box box-primary" >
                <div class="box-body box-profile">
                	
                	<h3 class="profile-username text-center"> {{Auth::user()->name}} </h3>
                    <p class="text-muted text-center"> 
                    @if (Auth::user()->status_user == 1)
                    	Customer
                    @else
                        Agent
                    @endif
                    </p>
                    <center>
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        Address: &nbsp;<b> {{Auth::user()->address}}</b>
                      </li>
                      <li class="list-group-item">
                        Date of Birth: &nbsp;<b> {{Auth::user()->date_of_birth}}</b>
                      </li>
                      <li class="list-group-item">
                        Telephone:&nbsp;<b> {{Auth::user()->phone}}</b>
                      </li>
                      <li class="list-group-item">
                        Email: &nbsp;<b> {{Auth::user()->email}}</b>
                      </li>
                      @if(Auth::user()->status_user==0)
                      	<li class="list-group-item">
                      	Bank Account: &nbsp;<b> {{Auth::user()->bank_account}}</b>
                      	</li>
                      	<li class="list-group-item">
                      	Balance: &nbsp;<b> Rp {{Auth::user()->balance}}</b>
                      	</li>
                      @endif
                    </ul>
                    </center>
                </div>
            </div>
        </div>
        </div>

      <div id="balance">
      <div class = "col-md-8">
          <div class="box box-primary" >
                <div class="box-body box-profile">
                  
                  <h3 class="profile-username text-center"> {{Auth::user()->name}} - Balance </h3>
                    <p class="text-muted text-center" style="font-weight: bold;"> Balance: Rp {{number_format(Auth::user()->balance,0, ',' , '.')}} </p>
                    <center>
                    <button type="button" class="boaBtnProfile" data-toggle="modal" data-target="#withdrawMoney"> Withdraw Money </button>
                    </center>
                     
                    <br>
                    <?php $i=0; ?>
                    <table id="" class="display table table-striped table-bordered dt-responsive" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Date</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Description</th>
                          <th>Status Tranferred</th>
                        </tr>
                      </thead>
                      @foreach($querybalance as $query)
                      @if($query->balance_type == 0 || $query->balance_type == 1)
                      <tbody>
                        
                        <td>{{$i+1}}</td>
                        <td>{{$query->created_at}}</td>
                        <td>@if($query->balance_type == 0)
                        Withdraw
                        @elseif ($query->balance_type == 1)
                        Fee
                        @endif</td>
                        <td>Rp {{number_format($query->amountMoney, 0, ',', '.')}}</td>
                        <td>@if($query->balance_type == 0)
                        .
                        @elseif ($query->balance_type == 1)
                        From Order {{$query->status}}
                        @endif</td>
                        <td>@if($query->balance_type == 0 && $query->statusTransfer == 0)
                        Processed
                        @elseif ($query->balance_type == 0 && $query->statusTransfer == 1)
                        Tranferred
                        @endif
                        </td>

                        <?php $i++;?>
                        
                      </tbody>
                      @endif
                      @endforeach


                    </table>
                </div>
            </div>
        </div>
        </div>

        <div class="modal fade" id="withdrawMoney" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Withdraw Money
              </div>
              <div class="modal-body">
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('withdrawMoney')}}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                      <center>
                        <div class="col-md-12">
                        <label class="control-label" style="padding-bottom: 30px;"><b>YOUR BALANCE IS Rp {{number_format(Auth::user()->balance, 0, ',', '.')}}</b>
                        </label>
                        </div>
                        <div class="col-md-12">
                        <label class="control-label" style="padding-bottom: 10px;">How much do you want to withdraw?
                        </label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" style="width:50%" name="money">
                        </div>
                      </center>
                    </div>

                    <div class="form-group">
                        <center>
                        <div class="col-md-12">
                        <br>
                        <br>
                            <button type="submit" class="checkPageBtn">
                             Withdraw
                            </button>
                        </div>
                        </center>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>


    </div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
      $('table.display').DataTable( {
        "autoWidth": false
      } );
  } );

  function check() {
    var e = document.getElementById('city');
    if (e.options[e.selectedIndex].value == 0) {
        document.getElementById('newcity').style.display = 'block';
    }
    else document.getElementById('newcity').style.display = 'none';
  }
</script>
@endpush
@stop
