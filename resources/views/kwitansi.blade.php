<!DOCTYPE html>
<html>
<head>
	<title>Kwitansi </title>

	<style type="text/css">
		.kotak {
			width: 1000px;
			margin: auto;
			border: 1px solid;
			padding: 20px;
		}	
		table {
			border: 0;
		}
		table tr td {
			padding: 10px;
			border: 0;
		}
	</style>


</head>
<body>
	<div class="kotak">
		<img src="{{ asset('koperasi.png') }}" style="height: 100px;float: left;">
		<h1 style="text-align: center;"><u>KWITANSI</u></h1>
		<br />
		<table>
			<tr>
				<td>Telah Diterima dari</td>
				<td style="width: 2px;"> : </td>
				<td style="border-bottom: 1px solid #eee;">{{ $data->pinjaman->user->name }}</td>
			</tr>
			<tr>
				<td>Uang Sebesar</td>
				<td style="width: 2px;"> : </td>
				<td style="border-bottom: 1px solid #eee;">{{ terbilang($data->angsuran) }}</td>
			</tr>
			<tr>
				<td>Untuk Pembayaran</td>
				<td>:</td>
				<td>Cicilan pada tanggal {{ date('d F Y', strtotime($data->tanggal_bayar)) }}</td>
			</tr>
		</table>
		<br />
		<div style="width: 25%; float: left;">
			<h4 style="text-align: left;">Rp. {{ number_format($data->angsuran) }}</h4>
			<br />
			<br />
			<br />
			<hr />
		</div>
		<div style="width: 25%; float: left;margin-left: 10%;">
			<h5>Yang menyerahkan </h5>
			<br />
			<br />
			<br />
			<hr />
		</div>
		<div style="width: 25%; float: left;margin-left: 10%; text-align: center;">
			<h5>Yang menerima </h5>
			<br />
			<br />
			{{ $data->pinjaman->user->name }}
			<hr />
		</div>
	</div>
</body>
</html>