<div id="game-wrapper">

<?php
echo $this->Html->script('viewmodels/GameViewModel');
echo $this->Html->script('angular/angular');
echo $this->Html->script('angular/angular-resource');
echo $this->Html->script('angular/angular-app');
echo $this->Html->script('angular/angular-game-services');

echo $this->Html->css('game');

?>

<div id="players">
		<div class="challenger" ng-class="{waiting: !waitingForOpponent, 'my-turn': isMyTurn}">
			<div class="online">
				<?php echo $this->Html->image('active.png', array('alt' => 'inactive')); ?>
			</div>
			<span class="name">Spieler1</span>
			<div class="status">
				<?php echo $this->Html->image('challengerstatus.png', array('alt' => 'inactive')); ?>
			</div>
		</div>
		
		
		<div class="opponent" ng-class="{waiting: !waitingForOpponent, 'my-turn': isMyTurn}">
			<div class="status">
				<?php echo $this->Html->image('opponentstatus.png', array('alt' => 'inactive')); ?>
			</div>
			<span class="name">Spieler2</span>
			<div class="online">
				<?php echo $this->Html->image('active.png', array('alt' => 'inactive')); ?>
			</div>
		</div>
	</div>

	<div ng-controller="GameViewModel" class="play-grid">

    </div>
    <div ng-show="isCompleted()" >
        <div class="message transitioned collapsedY" ng-class="{collapsedY: !hasWon()}">
            <h1>You won!</h1>
        </div>
        <div class="message transitioned" ng-class="{collapsedY: hasWon()}">
            <h1>You lost!</h1>
        </div>
    </div>
	
    <div class="grid transitioned" ng-class="{collapsedY: waitingForOpponent, 'my-turn': isMyTurn}">
        <div ng-repeat="turn in grid" class="grid-cell transitioned"
             ng-click="place($index)">
            <div class="turn transitioned " ng-class="{marked: isMarked(turn), 'by-me': turn.isMine, 'belongs-to-line': turn.completedLines.length > 0}">
            </div>

        </div>
    </div>
</div>

</div>