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
                    <input type="text" class="form-control" placeholder="Nomor rekening yang Anda gunakan" name="bank_account" onkeypress="return isNumber(event)">

                    @if ($errors->has('bank_account'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bank_account') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('hari') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Hari</label>
                <div class="col-md-6">
                    <select class="selectpicker" id="day" name="hari[]" multiple title="-- Pilih hari --">
                      <option value="1">Senin</option>
                      <option value="2">Selasa</option>
                      <option value="3">Rabu</option>
                      <option value="4">Kamis</option>
                      <option value="5">Jumat</option>
                      <option value="6">Sabtu</option>
                      <option value="7">Minggu</option>
                  </select>

                  @if ($errors->has('hari'))
                  <span class="help-block">
                    <strong>Hari harus diisi</strong>
                  </span>
                @endif
                </div>
            </div>

            <div class="input_fields_wrap">
                <center>
                <button class="add_field_button" style="width: 150px; min-height: 40px; border-radius: 5px;">Add More Product</button>
                </center>
                <div class="form-group{{ $errors->has('provinsi') ? ' has-error' : '' }}">
                <br>
                <label class="col-md-4 control-label">Provinsi</label>
                <div class="col-md-6">
                <select id="basic" name="province" class="province selectpicker show-tick form-control" data-live-search="true">
                <option selected="selected">-- Pilih Provinsi --</option>
                @foreach($province as $data)
                  <option value="{{$data->province_id}}" id="{{$data->province_id}}">{{ $data->province_name}}</option>
                @endforeach
                </select>
                </div>
                </div>

                
            </div>


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
    // $(".day").change(function()
    // {
    //     var id=$(this).val();
    //     $.ajax
    //     ({
    //       type: "POST",
    //       url: "{{ URL::to('')}}",
    //       data: {id: id},
    //       beforeSend: function(request){
    //         return request.setRequestHeader('x-csrf-token', $("meta[name='_token']").attr('content'));
    //     },
    //     cache: false,
    //     success: function(html)
    //     {
    //       $("#basic_city").html(html)
    //         .selectpicker('refresh');

    //       $("#basic_district").html('<option selected="selected">-- Pilih Kecamatan --</option>')
    //         .selectpicker('refresh');
    //     } 
    //     });
    // });

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
                }
            });

            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
            })
        }
    });

    function isNumber(evt) 
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    // function register()
    // {
    //     var id=$('#day').val();
    //     $('#hari').val(id);
    //     alert($('#hari').val());
    //     // var arr = id.split(',');
    //     // for(var i=0; i<arr.length; i++){
    //     // alert(arr[i]);}
    //     alert(id);

    // }

    $(function() {
        var date = $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();

        $( "#datepicker" ).datepicker();
    });
</script>
@endpush

@stop
