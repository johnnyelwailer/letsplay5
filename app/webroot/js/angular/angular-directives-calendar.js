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

         var loadDays = function(date) {
             var lastday = date.lastDayOfMonth().lastDayOfWeek();
             var firstday = date.firstDayOfMonth().firstDayOfWeek();
             return Array.generate(function(i, prev) {
                 prev = prev || firstday;
                 var d = prev.addDays(1);
                 return (d - lastday > 0) ? false : d;
             });
         };

         var generateMonths = function() {
             console.log(scope._selectedDate)
             var currentDate = scope._selectedDate;
             var currentMonth = currentDate.getMonth();
             var min = currentMonth -1;
             var max = currentMonth + scope._monthsVisible - 1;

             for (var i = -1; i < scope._monthsVisible; i++) {
                 var date = currentDate.addMonths(i);
                 scope.loadedMonths.push({
                   date: date,
                   days: loadDays(date)
                 });
                 console.log(i, scope.loadedMonths);

             }
         }
     },
     template:
         '<div class="calendar">' +
             '<div class="head">' +
             '</div>' +
             '<div class="months">' +
                 '<div class="days" ng-repeat="month in loadedMonths">' +
                    '{{month.date}}' +
                    '<div class="day" ng-repeat="day in month.days">' +
                        '{{day}}' +
                    '</div>' +
                 '</div>' +
             '</div>' +
         '</div>'
   };
});