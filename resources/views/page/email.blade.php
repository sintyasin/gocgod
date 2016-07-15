<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
</head>
<body>


	<div class="top_custom" style="overflow:hidden; background:rgb(1,117,96) none repeat scroll 0 0; overflow:hidden; height:40px; width:100%;">
		<div class="col-sm-12 col-sm-12">
			<div class="font_padding" style="text-align: center; font-size:20px; font-family: calibri; font-weight: bold; padding:10px; color:white;"> GoCGoD - Healthy Drink with Vitamin C and D</div>
		</div>
	</div>
	<Center>
		<!-- 	<img style="padding-top:20px; width:100px; margin-right:20px;" src="{{ URL::asset('assets/images/logo/logo.png') }}"> -->
		<p style="font-size:30px;  text-align: center; font-family:calibri; font-weight:bold; padding-top:none;"> Pesanan Anda <span style="color:red">Akan Diproses</span> </p>
		<hr>
	</Center>


	<div class="isi" style="font-family:calibri; padding-left:20px; padding-right:20px;">
		<p>Terima kasih atas kepercayaannya untuk memesan produk kami.</p>

		<p style="font-weight:bold; font-size:20px;">Informasi Pemesanan</p>
		<hr style="width: 200px; float:left;">
		<p style="padding-top:20px;"> Id Pesanan: 

		<?php $i = 0; ?>
		@foreach($order_a as $id)
		@if($i == 0)
			<span style="font-weight: bold;">{{$order_a[0]->order_id}} </span>
		@else
			<span style="font-weight: bold;">{{$id->order_id}}, </span>
		@endif
		<?php $i++; ?>
		@endforeach

		<br> Tanggal Pemesanan: <span style="font-weight: bold;">
		<!-- ini subscribe -->
		@if(is_a($order, 'Illuminate\Database\Eloquent\Collection'))
			{{$order[0]->order_date}} 
		<!-- ini beli single -->
		@else
			{{$order->order_date}} 
		@endif
		</span> <br> Agen: <span style="font-weight: bold;"> {{$agent[0]->name}} </span></p>

		<div class="container" style="width:100%;">
			<table>
				<tr>
					<th style="text-align:center;">Nama Produk</th>
					<th style="text-align:center;">Harga Produk</th>
					<th style="text-align:center;">Kuantitas</th>
				</tr>
				@foreach($orderdetails as $item)
				<tr>
					<td>{{$item->varian_name}}</td>
					<td>Rp {{number_format($item->price, 2, ',', '.')}}</td>
					<td>{{$item->quantity}}</td>
				</tr>
				@endforeach
			</table>


			<br>
			<p style="font-weight:bold; font-size:20px;">Informasi Pembayaran</p>
			<hr style="width: 200px; float:left;">
			<p style="padding-top:20px;">Ongkos Kirim: Rp {{number_format($order->shipping_fee)}}<span style=" font-size:30px;"><br> Total: <span style="font-weight: bold; color:red;">Rp {{number_format($orderprice[0]->total_price, 2,',','.')}} </span> </span> </p>


			<br>
			<p style="font-weight:bold; font-size:20px;">Cara Pembayaran </p>
			<hr style="width: 200px; float:left;">
			<p>
			<br>
			@if($order->payment_method == 0)
			Silahkan segera melakukan pembayaran dengan <span style="font-weight:bold"> Tranfer </span> uang sesuai dengan total pembayaran ke rekening.
			<br>
			<span style="font-size:20px"> GOCGOD</span>
			@elseif($order->payment_method == 1)
			Silahkan segera melakukan pembayaran melalui <span style="font-weight:bold"> ATM BERSAMA </span> dengan cara:
			@elseif($order->payment_method == 4)
			Silahkan segera melakukan pembayaran melalui <span style="font-weight:bold"> KARTU KREDIT </span> dengan cara:
			<br>

			@endif

			</p>
		</div>


	</div>

	<br>
	<br>

	<div class="top_custom" style="overflow:hidden; background:rgb(1,117,96) none repeat scroll 0 0; overflow:hidden; height:100px; width:100%;">
		<div class="col-sm-12 col-sm-12">
			<br>
			<div class="font_padding" style="font-size:15px; font-family: calibri; padding:10px; color:white;"> <span style="font-size:20px; font-weight: bold;"> GoCGoD </span><br> <span style="font-weight:bold">Alamat:</span> <span>{{$contact->address}}</span> 
				<br> <span style="font-weight:bold">WhatsApp: </span> <span>{{$contact->phone}}</span>
			</div>
		</div>
	</div>
</body>
</html>