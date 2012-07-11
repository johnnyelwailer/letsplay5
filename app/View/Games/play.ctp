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
		<div class="challenger" ng-class="{waiting: !waitingForOpponent}">
			<div class="online">
				<?php echo $this->Html->image('active.png', array('alt' => 'inactive')); ?>
			</div>
			<span class="name">Spieler1</span>
			<div class="status">
				<?php echo $this->Html->image('gamerstatus.png', array('alt' => 'inactive')); ?>
			</div>
		</div>
		
		
		<div class="opponent" ng-class="{waiting: !waitingForOpponent}">
			<span class="name">Spieler2</span>
			<?php echo $this->Html->image('notmyturn', array('alt' => 'inactive')); ?>
		</div>
	</div>

<div ng-controller="GameViewModel" class="play-grid">
<<<<<<< HEAD
	<!--
    <div class="message transitioned" ng-class="{waiting: !waitingForOpponent}">
        <h1>Waiting for opponent</h1>
=======
    <div ng-show="!isCompleted()" >
        <div class="message transitioned" ng-class="{collapsedY: !waitingForOpponent}">
            <h1>Waiting for opponent</h1>
        </div>
        <div class="message transitioned" ng-class="{collapsedY: isMyTurn}">
            <h1>It's the opponents turn...</h1>
        </div>
>>>>>>> 1fd659e403310bd7a074075e6859deeaac7af1fb
    </div>
    <div ng-show="isCompleted()" >
        <div class="message transitioned collapsedY" ng-class="{collapsedY: !hasWon()}">
            <h1>You won!</h1>
        </div>
        <div class="message transitioned" ng-class="{collapsedY: hasWon()}">
            <h1>You lost!</h1>
        </div>
    </div>
<<<<<<< HEAD
	-->
	
	
=======

>>>>>>> 1fd659e403310bd7a074075e6859deeaac7af1fb
    <div class="grid transitioned" ng-class="{collapsedY: waitingForOpponent, 'my-turn': isMyTurn}">
        <div ng-repeat="turn in grid" class="grid-cell transitioned"
             ng-click="place($index)">
            <div class="turn transitioned " ng-class="{marked: isMarked(turn), 'by-me': turn.isMine, 'belongs-to-line': turn.completedLines.length > 0}">
            </div>

        </div>
    </div>
</div>

</div>