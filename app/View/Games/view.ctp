<script type="text/javascript">
    window.gameId = <?php echo $id; ?>;
	window.currentUserId = <?php echo isset($currentUser['id']) ? $currentUser['id'] : 0; ?>;
    window.intentionToPlay = <?php echo $intentionToPlay ? 'true' : 'false'; ?>;
    window.webroot = '<?php echo $this->webroot; ?>';
	window.isGast = <?php echo $isGast ? 'true' : 'false'; ?>;
</script>

<?php
echo $this->Html->script('viewmodels/GameViewModel');
echo $this->Html->script('angular/angular');
echo $this->Html->script('angular/angular-resource');
echo $this->Html->script('angular/angular-app');
echo $this->Html->script('angular/angular-game-services');

echo $this->Html->css('game');

?>


<div id="game-wrapper" ng-controller="GameViewModel" >
    <div ng-include src="getTemplate()">

    </div>
</div>