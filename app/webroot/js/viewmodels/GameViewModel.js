function GameViewModel($scope, $resource, $timeout, gamemaths) {

    $scope.turns = [];
    $scope.waitingForOpponent = true;
    $scope.isMyTurn = true;
    $scope.lastTurn = null;
    $scope.lastTurnTime = null;
    $scope.grid = Array.range(0,gamemaths.gridSize * gamemaths.gridSize, function(i){
        return null;
    });

    var getTurns = function() {
        $resource('../GameApi/turns/:id/:since.json').get({id: $scope.game.id, since: $scope.lastTurnTime || $scope.game.created}, function(result) {
            try {
                var newTurns = $.map(result.turns, function(item) {
                    var turn = parseTurn(item);
                    makeTurn(turn);
                    findAdjacentRows(turn);
                    return turn;
                });

                console.log(result.winner);
                if (result.winner != null) {
                    $scope.game.completed = true;
                    $scope.game.winner_id = result.winner;
                }

                Array.prototype.push.apply($scope.turns, newTurns);
            }
            finally {
                $timeout(getTurns, 1000);
            }
        });
    }

    var makeMatch = function() {
		/*$resource('../GameApi/getGameData/:id.json').get({id: 1/*$scope.game.id*}, function(result) {
			alert(JSON.stringify(result));
		});*/
		
		
        $resource('../GameApi/makeMatch.json').save(function(result) {
            if (result.await != null) {
                $timeout(makeMatch, 5000);
                return;
            }

            $scope.waitingForOpponent = false;

            $scope.game = result.game.Game;
            $scope.player = result.player;
            $scope.game.challenger = result.game.challenger;
            $scope.game.opponent = result.game.opponent;
            getTurns(result);
        });
    };

    makeMatch();

    var parseTurn = function(item) {
        return {
            x: parseInt(item.Turn.x),
            y: parseInt(item.Turn.y),
            game_id: parseInt(item.Turn.game_id),
            creator: parseInt(item.Turn.creator),
            created: item.Turn.created,
            createdDate: Date.fromSqlFormat(item.Turn.created)
        };
    }

    var isOccupied = function(pos, by) {
        var index = pos.index;
        if (index === null) {
            index = typeof(pos) === 'number' ? pos : getIndex(pos);
        }

        return gamemaths.isOccupied($scope.grid, index, by);
    }

    var getPosition = function(index) {
        return gamemaths.getPosition(index);
    }

    var getIndex = function(turn) {
        return gamemaths.getIndex(turn);
    };

    var findAdjacentRows = function() {
        $.each(arguments, function(i, turn){
            console.log(gamemaths.findAdjacentRows($scope.grid, turn));
        });

    };

    var makeTurn = function(turn) {
        var index = getIndex(turn);
        turn.index = index;
        turn.isMine = turn.creator == $scope.player;
        turn.completedLines = [];
        if(isOccupied(turn)) {
            return false;
        }

        if (!turn.createdDate.isValid()) {
            console.log('invalid created date', turn);
        }

        if($scope.lastTurn === null || turn.createdDate.valueOf() > $scope.lastTurn.createdDate.valueOf()) {
            $scope.lastTurn = turn;
            $scope.isMyTurn = !turn.isMine;
            $scope.lastTurnTime = $scope.lastTurn.createdDate;
        }

        return $scope.grid[index] = turn;

    };

    $scope.getPlayer = function() {
        if ($scope.player == $scope.game.challenger_id) {
            return $scope.game.challenger;
        }

        return $scope.game.opponent;
    };

    $scope.getPlayersOpponent = function() {
        if ($scope.player == $scope.game.challenger_id) {
            return $scope.game.opponent;
        }

        return $scope.game.challenger;
    };

    $scope.place = function(index) {
        if (!$scope.isMyTurn) return;

        var data = getPosition(index);

        var params = {
            id:  $scope.game.id,
            x: data.x.toString(),
            y: data.y.toString()
        };

        $resource('../GameApi/place/:id/:x/:y.json', params).get(function(result) {
            makeTurn(parseTurn(result.turn));
            if (result.won === true) {
                $scope.game.completed = true;
                $scope.game.winner_id = $scope.player;

                $.each(result.rows, function(_,row) {
                    $.each(row, function(_, turn) {
                        $scope.grid[getIndex(parseTurn(turn))].completedLines.push(row);
                    });
                });

            }
        });
    };

    $scope.isMarked = function(turn) {
        return turn !== null;
    };

    $scope.hasWon = function() {
        if (!$scope.isCompleted()) return null;
        return $scope.game.winner_id == $scope.player;
    };

    $scope.isCompleted = function() {
        if ($scope.game == null) return false;
        return $scope.game.completed;
    };
}