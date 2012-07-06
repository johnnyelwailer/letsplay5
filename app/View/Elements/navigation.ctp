<div id="navigation" class="toolbar-gradient">
	<div class="background"></div>
	<ul class="styleless horizontal">
		<li><a href="#">Benutzerprofil</a>
							<ul class="styleless vertical rounded">
								<li><a href="#">Angebot</a></li>
								<li><a href="#">Geschichte</a></li>
								<li><a href="#">Jobs</a></li>
							</ul>
		</li>
		
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "users")
			);
		?>">Rangliste</a></li>
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "games",
				"action" => "index")
			);
		?>">Spiele</a></li>
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "pages",
				"action" => "faq")
			);
		?>">FAQ</a></li>
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "games",
				"action" => "play")
			);
		?>">Neues Spiel!</a></li>
	</ul>
</div>