<div id="navigation" class="toolbar-gradient">
	<div class="background"></div>
	<ul class="styleless horizontal">
		<?php if(!$isGast) { ?>
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "users",
				"action" => "view", $currentUser['id'])
			);
		?>">Benutzerprofil</a>
							<ul class="styleless vertical rounded">
								<li><a href="<?php echo $this->Html->url(array(
										"controller" => "users",
										"action" => "edit", $currentUser['id'])
									);
								?>">Einstellungen</a></li>
								<li><a href="#">Nächster Zug!</a></li>
								<li><a href="<?php echo $this->Html->url(array(
										"controller" => "users",
										"action" => "logout")
									);
								?>">Logout</a></li>
							</ul>
			</a>
		</li>
		
		<?php } ?>
		
		<li><a href="<?php echo $this->Html->url(array(
				"controller" => "users",
				"action" => "index")
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