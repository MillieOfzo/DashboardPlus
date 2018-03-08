<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='shortcut icon' type='image/x-icon' href='<?= URL_ROOT_IMG; ?>leaf.ico' />
	
    <title><?= APP_TITLE;?> | Maintenance</title>

	<!-- Mainly CSS -->
	<?php
		foreach($arr_css as $css){
			echo '<link href="'.$css.'" rel="stylesheet">';
		}
	?>

  </head>

<body class="gray-bg">
<?php
	$img_arr = array(
		'<i class="fa fa-fire"></i>', 
		'<i class="fa fa-code"></i>', 
		'<i class="fa fa-power-off"></i>', 
		'<i class="fa fa-puzzel-piece"></i>', 
		'<i class="fa fa-bomb"></i>', 
		'1337',
		'LIT'
		);
	function getRandomArr($ar){
		$num = array_rand($ar);
		return $ar[$num];
	}
?>
    <div class="middle-box text-center animated fadeInDown">
        <h1 style="color: #ECC37C;"><?= getRandomArr($img_arr);?></h1>
        <h3 class="font-bold">Maintenance bezig</h3>

        <div class="error-desc">
		   <p>Wacht uit of vraag status na bij de admins.
			</p>	
			<a href="<?= URL_ROOT; ?>login/redirect.php" class='btn btn-primary' >Return to safety</a>			
        </div>
    </div>

	<!-- Mainly scripts -->
	<?php
		foreach($arr_js as $js){
			echo '<script src="'.$js.'"></script>';
		}
	?>
  </body>
</html>