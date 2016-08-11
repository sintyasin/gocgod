@extends('layout.email_layout')

@section('content')

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
			<span style="font-weight: bold;">,{{$id->order_id}} </span>
		@endif
		<?php $i++; ?>
		@endforeach

		<br> Tanggal Pemesanan: <span style="font-weight: bold;"> {{$order->order_date}} </span> <br> Agen: <span style="font-weight: bold;"> {{$agent[0]->name}} </span></p>

		<div class="container" style="width:100%;">
			<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
				<tr>
					<th style="text-align:center; border: 1px solid #dddddd; padding: 8px;">Nama Produk</th>
					<th style="text-align:center; border: 1px solid #dddddd; padding: 8px;">Harga Produk</th>
					<th style="text-align:center; border: 1px solid #dddddd; padding: 8px;">Kuantitas</th>
				</tr>

				<?php $i = 0; ?>
				@foreach($orderdetails as $item)
				
				@if($i % 2 == 0)
					<tr style="background-color: #dddddd;">
				@else
					<tr>
				@endif
						<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->varian_name}}</td>
						<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Rp {{number_format($item->price, 2, ',', '.')}}</td>
						<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->quantity}}</td>
					</tr>

				<?php $i++; ?>
				@endforeach
			</table>


			<br>
			<p style="font-weight:bold; font-size:20px;">Informasi Pembayaran</p>
			<hr style="width: 200px; float:left;">

				<p style="padding-top:20px;">
					<span style=" font-size:17px;">

					@if($order->who == 'subscriber')
						Periode berlangganan: {{$week}} minggu <br>
						Sub total per minggu: Rp {{number_format($totalperweek)}} <br>
					@endif

					Ongkos Kirim: Rp {{number_format($order->shipping_fee)}}

					</span>

					<span style=" font-size:30px;"><br> Total: <span style="font-weight: bold; color:red;">Rp {{number_format($orderprice[0]->total_price, 2,',','.')}} </span> </span>
				</p>


				<br>
				@if($order->payment_method != 4) <!-- bayar pake bank transfer / atm bersama -->
					<p style="font-weight:bold; font-size:20px;">Cara Pembayaran </p>
					<hr style="width: 200px; float:left;">
				@elseif($order->payment_method == 4) <!-- ini bayar pake kartu kredit -->
					<p style="font-weight:bold; font-size:20px;">Pembayaran melalui <span style="font-weight:bold"> KARTU KREDIT </span> {{$status_payment}} </p>
				@endif
				
				<p>
				<br>
				@if($order->payment_method == 0)
				Silahkan segera melakukan pembayaran dengan <span style="font-weight:bold"> Tranfer </span> uang sesuai dengan total pembayaran ke rekening.
				<br>
				<span style="font-size:20px"> GOCGOD</span>
				@elseif($order->payment_method == 1)
				Silahkan segera melakukan pembayaran melalui <span style="font-weight:bold"> ATM BERSAMA </span>, KODE PEMBAYARAN ATM <span style="font-weight:bold"> {{$paymentaccount}} </span> dengan cara:
				<br>
				<br>
				<span style="font-weight:bold"> ATM BCA/ Jaringan Prima </span><br>
				1. &nbsp;&nbsp;Masukkan Kartu Debit anda ke dalam mesin ATM.<br>
				2. &nbsp;&nbsp;Pilih Bahasa<br>
				3. &nbsp;&nbsp;Masukkan PIN<br>
				4. &nbsp;&nbsp;Pilih &quot;Transaksi Lainnya.&quot;<br>
				5. &nbsp;&nbsp;Pilih Transfer<br>
				6. &nbsp;&nbsp;Pilih &quot;Ke Rek Bank Lain&quot;<br>
				7. &nbsp;&nbsp;Masukkan Kode Institusi ({{$bankcode}}) Kemudian Tekan &quot;Benar&quot;.<br>
				8. &nbsp;&nbsp;Masukkan jumlah pembayaran sesuai yang ditagihkan (harus sama). Jika berbeda, transaksi akan digagalkan.<br>
				9. &nbsp;&nbsp;Masukkan Kode Pembayaran ATM (sesuai yang ditampilkan di samping) kemudian tekan &quot;Benar&quot;.<br>
				10. Muncul layar konfirmasi transfer yang berisi:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Kode Pembayaran ATM<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nama Customer<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Jumlah yang akan dibayar<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jika sudah benar, tekan &quot;Benar&quot;.<br>
				11. Transaksi sudah selesai.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Anda akan menerima struk sebagai bukti transaksi.

				<br>
				<br>
				<span style="font-weight:bold"> ATM MANDIRI/ Jaringan ATM Bersama </span><br>
				1. &nbsp;&nbsp;Masukkan Kartu Debit anda ke dalam mesin ATM.<br>
				2. &nbsp;&nbsp;Pilih Bahasa<br>
				3. &nbsp;&nbsp;Masukkan PIN<br>
				4. &nbsp;&nbsp;Pilih &quot;Transaksi Lainnya.&quot;<br>
				5. &nbsp;&nbsp;Pilih Transfer<br>
				6. &nbsp;&nbsp;Pilih &quot;Ke Rekening Bank Lain ATM Bersama/Link&quot;.<br>
				7. &nbsp;&nbsp;Masukkan Kode Institusi ({{$bankcode}}) disambung Kode Pembayaran ATM, kemudian tekan &quot;Benar&quot;.<br>
				8. &nbsp;&nbsp;Masukkan jumlah pembayaran sesuai yang ditagihkan (harus sama). Jika berbeda, transaksi akan digagalkan.<br>
				9. &nbsp;&nbsp;Kosongkan nomor referensi transfer kemudian tekan &quot;Benar&quot;.<br>
				10. Muncul layar konfirmasi transfer yang berisi:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Kode Pembayaran ATM<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nama Customer<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Jumlah yang akan dibayar<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jika sudah benar, tekan &quot;Benar&quot;.<br>
				11. Transaksi sudah selesai.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Anda akan menerima struk sebagai bukti transaksi.

				@endif
			

				</p>
		</div>


	</div>

@stop