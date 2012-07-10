<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>

<!DOCTYPE HTML>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="robots" content="index, follow, noarchive" />
	<meta name="keywords" content="let's play 5, fünf gewinnt, 5 gewinnt, online game, online spiel, realtime game" />
	
	<title><?php
		/* title given by the controller*/
		echo $title_for_layout;
	?></title>
	<?php
		/* load favicon*/
		echo $this->Html->meta('icon');
		
		/*load css file*/
		echo $this->Html->css('cake');
		echo $this->Html->css('layout');
		echo $this->Html->css('form');
		echo $this->Html->css('menubar');
		echo $this->Html->css('table');
		
		/* load css file given by the controller (non theme css) */
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		/* load js files */
        echo $this->Html->script('jquery');
        echo $this->Html->script('angular/angular');
        echo $this->Html->script('angular/angular-resource');
        echo $this->Html->script('angular/angular-app');
        echo $this->Html->script('angular/angular-game-services');
		
	?>
</head>
<body ng-app="app">
    <?php echo
        //input of the logo
        $this->html->image("/img/logo.gif", array("alt" => "logo","id" => "logo"));
    ?>




    <div id="wrapper">
		<div id="login-bar">
			<?php
			    if($isGast)
				    echo $this->element('userlogin');
			    else
				    echo $this->element('userlogout',array('user'=>$currentUser));
			?>
		</div>
			
			
		<?php echo $this->element('navigation'); ?>
		<?php echo $this->Session->flash(); ?>
			
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
			
		<?php
			
			//echo $this->element('sql_dump');
			
		?>
	</div>
</body>
</html>
