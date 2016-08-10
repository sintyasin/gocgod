@extends('layout.email_layout')

@section('content')


<p style="font-size:20px;  text-align: center; font-family:calibri; font-weight:bold; padding-top:20px;"> Hi {{$name}},<br>
</p>
<hr>


<div style="padding:10px 0;margin:0 !important;line-height:150%;font-size:16px;color:#000;">

	GoCGoD.com telah menerima sebuah permohonan untuk mengatur ulang password akun Anda. <br>
	Jika Anda tidak meminta untuk mengatur ulang password Anda, mohon abaikan email ini. <br><br>

	<a href="{{ url('admin/do/password/reset', $token).'?email='.urlencode($email) }}"><button type="button"
	style="
	display: inline-block;
	padding: 6px 12px;
	margin-bottom: 0;
	font-size: 14px;
	font-weight: normal;
	line-height: 1.42857143;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	-ms-touch-action: manipulation;
	touch-action: manipulation;
	cursor: pointer;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-image: none;
	border: 1px solid transparent;
	border-radius: 4px;

	color: #fff;
	background-color: #5bc0de;
	border-color: #46b8da;
	">Atur ulang password Anda Sekarang</button></a>

	<br><br>
	Jika tombol tidak berfungsi, silahkan mengakses dengan cara salin dan tempel tautan berikut:

	<br><br>
	<div style="width:80%;">
		<strong>{{ url('password/reset', $token).'?email='.urlencode($email) }}</strong>
	</div>

</div>


@stop