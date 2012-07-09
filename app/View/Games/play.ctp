<?php echo $this->Html->script('viewmodels/GameViewModel');?>
<?php echo $this->Html->css('game');?>
<div ng-controller="GameViewModel" class="play-grid">
    <div class="grid">
        <div ng-repeat="turn in grid" class="grid-cell"
             ng-click="place($index)">
            <div class="grid-cell">
                <div class="turn" ng-class="{marked: isMarked(turn), 'by-me': turn.isMine, 'belongs-to-line': turn.completedLines.length > 0}">
                    {{turn.creator || '('+$index+')'}}
                </div>

            </div>

        </div>
    </div>
</div>