<div id="useroption">	
	<form action="" method="post">
		<label for="username">Username:</label> <input type="text" size="20" name="username" id="username" placeholder="Benutzername" />
		<label for="password">Passwort:</label> <input type="password" size="20" name="password" id="password" placeholder="●●●●●●●●" />
		<input type="submit" value="Anmelden" />
		
		<a href="<?php echo $this->Html->url(array(
				"controller" => "users",
				"action" => "add")
			);
		?>">Registrieren</a>
		
		<a href="<?php echo $this->Html->url(array(
				"controller" => "users",
				"action" => "resetPassword")
			);
		?>">Passwort zurücksetzen</a>
	</form>
</div>