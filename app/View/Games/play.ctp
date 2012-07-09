<?php echo $this->Html->script('viewmodels/GameViewModel');?>
<?php echo $this->Html->css('game');?>
<div ng-controller="GameViewModel" class="play-grid">
    <div class="waiting transitioned" ng-class="{collapsedY: !waitingForOpponent}">
        <h1>Waiting for opponent</h1>
    </div>
    <div class="grid transitioned" ng-class="{collapsedY: waitingForOpponent}">
        <div ng-repeat="turn in grid" class="grid-cell transitioned"
             ng-click="place($index)">
            <div class="turn transitioned" ng-class="{marked: isMarked(turn), 'by-me': turn.isMine, 'belongs-to-line': turn.completedLines.length > 0}">
                {{turn.creator || '('+$index+')'}}
            </div>

        </div>
    </div>
</div>