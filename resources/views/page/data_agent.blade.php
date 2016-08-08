<div class = "col-md-8">
  <div class="box box-primary" >
    <div class="box-body box-profile">
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
      <h3 class="profile-username text-center"> {{Auth::user()->name}} </h3>
      <p class="text-muted text-center"> 
        Hari Kerja: &nbsp;
        @foreach($day as $hari)
          @if($hari->day == 1)
          <span><b> Senin </b></span>
          @elseif($hari->day == 2)
          <b> Selasa </b>
          @elseif($hari->day == 3)
          <b> Rabu </b>
          @elseif($hari->day == 4)
          <b> Kamis </b>
          @elseif($hari->day == 5)
          <b> Jumat </b>
          @elseif($hari->day == 6)
          <b> Sabtu </b>
          @elseif($hari->day == 7)
          <b> Minggu </b>
          @endif
        @endforeach
      </p>
      <center>
        <button type="button" class="boaBtnProfile" data-toggle="modal" data-target="#agentDay"> Ubah Hari </button>
        <button type="button" class="boaBtnProfile" data-toggle="modal" data-target="#agentOrigin"> Ubah Jangkauan </button>
      </center>
      <br>
      <center>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            Daerah Jangkauan:
          </li>
          @foreach($origin as $daerah)
          <li class="list-group-item">
            <b>Provinsi: {{$daerah->province_name}}</b><br>
            <b>Kota: {{$daerah->city_name}}</b><br>
            <b>Kecamatan: {{$daerah->district_name}}</b>
          </li>
          @endforeach
       </ul>
     </center>
   </div>
 </div>
</div>