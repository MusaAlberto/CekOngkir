<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Cek Ongkos Kirim</h3>
					</div>
					<div class="panel-body">
						<div>
							<?php
							//Get Kota/Kabupaten Asal
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_URL 			=> "http://api.rajaongkir.com/starter/city",
								CURLOPT_RETURNTRANSFER 	=> true,
								CURLOPT_ENCODING		=> "",
								CURLOPT_MAXREDIRS		=> 10,
								CURLOPT_TIMEOUT 		=> 30,
								CURLOPT_HTTP_VERSION	=> CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST 	=> "GET",
								CURLOPT_HTTPHEADER 		=> array(
									"key:2986c48cf1c63d0aedff0d4c36eee6bc"
								),
							));

							$response 	= curl_exec($curl);
							$err 		= curl_error($curl);

							curl_close($curl);
							echo "
							<div class= \"form-group\">
								<label for=\"asal\">Kota/Kabupaten Asal </label>
								<select class=\"form-control\" name='asal' id='asal'>";
								echo "<option>Pilih Kota/Kabupaten Asal</option>";
								$data = json_decode($response, true);
								for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
								echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
							}
							echo "</select>
							</div>";

							//Get Kota/Kabupaten Tujuan
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_HTTPHEADER => array(
									"key:2986c48cf1c63d0aedff0d4c36eee6bc"
								),
							));

							$response 	= curl_exec($curl);
							$err 		= curl_error($curl);

							curl_close($curl);
							echo "
							<div class= \"form-group\">
								<label for=\"asal\">Kota/Kabupaten Tujuan </label>
								<select class=\"form-control\" name='kabupaten' id='kabupaten'>";
								echo "<option>Pilih Kota/Kabupaten Tujuan</option>";
								$data = json_decode($response, true);
								for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
								echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
							}
							echo "</select>
							</div>";

							?>

							<div class="form-group">
								<label for="kurir">Kurir</label><br>
								<select class="form-control" id="kurir" name="kurir">
									<option value="jne">JNE</option>
									<option value="tiki">TIKI</option>
									<option value="pos">POS INDONESIA</option>
								</select>
							</div>
							<div class="form-group">
								<label for="berat">Berat Kiriman (gram)</label><br>
								<input class="form-control" id="berat" type="text" name="berat" value="500" />
							</div>
							<button class="btn btn-info" id="cek" type="submit" name="button">Cek Ongkir</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Hasil</h3>
					</div>
					<div class="panel-body">
						<ol>
							<div id="ongkir"></div>
						</div>
					</ol>
				</div>
			</div>
		</div>
		<footer>
			<div class="row">
				<div class="col-md-12">
					<p align="right">Musa Alberto Pasha</p>
				</div>
			</div>
		</footer>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		$("#cek").click(function(){
			var asal 	= $('#asal').val();
			var kab 	= $('#kabupaten').val();
			var kurir 	= $('#kurir').val();
			var berat 	= $('#berat').val();

			$.ajax({
				type : 'POST',
				url  : 'http://localhost/kurir/cek_ongkir.php',
				data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
					$("#ongkir").html(data);
				}
			});
		});
	});
</script>
