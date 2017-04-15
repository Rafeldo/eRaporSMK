<?php
$s = Datasiswa::find($siswa_id);
$sekolah = Datasekolah::first();
$setting = Setting::first();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Rapor</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.6 -->
<?php echo link_tag('assets/bootstrap/css/bootstrap.min.css', 'stylesheet', 'text/css'); ?>
<style>
body{background:#FFFFFF !important; background-color:#FFFFFF;font-family:Times; font-size:12px;}
h3{font-size:14px;}
table tr td,table tr th{padding:5px;}
.table th{background-color:#FFFFCC !important}
.strong {font-weight:bold;}
</style>
</head>
<body>