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
          
       </ul>
     </center>
   </div>
 </div>
</div>