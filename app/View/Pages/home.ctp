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
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @var $this View
 */
        if (Configure::read('debug') == 0):
	        throw new NotFoundException();
        endif;
        App::uses('Debugger', 'Utility');
?>

<h1>
    Wir begr&uuml;ssen dich auf unserer 5Gewinnt Seite!
</h1>


<p>
    Wir hoffen, dass wir dir das Spiel und alle zus&auml;tzlichen funktionen so angenehm wie m&ouml;glich gestalten konnten.
    Bei Fragen zur Bedienung kannst du gerne in unser

    <?php echo $this->Html->link(__('Benutzerhandbuch'), array('controller' => '','action' => 'files', 'Benutzerhandbuch.pdf')); ?>.

    schauen. Falls sich das Problem bis dann noch nicht gel&ouml;st hat, k&ouml;nnte es dir weiterhelfen, wenn du einen Blick in die FAQ's wirfst.<br>
    Da werden g&auml;ngige Probleme mit ihren L&ouml;sungsvarianten beschrieben.
    Ansonsten w&uuml;nschen wir dir viel Spass & Erfolg beim Spielen und hoffen nat&uuml;rlich, dass du &uuml;ber das Spiel spannende & Interessante Gegner finden kannst.
</p>
<p>
    Wir hoffen, dass Ihr Gefallen an unserer Seite findet und sind nat&uuml;rlich offen f&uuml;r Optimierungsvorschl&auml;ge.
    <h2>
        Ihr 5Gewinnt Team
    </h2>
</p>
<p style="text-align: center;">
    <?php 
	
	if(!$isGast)
		$url = array('controller' => "games", "action" => "play");
	else
		$url = array('controller' => "users", "action" => "add");
	
	//input for the play button
	echo $this->html->image("/img/letsgo.png", array("alt" => "3.2.1 let's go", "url" => $url));
    ?>
</p>

