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
        @if (Auth::user()->status_user == 1)
        Pelanggan
        @else
        Agen
        @endif
      </p>
      <center>
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            Alamat: &nbsp;<b> {{Auth::user()->address}}</b>
          </li>
          <li class="list-group-item">
            Kecamatan: &nbsp;<b> {{$district->district_name}}</b>
          </li>
          <li class="list-group-item">
            Kota: &nbsp;<b> {{$city->city_name}}</b>
          </li>
          <li class="list-group-item">
            Provinsi: &nbsp;<b> {{$province->province_name}}</b>
          </li>
          <li class="list-group-item">
            Kode Pos: &nbsp;<b> {{Auth::user()->zipcode}}</b>
          </li>
          <li class="list-group-item">
            Tanggal Lahir: &nbsp;<b> {{Auth::user()->date_of_birth}}</b>
          </li>
          <li class="list-group-item">
            Telepon:&nbsp;<b> {{Auth::user()->phone}}</b>
          </li>
          <li class="list-group-item">
            Email: &nbsp;<b> {{Auth::user()->email}}</b>
          </li>
          @if(Auth::user()->status_user==0)
          <li class="list-group-item">
           Akun Bank: &nbsp;<b> {{Auth::user()->bank_account}}</b>
         </li>
         <li class="list-group-item">
           Jumlah: &nbsp;<b> Rp {{Auth::user()->balance}}</b>
         </li>
         @endif
       </ul>
     </center>
   </div>
 </div>
</div>