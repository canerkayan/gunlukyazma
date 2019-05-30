<!DOCTYPE html>
<html>
<head>
<title>Günlük | Anasayfa</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="text-align: center;">

<div class="row mt5e">
	<h1 class="logo_kayit"><i>Günlük</i></h1>
</div>

<?php
include('db.php');


if ($_REQUEST['action']=='giriskontrol') {
	session_start();
	$gelen_kullanici_adi=$_POST['kadi']; 
	$gelen_kullanici_sifre=$_POST['sifre']; 
	mysql_connect("localhost","teknogoz_gunluk","R@6(HbZv9,{N"); 
	mysql_select_db("teknogoz_gunluk"); 

	$sorgu="SELECT * FROM kullanici WHERE kadi='$gelen_kullanici_adi' AND sifre='$gelen_kullanici_sifre'";
	$kontrol=mysql_query($sorgu); 
	$sayi=mysql_num_rows($kontrol); 
	if ($sayi!=0) { 
		$_SESSION['oturum']=true; 
		$_SESSION['kullanici_adi']= $gelen_kullanici_adi; 
		header("refresh: 0; url=anasayfa.php"); 
	} elseif($gelen_kullanici_adi=="" && $gelen_kullanici_sifre=="") {
		echo"Kullanıcı Adı ve Şifre Boş Geçilemez"; 
		header("refresh: 3; url=index.php");
	} elseif(empty($gelen_kullanici_adi)) {
		echo"Kullanıcı Adı Boş Geçilemez"; 
		header("refresh: 3; url=index.php");
	} elseif(empty($gelen_kullanici_sifre)) {
		echo"Şifre Boş Geçilemez"; 
		header("refresh: 3; url=index.php");
	} else {
		echo"Kullanıcı Adı Veya Şifre Yanlış"; 
		header("refresh: 3; url=index.php"); 
	} 
} elseif($_REQUEST['action']=='cikis') {
	session_start();
	$_SESSION = array();
	session_destroy();
	header("refresh: 0; url=index.php");
} elseif($_REQUEST['action']=='kayitol') {
	$kadi = $_POST['kadi'];
	$sifre = $_POST['sifre'];
	$eposta = $_POST['eposta'];
	$tel = $_POST['tel'];
	$dtarih = $_POST['dtarih'];
	$sehir = $_POST['sehir'];

	$sorgu = $db->query("SELECT * FROM kullanici WHERE kadi='$kadi'");
	$row = mysqli_fetch_array($sorgu);
	$kullanici_adi = $row['kadi'];

	if ($kadi === $kullanici_adi) {
	    header("refresh: 3; url=kayitol.php");
		echo "Aynı kullanıcı adı bulunduğundan dolayı kaydınız gerçekleşmemektedir.";
	} else {
		$kayit = $db->query("INSERT INTO kullanici (kadi, sifre, eposta, tel, dtarih, sehir) VALUES ('$kadi', '$sifre', '$eposta', '$tel', '$dtarih', '$sehir')");

		if($kayit){
	        header("Location: index.php");
	    }else{
	        header("Location: hata.php");
	    }
	}

} elseif($_REQUEST['action']=='fotograf_sil') {
	$id = $_GET['id'];

	$sil = $db->query("DELETE FROM fotograf WHERE id='$id'");

	if ($sil) {
		header("Location: fotograf.php");
	} else {
		header("Location: hata.php");
	}
} 

?>

</body>
</html>