App.directive('calendar', function() {
   return {
     restrict: 'E',
     replace: true,

     scope: {selectedDate: '=_selectedDate'},
     link: function(scope, $element) {
         scope._selectedDate = scope._selectedDate || new Date;

         scope.currentMonth = {
             date: new Date,
             days: []
         };

         scope.nextMonth = function() {
             scope._selectedDate = scope._selectedDate.addMonths(1);
         };

         scope.prevMonth = function() {
             scope._selectedDate = scope._selectedDate.addMonths(-1);
         };

         scope.select = function(date) {
             scope._selectedDate = date;
         };

         scope.$watch('_selectedDate', function(date, oldDate){
             if (date.getMonthDate().valueOf() != oldDate.getMonthDate().valueOf()) {
                 generateMonth();
             }
         });

         var loadDays = function(date) {
             var lastday = date.lastDayOfMonth().lastDayOfWeek();
             var firstday = date.firstDayOfMonth().firstDayOfWeek();
             return Array.generate(function(i, prev) {
                 prev = prev !== null ? prev.addDays(1) : firstday;
                 var d = prev;

                 scope.currentMonth.days[i] = d;

                 return (d - lastday > 0) ? false : d;
             });
         };


         var generateMonth = function() {
             scope.currentMonth.date =  new Date(scope._selectedDate.getFullYear(), scope._selectedDate.getMonth()+1, 0);
             loadDays(scope.currentMonth.date);
         }

         generateMonth();
     },
     template:
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
                        '                 aria-selected="{{day == _selectedDate}}"' +
                        '                 ng-click="select(day)">' +
                            '{{day.getDate()}}' +
                        '</div>' +
                     '</div>' +
                 '</div>' +
             '</div>' +
         '</div>'
   };
});