App.directive('calendar', function ($compile, $timeout) {
    return {
        restrict: 'EA',
        replace: false,
        scope: { selecteddate: '=' },
        compile: function ($place, att) {
            var template =
                '<div class="calendar">' +
                    '<div class="nav">' +
                        '<div class="current button">{{currentMonth.date | date:"MMMM"}}</div>' +
                        '<div class="prev button" ng-click="prevMonth()">prev</div>' +
                        '<div class="next button" ng-click="nextMonth()">next</div>' +
                    '</div>' +
                    '<div class="head">' +
                        '<div>Mo</div>' +
                        '<div>Di</div>' +
                        '<div>Mi</div>' +
                        '<div>Do</div>' +
                        '<div>Fr</div>' +
                        '<div>Sa</div>' +
                        '<div>So</div>' +
                    '</div>' +
                    '<div class="body">' +
                        '<div class="months">' +
                            '<div class="days">' +
                                '<div class="day" ng-repeat="day in currentMonth.days"' +
                                '                 aria-selected="{{day.getDayDate().valueOf() == selecteddate.getDayDate().valueOf()}}"' +
                                '                 ng-click="select(day)">' +
                                   '{{day.getDate()}}' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

            var link = function (scope, $element) {
                scope.selecteddate = scope.selecteddate || new Date;

                scope.currentMonth = {
                    date: new Date,
                    days: []
                };

                scope.nextMonth = function () {
                    scope.selecteddate = scope.selecteddate.addMonths(1);
                };

                scope.prevMonth = function () {
                    scope.selecteddate = scope.selecteddate.addMonths(-1);
                };

                scope.select = function (date) {
                    scope.selecteddate = date;
                };

                scope.$watch('selecteddate', function (date, oldDate) {
                    var monthsdiff = date.getMonthDate().valueOf() - oldDate.getMonthDate().valueOf();

                    $element.removeClass('slidein-from-right slidein-from-left');
                    $timeout(function () {
                        if (monthsdiff > 0) {
                            $element.addClass('slidein-from-left');
                        }
                        else if (monthsdiff < 0) {
                            $element.addClass('slidein-from-right');
                        }
                    });

                    if (monthsdiff != 0) {
                        generateMonth();
                    }
                });

                var loadDays = function (date) {
                    var lastday = date.lastDayOfMonth().lastDayOfWeek();
                    var firstday = date.firstDayOfMonth().firstDayOfWeek();
                    return Array.generate(function (i, prev) {
                        prev = prev !== null ? prev.addDays(1) : firstday;
                        var d = prev;

                        scope.currentMonth.days[i] = d;

                        return (d - lastday > 0) ? false : d;
                    });
                };

                var generateMonth = function () {
                    scope.currentMonth.date = new Date(scope.selecteddate.getFullYear(), scope.selecteddate.getMonth() + 1, 0);
                    loadDays(scope.currentMonth.date);
                }

                generateMonth();
            };

            return function (scope, $element) {
                if ($element.get(0).nodeName == 'INPUT') {
                    scope.element = $element;
                    $compile('<popout element="element">' + template + '</popout>')(scope, function (clone) {
                        link(scope, clone);

                        scope.$watch('selecteddate', function (val) {
                            $element.val(val);
                        });

                        $element.change(function (val) {
                            var date = new Date($element.val())
                            scope.$apply(function () {
                                scope.selecteddate = date;
                            });
                        });

                        clone.insertAfter($element);
                    });
                }
                else {
                    $compile(template)(scope, function (clone) {
                        link(scope, clone);
                        clone.appendTo($element);
                    });
                }
            };
        }
    };
})
.directive('popout', function () {
    return {
        restrict: 'E',
        transclude: true,
        scope: { element: '=' },
        template:
            '<div class="popout" ng-style="{left: 0, top: 0}" ng-transclude>' +
            '</div>'
    };
});