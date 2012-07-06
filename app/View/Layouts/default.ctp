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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="robots" content="index, follow, noarchive" />
	<meta name="keywords" content="let's play 5, fünf gewinnt, 5 gewinnt, online game, online spiel, realtime game" />
	
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('layout');
		echo $this->Html->css('form');
		echo $this->Html->css('menubar');
		echo $this->Html->css('table');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
        echo $this->Html->script('angular/angular');
        echo $this->Html->script('angular/angular-resource');
        echo $this->Html->script('angular/angular-app');
	?>
</head>
<body ng-app="app">
	
	
	<div id="wrapper">
			<?php echo $this->element('userlogin'); ?>
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
