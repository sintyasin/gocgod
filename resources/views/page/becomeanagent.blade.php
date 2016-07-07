@extends('layout.main_layout')

@section('content')



<div class="container">
	<div class="padding_outer">
		<h2>Bergabung menjadi Agen</h2>
	</div>

	<div class="container">
		<div class="padding_outer">
            <div class="row">
                @if (session('error'))
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ session('error') }}</strong>
                    </div>
                @elseif(session('success'))
                     <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif

                @if($request == 1)
                <div class="col-md-12">
                    <h5 style="color:black;">Terima kasih telah mendaftar menjadi agen. Pihak Goc God akan menghubungi anda</h5>
                </div>
                @endif
            </div>

			<!-- Button trigger modal -->
            @if(Auth::guest())
            Silahkan masuk terlebih dahulu atau <a href={{ URL('/login')}} class="testimonial_custom"> klik disini untuk daftar baru </a>
			@elseif(Auth::user()->status_user == 1 && $request == 0)
            <button type="button" class="boaBtn_boa" data-toggle="modal" data-target="#myModal">
              Daftar menjadi Agen
            </button>
            @endif

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal_header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	BERGABUNG MENJADI AGEN
			      </div>
			      <div class="modal-body">
			        
			      	<form class="form-horizontal" role="form" method="POST" action="{{ url('request_agent') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" value="0" name = "userType">                        

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
                            <label class="col-md-4 control-label">Nomor rekening</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Nomor rekening yang Anda gunakan" name="bank_account">

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
                                    <i class="fa fa-btn fa-user"></i> DAFTAR
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
