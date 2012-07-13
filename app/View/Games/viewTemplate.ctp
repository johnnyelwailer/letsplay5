<div id="players">
    <div class="challenger" ng-class="{
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


    <div class="opponent" ng-class="{
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
			<dd class="created">{{ game.created | date:"dd.MM.y HH:mm:ss" || 'waiting...'}}</dd>
			<dt><?php echo __('Expiry date'); ?></dt>
			<dd class="expires">{{ (game.expired | date:"d") + ' Tage und ' + (game.expired | date:"HH:mm:ss") || 'waiting...'}} </dd>
            <dt><?php echo __('last turn'); ?></dt>
			<dd class="expires">{{lastTurnTime | date:"dd.MM.y HH:mm:ss"}} </dd>
		</dl>
		
		<?php if($currentUser['Group']['name'] == 'Administrator' OR $currentUser['Group']['name'] == 'Moderator') { ?>
		<a href="<?php echo $this->Html->url(array(
				'controller' => 'games',
				'action' => 'terminate')
				); ?>/{{game.id}}" ng-class="{hidden: !game.id}"><?php echo __('Spiel beenden'); ?></a>
		<?php } ?>
	</div>


<div class="message transitioned collapsedY" ng-class="{collapsedY: !isCpompleted()}">
    <h1>{{getWinner().username}} won!</h1>
</div>
<div class="play-grid">

    <div class="grid transitioned">
        <div ng-repeat="turn in grid" ng-class="{break: $index % 19 == 0}" class="grid-cell transitioned"
             ng-click="place($index)">
            <div class="turn transitioned " ng-class="{marked: isMarked(turn), 'by-me': turn.isChallenger, 'belongs-to-line': turn.completedLines.length > 0}">
                <?php echo $this->Html->image('stoneblack.png', array('ng-show' => '!turn.isChallenger')); ?>
                <?php echo $this->Html->image('stonewhite.png', array('ng-show' => 'turn.isChallenger')); ?>
            </div>
        </div>
    </div>
</div>
