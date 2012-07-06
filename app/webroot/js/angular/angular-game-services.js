App
    .factory('gamemaths', function() {
        return {
            gridSize: 19,

            getPosition: function(index) {
                return {x: index % this.gridSize, y: Math.floor(index / this.gridSize)};
            },

            getIndex: function(pos) {
                if (pos == null) return -1;

                return pos.x + (this.gridSize * pos.y);
            },

            getTurnAt: function(grid, pos) {
                return grid[this.getIndex(pos)];
            },

            isOccupied: function(grid, index, by) {
                if (index < 0) return false;
                var turn = grid[index];
                if (turn != null) {
                    if (by != null) {
                        return turn.creator === by;
                    }

                    return true;
                }

                return false;
            },

            getTurnsInLine: function(grid, turn, vector) {
                var result = [turn];

                var current = this.getTurnAt(grid, {x: turn.x + vector.x, y: turn.y + vector.y})
                while (this.isOccupied(grid, this.getIndex(current), turn.creator)) {;
                    result.push(current);
                    current = this.getTurnAt(grid, {x: current.x + vector.x, y: current.y + vector.y})
                }

                current = this.getTurnAt(grid, {x: turn.x - vector.x, y: turn.y - vector.y})
                while (this.isOccupied(grid, this.getIndex(current), turn.creator)) {
                    result.push(current);
                    current = this.getTurnAt(grid, {x: current.x - vector.x, y: current.y - vector.y})
                }

                return result;
            },

            findAdjacentRows: function(grid, turn) {
                return $.grep([
                    this.getTurnsInLine(grid, turn, {x: 1, y: 0}),
                    this.getTurnsInLine(grid, turn, {x: 1, y: 1}),
                    this.getTurnsInLine(grid, turn, {x: 0, y: 1}),
                    this.getTurnsInLine(grid, turn, {x: -1, y: 1})
                ], function(line) {
                    if (line.length >= 5) {
                        $.each(line, function(i, t) {
                            t.completedLines.push(line);
                        });
                        return true;
                    }

                    return false;
                });
            }
        };
    });