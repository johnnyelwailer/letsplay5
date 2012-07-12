
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

<hr />

<dl>
    <dt><?php echo __('Created'); ?></dt>
    <dd>A Date</dd>
    <dt><?php echo __('Expiry date'); ?></dt>
    <dd>A Date</dd>
</dl>

<hr />

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

