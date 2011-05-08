<html>
<head>
<title>img upload</title>
<?php
$id=73623728;//id uit database
if(isset($_FILES)){
	if($_FILES["img"]["error"]>0){
		echo "fail";
	}else{
		if ((($_FILES["img"]["type"] == "image/jpeg")|| ($_FILES["img"]["type"] == "image/gif")|| ($_FILES["img"]["type"] == "image/png")|| ($_FILES["img"]["type"] == "image/png")|| ($_FILES["img"]["type"] == "image/jpg"))
			&& ($_FILES["img"]["size"] < 1000000)){
				$orimg=$_FILES["img"]["tmp_name"];
				$orsize=getimagesize($orimg);
				$orw=$orsize[0];
				$orh=$orsize[1];
				$xscale=100/$orw;
				$yscale=150/$orh;
				$scale=min($xscale,$yscale);
				$new=($orw*$scale);
				$neh=($orh*$scale);
				$nex=(($orw*$xscale)-$new)/2;
				$ney=(($orh*$yscale)-$neh)/2;
				switch($_FILES["img"]["type"]){
					case "image/gif":
						$image = imagecreatefromgif($orimg);
					break;
					case "image/png":
						$image = imagecreatefrompng($orimg);
					break;
					default:
						$image = imagecreatefromjpeg($orimg);
					break;
				}
				$destination = imagecreatetruecolor( 100,  150);
				imagecopyresampled($destination, $image, $nex, $ney, 0, 0, $new, $neh, $orw, $orh);
				header('Content-Type: image/jpg');
				$testr=imagejpeg($destination,$id."_img.jpg",100);
				imagedestroy($image);
    			imagedestroy($destination);
    			echo "<img src='".$id."_img.jpg' width='100' height='150'>";
			}else{
				echo "verkeert type en/of te groot";
		}
	}
}
?>
</head>
<body>
<form action='' method='post' enctype="multipart/form-data">
select img<br>
<input name="img" type='file'></input>
<input type='submit'></input>
</form>
</body>
</html>