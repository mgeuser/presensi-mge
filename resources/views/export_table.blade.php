<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		table tr td,th{
			padding: 10px;
			border: 1px solid gray;
		}
		table{
			border-collapse: collapse;
			margin: 10px;
		}
	</style>
</head>
<body>
	@foreach($allData as $data)
	<div style="display: inline-table;margin-right: 10px;">
		<?php /*
		<h2>{{$data->username}}</h2>
		@foreach($data->listPresensi as $presensi)
		<div style="display: inline-table;margin-right: 5px;">
			{{$presensi->tanggal_masuk}}<br><br><br>
		</div>
		<div style="display: inline-table;margin-right: 5px;">
			{{str_replace(":",",",substr($presensi->jam_masuk,0,5))}}<br>
			00.00<br>
			00.00<br>
			<?php
				if($presensi->pulang != null && $presensi->pulang != "") echo str_replace(":",",",substr($presensi->jam_pulang,0,5));
				else echo "<span style='color:red;'>".str_replace(":",",",substr($presensi->jam_pulang_temp,0,5))."</span>";
			?>
		</div>
		@endforeach
		*/ ?>
		<table>
			<tr>
				<th colspan="2">{{$data->username}}</th>
			</tr>
			<tr>
				<th>Tanggal</th>
				<th>Waktu</th>
			</tr>
			@foreach($data->listPresensi as $presensi)
			<tr>
				<td>{{$presensi->tanggal_masuk}}</td>
				<td>{{str_replace(":",",",substr($presensi->jam_masuk,0,5))}}</td>
			</tr>
			<tr>
				<td></td>
				<td>00.00</td>
			</tr>
			<tr>
				<td></td>
				<td>00.00</td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php
				if($presensi->pulang != null && $presensi->pulang != "") echo str_replace(":",",",substr($presensi->jam_pulang,0,5));
				else echo "<span style='color:red;'>".str_replace(":",",",substr($presensi->jam_pulang_temp,0,5))."</span>";
				?>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	@endforeach
</body>
</html>