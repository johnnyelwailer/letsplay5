
<script type="text/javascript">
    function GameViewModel($scope, $resource) {
        var gridSize = 19;

        $scope.turns = [];
        $scope.isMyTurn = true;
        $scope.grid = Array.range(0, gridSize * gridSize, function(i){
            return null;
        });

        $resource('../GameApi/makeMatch.json').save(function(result) {
            $scope.game = result.game.Game;

            $resource('../GameApi/turns/:id/:since.json').get({id: $scope.game.id, since: $scope.game.created}, function(result) {

                $scope.turns = $.map(result.turns, function(item) {
                    var turn = parseTurn(item);
                    console.log(turn, getIndex(turn));
                    doTurn(turn);
                    return turn;
                });
            });
        })

        var parseTurn = function(item) {
            return {
                x: parseInt(item.Turn.x),
                y: parseInt(item.Turn.y),
                game_id: parseInt(item.Turn.game_id),
                creator: parseInt(item.Turn.creator),
                created: item.Turn.created
            };
        }

        var getPosition = function(index) {
            return {x: index % gridSize, y: Math.floor(index / gridSize)};
        }

        var getIndex = function(turn) {
            return turn.x + (gridSize * turn.y);
        };

        var doTurn = function(turn) {
            var index = getIndex(turn);
            var turn = $scope.grid[index] = turn;
            turn.isMine = turn.creator == $scope.game.challenger_id;
        };

        $scope.place = function(index) {
          var data = getPosition(index);
          var params = {
              id:  $scope.game.id,
              x: data.x.toString(),
              y: data.y.toString()
          };

          $resource('../GameApi/place/:id/:x/:y.json', params).get(function(result) {
              console.log(result)
              doTurn(parseTurn(result.turn));
          });
        };

        $scope.isMarked = function(turn) {
            return turn !== null;
        }
    }
</script>
    <style>
        .play-grid {
            width: 620px;
        }

        .grid-cell {
            float: left;
            width: 30px;
            height: 30px;
            border: 1px solid black;
        }

        .grid-cell .marked {
            border-radius: 30px;
            background: #f08080;
        }

        .grid-cell .marled.by-me {
            background: lightBlue;
        }
    </style>
    <div ng-controller="GameViewModel" class="play-grid">
        <div ng-repeat="turn in grid" class="grid-cell"
             ng-click="place($index)">
            <div ng-class="{marked: isMarked(turn), 'by-me': turn.isMine}">
                {{turn.creator || '('+$index+')'}}
            </div>

        </div>
    </div>