App.directive('calendar', function() {
   return {
     restrict: 'EA',
     replace: false,
     scope: {selecteddate: '='},
     compile: function($place, att) {
         console.log(arguments);

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

         return function(scope, $element) {
             //please link to scope
             if ($element.get(0).nodeName == 'INPUT') {
                $('<popout position="{left: 0; top: 0}">'+template+'</popout>').insertAfter($element);
             }
             else {
                $(template).appendTo($element);
             }
         };

     },
     link: function(scope, $element) {
         scope.selecteddate = scope.selecteddate || new Date;

         scope.currentMonth = {
             date: new Date,
             days: []
         };

         scope.nextMonth = function() {
             scope.selecteddate = scope.selecteddate.addMonths(1);
         };

         scope.prevMonth = function() {
             scope.selecteddate = scope.selecteddate.addMonths(-1);
         };

         scope.select = function(date) {
             scope.selecteddate = date;
         };

         scope.$watch('selecteddate', function(date, oldDate){
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
             scope.currentMonth.date =  new Date(scope.selecteddate.getFullYear(), scope.selecteddate.getMonth()+1, 0);
             loadDays(scope.currentMonth.date);
         }

         generateMonth();
     }

   };
})
    .directive('popout', function() {
        return {
          restrict: 'E',
          transclude: true,
          scope: {position: '='},
          link: function(scope, $element) {
          },
          template:
              '<div class="popout" ng-style="left: position.left, top: position.top">' +
               '</div>'

        };
    });