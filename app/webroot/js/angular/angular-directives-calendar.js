App.directive('calendar', function() {
   return {
     restrict: 'EC',
     replace: true,
     scope: {selectedDate: '='},
     link: function() {

     },
     template:
         '<div class="calendar">' +
             '<div class="head">' +
             '</div>' +
             '<div class="months">' +
                 '<div class="days" ng-repeat="month in loadedMonths">' +
                    '<div class="day" ng-repeat="day in days">' +
                        '{{day}}' +
                    '</div>' +
                 '</div>' +
             '</div>' +
         '</div>'
   };
});