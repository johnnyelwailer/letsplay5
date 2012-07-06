<div id="useroption">
	
	<form action="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>" method="post">
		<label for="username">Username:</label> <input type="text" size="20" name="username" id="username" placeholder="Benutzername" />
		<label for="password">Passwort:</label> <input type="password" size="20" name="password" id="password" placeholder="●●●●●●●●" />
		<input type="submit" value="Anmelden" />
		
		<?php echo $this->Html->link('Registrieren', array(
				"controller" => "users",
				"action" => "add")
			);
		?>
		
		
		<?php echo $this->Html->link('Passwort zurücksetzen', array(
				"controller" => "users",
				"action" => "resetPassword")
			);
		?>
	</form>
	
	
	
</div>