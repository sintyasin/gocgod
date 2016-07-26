@extends('layout.email_layout')

@section('content')

	<p style="font-size:20px;  text-align: center; font-family:calibri; font-weight:bold; padding-top:20px;"> Hi {{$name}}, Selamat Datang di GoCGoD! <br>
	</p>
	<hr>
	

	<div style="padding:10px 0;margin:0 !important;line-height:150%;text-align:center;font-size:16px;color:#000;">

		Silahkan verifikasi email-mu dengan klik tombol berikut <br><br>

		<a href="{{$link}}"><button type="button" style=
			"display: inline-block;
			margin-bottom: 0;
			font-weight: normal;
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

			color: #fff;
			background-color: #5bc0de;
			border-color: #46b8da;

			padding: 10px 16px;
			font-size: 18px;
			line-height: 1.3333333;
			border-radius: 6px;
			">Verifikasi Email</button></a>

		<br><br>
		Jika tombol tidak berfungsi, silahkan mengakses dengan cara salin dan tempel tautan berikut:

		<br><br>
		<strong>{{$link}}</strong>

	</div>

@stop