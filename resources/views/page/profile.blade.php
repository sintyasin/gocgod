@extends('layout.main_layout')

@section('content')
<div class="padding_outer">
    <div class="container">
        <h2>Profile</h2>

    	<div class="col-md-3">
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
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('Profile') }}">
                          {!! csrf_field() !!}

                          <div class="form-group">
                              <label class="col-md-4 control-label">Address</label>
                              <div class="col-md-6">
                                  <input type="text" class="form-control" name="address" value="{{Auth::user()->address}}">
                              </div>
                          </div>


                          <div class="form-group">
                              <label class="col-md-4 control-label">Phone</label>
                              <div class="col-md-6">
                                  <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Bank Account</label>
                              <div class="col-md-6">
                                  <input type="email" class="form-control" name="email" value="{{Auth::user()->bank_account}}">
                              </div>
                          </div>

                          <div class="form-group">
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
                                      <i class="fa fa-btn fa-user"></i> UPDATE
                                  </button>
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
                
                <form class="form-horizontal" role="form" method="POST" action="{{ url('Profile') }}">
                          {!! csrf_field() !!}

                          <div class="form-group">
                              <label class="col-md-4 control-label">Old Password</label>
                              <div class="col-md-6">
                                  <input type="text" class="form-control" placeholder="Input your old password" name="password">
                              </div>
                          </div>


                          <div class="form-group">
                              <label class="col-md-4 control-label">New Password</label>
                              <div class="col-md-6">
                                  <input type="text" class="form-control" placeholder="Input your new password" name="new_password">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Confirm Password</label>
                              <div class="col-md-6">
                                  <input type="email" class="form-control" placeholder="Input your new password" name="confirm_password">
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="checkPageBtn">
                                      <i class="fa fa-btn fa-user"></i> UPDATE
                                  </button>
                              </div>
                          </div>
                      </form>


              </div>
            </div>
          </div>
        </div>

        @if(Auth::user()->status == 0)
        <button type="button" class="boaBtn_boa_pf" onclick="show_next('balance')">
          My Balance
        </button>
        @endif
    	</div>

      <div id="profile">
    	<div class = "col-md-6">
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
                      	Balance: &nbsp;<b> {{Auth::user()->balance}}</b>
                      	</li>
                      @endif
                    </ul>
                </div>
            </div>
        </div>
        </div>

      <div id="balance">
      <div class = "col-md-6">
          <div class="box box-primary" >
                <div class="box-body box-profile">
                  
                  <h3 class="profile-username text-center"> {{Auth::user()->name}} - Balance </h3>
                    <p class="text-muted text-center"> 
                    @if (Auth::user()->status_user == 1)
                      Customer
                    @else
                        Agent
                    @endif
                    </p>

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
                        Balance: &nbsp;<b> {{Auth::user()->balance}}</b>
                        </li>
                      @endif
                    </ul>
                </div>
            </div>
        </div>
        </div>


    </div>
</div>



@stop
