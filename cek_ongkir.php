<?php

	$asal 			= $_POST['asal'];
	$id_kabupaten 	= $_POST['kab_id'];
	$kurir 			= $_POST['kurir'];
	$berat 			= $_POST['berat'];

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL 			=> "http://api.rajaongkir.com/starter/cost",
		CURLOPT_RETURNTRANSFER 	=> true,
		CURLOPT_ENCODING 		=> "",
		CURLOPT_MAXREDIRS 		=> 10,
		CURLOPT_TIMEOUT 		=> 30,
		CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST 	=> "POST",
		CURLOPT_POSTFIELDS 		=> "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
		CURLOPT_HTTPHEADER 		=> array(
			"content-type: application/x-www-form-urlencoded",
			"key:2986c48cf1c63d0aedff0d4c36eee6bc"
		),
	));

	$response 	= curl_exec($curl);
	$err 		= curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$data = json_decode($response, true);
	}
?>

<div>
	<label>Kota Asal</label>&emsp;&emsp;:&emsp;<?php echo $data['rajaongkir']['origin_details']['city_name'];?>
</div>
<div>
	<label>Kota Tujuan</label>&emsp;:&emsp;<?php echo $data['rajaongkir']['destination_details']['city_name'];?>
</div> 
<div>
	<label>Berat</label>&emsp;&emsp;&emsp;&emsp;:&emsp;<?php echo $berat;?>gram 
</div>
<div>
	<label>Kurir</label>&emsp;&emsp;&emsp;&emsp; :&emsp;<?php echo strtoupper($kurir); ?>
</div>

<?php
for ($k=0; $k < count($data['rajaongkir']['results']); $k++) {
	?>

	<div title="<?php echo strtoupper($data['rajaongkir']['results'][$k]['name']);?>" style="padding:10px">
		<table class="table table-striped">
			<tr>
				<th>No.</th>
				<th>Jenis Layanan</th>
				<th>ETD</th>
				<th>Tarif</th>
			</tr>
			<?php
			for ($l=0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {
				?>
				<tr>
					<td><?php echo $l+1;?></td>
					<td>
						<div style="font:bold 16px Arial"><?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['service'];?></div>
						<div style="font:normal 11px Arial"><?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['description'];?></div>
					</td>
					<td>&nbsp;<?php echo $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd'];?> days</td>
					<td><?php echo number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value']);?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>

<?php
}
?>
