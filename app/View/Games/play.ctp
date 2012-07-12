<script type="text/javascript">
    window.isObservingOnly = false;
    window.currentUserId = <?php echo $currentUser['id']; ?>;
    window.webroot = '<?php echo $this->webroot; ?>';
</script>

<?php
echo $this->Html->script('viewmodels/GameViewModel');
echo $this->Html->script('angular/angular');
echo $this->Html->script('angular/angular-resource');
echo $this->Html->script('angular/angular-app');
echo $this->Html->script('angular/angular-game-services');

echo $this->Html->css('game');

?>

<div id="game-wrapper" ng-controller="GameViewModel">
    <div id="players">
		<div class="challenger" ng-class="{waiting: waitingForOpponent,
                    'my-turn': isChallengersTurn(),
                    won: hasChallengerWon(), lost: hasOpponentWon()}">
			<div class="online">
				<?php echo $this->Html->image('active.png', array('alt' => 'active', 'ng-show' => 'game.challenger.online')); ?>
				<?php echo $this->Html->image('inactive.png', array('alt' => 'inactive', 'ng-show' => '!game.challenger.online')); ?>
			</div>
			<span class="name">{{game.challenger.username}}</span>
			<div class="status">
				<?php echo $this->Html->image('challengerstatus.png', array('alt' => 'inactive')); ?>
			</div>
		</div>
		
		
		<div class="opponent" ng-class="{waiting: waitingForOpponent,
		            'my-turn': isOpponentsTurn(),
		            won: hasOpponentWon(), lost: hasChallengerWon()}">
			<div class="status">
				<?php echo $this->Html->image('opponentstatus.png', array('alt' => 'inactive')); ?>
			</div>
			<span class="name">{{game.opponent.username}}</span>
			<div class="online">
                <?php echo $this->Html->image('active.png', array('alt' => 'active', 'ng-show' => 'game.opponent.online')); ?>
                <?php echo $this->Html->image('inactive.png', array('alt' => 'inactive', 'ng-show' => '!game.opponent.online')); ?>
            </div>
		</div>
	</div>
	
	<div class="info">
		<dl>
			<dt><?php echo __('Created'); ?></dt>
			<dd class="created">{{ game.created || 'waiting...'}}</dd>
			<dt><?php echo __('Expiry date'); ?></dt>
			<dd class="expires">{{ game.expired || 'waiting...'}}</dd>
		</dl>
		
		<a href="<?php echo $this->Html->url(array(
				'controller' => 'games',
				'action' => 'terminate')
				); ?>/{{game.id}}" ng-class="{hidden: !game.id}"><?php echo __('Spiel beenden'); ?></a>
		
	</div>
	
    <div ng-show="isCompleted()" >
        <div class="message transitioned collapsedY" ng-class="{collapsedY: !hasWon()}">
            <h1>You won!</h1>
        </div>
        <div class="message transitioned" ng-class="{collapsedY: hasWon()}">
            <h1>You lost!</h1>
        </div>
    </div>
	<div class="play-grid">
	
        <div class="grid transitioned">
            <div ng-repeat="turn in grid" ng-class="{break: $index % 19 == 18}" class="grid-cell transitioned"
                 ng-click="place($index)">
                <div class="turn transitioned " ng-class="{marked: isMarked(turn), 'by-me': turn.isMine, 'belongs-to-line': turn.completedLines.length > 0}">
                </div>
            </div>
        </div>
    </div>
</div>

</div>