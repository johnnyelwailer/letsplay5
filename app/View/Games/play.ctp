<div ng-controller="GameViewModel" class="play-grid">
    <div class="grid">
        <div ng-repeat="turn in grid" class="grid-cell"
             ng-click="place($index)">
            <div ng-class="{marked: isMarked(turn), 'by-me': turn.isMine}">
                {{turn.creator || '('+$index+')'}}
            </div>

        </div>
    </div>
</div>