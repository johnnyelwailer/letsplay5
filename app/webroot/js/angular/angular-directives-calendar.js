App.directive('calendar', function() {
   return {
     restrict: 'E',
     replace: true,
     scope: {selectedDate: '=_selectedDate', monthsVisible: '=_monthsVisible'},
     link: function(scope, $element) {
         scope._monthsVisible = scope._monthsVisible || 1;
         scope._selectedDate = scope._selectedDate || new Date;
         scope.loadedMonths = [];


         scope.$watch('_selectedDate', function(date){
             generateMonths();
         });

         scope.isActive = function(month) {
             return month.date.getMonth() - scope._selectedDate.getMonth() < scope._monthsVisible;
         };

         var loadDays = function(date) {
             var lastday = date.lastDayOfMonth().lastDayOfWeek();
             var firstday = date.firstDayOfMonth().firstDayOfWeek();
             return Array.generate(function(i, prev) {
                 prev = prev !== null ? prev.addDays(1) : firstday;
                 var d = prev;
                 return (d - lastday > 0) ? false : d;
             });
         };

         var generateMonths = function() {
             var currentDate = new Date(scope._selectedDate.getFullYear(), scope._selectedDate.getMonth(), 0);
             var currentMonth = currentDate.getMonth();
             var min = currentMonth -1;
             var max = currentMonth + scope._monthsVisible;

             for (var i = -1; i < scope._monthsVisible; i++) {
                 var date = currentDate.addMonths(i);
                 scope.loadedMonths[i+1] = {
                   date: date,
                   days: loadDays(date)
                 };
             }
         }
     },
     template:
         '<div class="calendar">' +
             '<div class="nav">' +

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
                     '<div class="days" ng-repeat="month in loadedMonths" ng-class="{minimized: isActive(month)}">' +
                        '<div class="day" ng-repeat="day in month.days">' +
                            '{{day.getDate()}}' +
                        '</div>' +
                     '</div>' +
                 '</div>' +
             '</div>' +
         '</div>'
   };
});