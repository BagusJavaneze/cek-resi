<?php
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<title>CEK RESI JNE, POS & TIKI</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet">


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
 









<script type="text/javascript">
$(document).ready(function() {


$("#btn-cek").on('click', function(e){
	e.preventDefault();

	if($("#resi").val().trim()==="" || $("#jasa").val()==="") 
	{
		alert('Semua field harus diisi!');
		return false;
	}		

	$("#iloading").show();
	var nomor_resi = $("#resi").val().trim();
	var jasa_kurir = $("#jasa").val();

	$.ajax({
		url: "i_tracking.php",
		type: "POST",
		data: {resi: nomor_resi, jasa: jasa_kurir},
		dataType: "json",
		cache: false,
		success:function(data){
			if(data['write_status'] != undefined){
				var iframetag = '<iframe id="result_iframe" src="cache/hasil_resi.html" style="width: 100%;height: 900px;border: 2px solid #eee;"></iframe>';
				$("#ihasil").html(iframetag);
			}
			else{
				var gagal = '<div class="alert alert-danger"><strong>NOMOR RESI TIDAK VALID!</strong><br>HARAP PERIKSA KEMBALI NOMOR RESI SESUAI JASA KURIR YANG DIPILIH.</div>';
				$("#ihasil").html(gagal);
			}
			$("#iloading").hide();
		}
	});
	return false;

});	


$("#iloading").hide();


});

</script>

<style type="text/css">
	.m-t-10 {
		margin-top: 10px;
	}
	.m-b-10 {
		margin-bottom: 10px;
	}
</style>

</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<h1>CEK RESI JNE, POS & TIKI</h1>
		</div>
	</div>
</div>			

<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<form method="POST" name="formku2" id="formku2">
				<div class="form-group">
			      <label for="nomor-resi">Nomor Resi: <span class="text-danger"><strong>*</strong></span></label>
			      <input class="form-control" type="search" name="resi" id="resi" placeholder="Nomor Resi..." value="" autofocus="true" required>
			    </div>
			    <div class="form-group">
			      <label for="jasa">Jasa Kurir: <span class="text-danger"><strong>*</strong></span></label>
			      <select name="jasa" id="jasa" class="form-control" required>
			        <option value="" selected>&mdash; PILIH JASA KURIR &mdash;</option>
			        <option value="jne">JNE</option>
			        <option value="pos">POS</option>
			        <option value="tiki">TIKI</option>  
			      </select>
			    </div>
				<p><span class="text-danger"><strong>*</strong></span>) wajib diisi</p>
			</form>
			<div class="btn btn-primary" id="btn-cek">Cek Resi</div>
			<div class="m-t-10 m-b-10" id="iloading">
				<img src="progress-bar.gif" width="100" height="16">loading...
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="m-t-10 m-b-10" id="ihasil"></div>
		</div>
	</div>
</div>	

</body>
</html>
