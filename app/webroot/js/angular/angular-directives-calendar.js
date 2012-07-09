App.directive('calendar', function ($compile, $timeout, $filter, $locale) {
    return {
        restrict: 'EA',
        replace: false,
        scope: { selecteddate: '=', selecteddates: '=' },
        compile: function ($place, att) {
            var template =
                '<div class="calendar">' +
                    '<div class="nav">' +
                        '<div class="current button">{{currentMonth.date | date:"MMMM"}}</div>' +
                        '<div class="prev button" ng-click="prevMonth()">prev</div>' +
                        '<div class="next button" ng-click="nextMonth()">next</div>' +
                    '</div>' +
                    '<div class="head">' +
                        '<div>{{weekdays[1]}}</div>' +
                        '<div>{{weekdays[2]}}</div>' +
                        '<div>{{weekdays[3]}}</div>' +
                        '<div>{{weekdays[4]}}</div>' +
                        '<div>{{weekdays[5]}}</div>' +
                        '<div>{{weekdays[6]}}</div>' +
                        '<div>{{weekdays[0]}}</div>' +
                    '</div>' +
                    '<div class="body">' +
                        '<div class="months">' +
                            '<div class="days">' +
                                '<div class="day" ng-repeat="day in currentMonth.days"' +
								'                 ng-class="{today: isToday(day), \'other-month\': !isCurrentMonth(day)}"' +
                                '                 aria-selected="{{isSelected(day)}}"' +
                                '                 ng-click="select(day)">' +
                                   '{{day.getDate()}}' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

            var link = function (scope, $element) {
                scope.selecteddate = scope.selecteddate || new Date;
				scope.weekdays = $locale.DATETIME_FORMATS.SHORTDAY;
				
                scope.currentMonth = {
                    date: new Date,
                    days: []
                };
				
				scope.isToday = function(date) {
					return (new Date).getDayDate().valueOf() == date.getDayDate().valueOf();
				}
				
				scope.isCurrentMonth = function(date) {
					return scope.selecteddate.getMonthDate().valueOf() == date.getMonthDate().valueOf();
				}

                scope.nextMonth = function () {
                    scope.selecteddate = scope.selecteddate.addMonths(1);
                };

                scope.prevMonth = function () {
                    scope.selecteddate = scope.selecteddate.addMonths(-1);
                };
				
				scope.isSelected = function(date) {
					var datevalue = date.getDayDate().valueOf();
					if (scope.selecteddates != null) {
						return scope.selecteddates.indexOf(datevalue) != -1;
					}
					
					return scope.selecteddate.getDayDate().valueOf() == datevalue;
				};

                scope.select = function (date) {
                    scope.selecteddate = date;
					var datevalue = date.getDayDate().valueOf();
					
					if (scope.selecteddates == null) return;
					if (scope.selecteddates.indexOf(datevalue) != -1) {
						scope.selecteddates.remove(datevalue);
					}
					else {
						scope.selecteddates.push(datevalue);
					}
                };
				
                scope.$watch('selecteddate', function (date, oldDate) {
					if( !Date.isValid(date)) {
						if (Date.isValid(oldDate)) {
							scope.selecteddate = oldDate;
						}
						
						return;
					}
					
                    var monthsdiff = date.getMonthDate().valueOf() - oldDate.getMonthDate().valueOf();

                    $element.removeClass('slidein-from-right slidein-from-left');
                    $timeout(function () {
                        if (monthsdiff > 0) {
                            $element.addClass('slidein-from-right');
                        }
                        else if (monthsdiff < 0) {
                            $element.addClass('slidein-from-left');
                        }
                    });

                    if (monthsdiff != 0) {						
                        generateMonth();
                    }
					else {
						if (scope.popout != null) {
							scope.popout.show = false;
						}
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
                    $compile('<popout input="element">' + template + '</popout>')(scope, function (clone) {
                        link(scope, clone);

                        scope.$watch('selecteddate', function (val) {
                            $element.val($filter('date')(val));
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
.directive('popout', function ($timeout) {
    return {
        restrict: 'E',
        transclude: true,
		replace: true,
        scope: { input: '='},
		link: function(scope, $element) {
			scope.show = false;
			scope.$parent.popout = scope;
			
			var pos = scope.input.offset();
			$element.offset({
				left: pos.left,
				top: pos.top + scope.input.innerHeight()
			});
			
			$(document).on('click', function(ev) {
				scope.$apply(function() {
					if (scope.input.get(0) != ev.target && $element.has($(ev.target)).length == 0) {
						scope.show = false;
					}
				});
			});
			
			scope.input.focus(function() {
				scope.$apply(function() {
					scope.show = true;
				});
			}).blur(function(){
				$timeout(function() {
					if (document.activeElement != document.body && $element.has($(document.activeElement)).length == 0) {
						scope.$apply(function() {
							scope.show = false;
						});
					}
				});
			});
			
		},
        template:
            '<div class="popout transitioned" ng-class="{collapsedY: !show}" ng-transclude>' +
            '</div>'
    };
});