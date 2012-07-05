var App = angular.module('app', ['ngResource']);

function curryIdentity(fn) {
    return function() {
        var args = [].slice.call(arguments);
        args.splice(0,0,this);
        return fn.apply(this, args);
    }
}

Date.prototype.addMonths = curryIdentity(Date.addMonths = function(date, months) {
    var d = new Date(date);
    d.setMonth(date.getMonth() + months);
    return d;
});

Date.prototype.addDays = curryIdentity(Date.addDays = function(date, days) {
    var d = new Date(date);
    d.setDate(date.getDate() + days);
    return d;
});

Date.prototype.firstDayOfMonth = curryIdentity(Date.firstDayOfMonth = function(date) {
    var d = new Date(date);
    d.setDate(1);
    return d;
});

Date.prototype.lastDayOfMonth = curryIdentity(Date.lastDayOfMonth = function(date) {
    return new Date(date.getFullYear(), date.getMonth()+1, 0)
});

Date.DAY_OF_MILLISECONDS = 86400000

Date.prototype.firstDayOfWeek = curryIdentity(Date.firstDayOfWeek = function(date) {
    return new Date(date.valueOf() - (date.getDay()<=0 ? 7-1:date.getDay()-1)*Date.DAY_OF_MILLISECONDS);
});

Date.prototype.lastDayOfWeek = curryIdentity(Date.lastDayOfWeek = function(date) {
    return new Date( date.firstDayOfWeek().valueOf() + 6*Date.DAY_OF_MILLISECONDS);
});

Date.prototype.getMonthDate = curryIdentity(Date.getMonthDate = function(date) {
    return new Date( date.getFullYear(), date.getMonth()+1, 0);
});

Date.prototype.getDayDate = curryIdentity(Date.getMonthDate = function(date) {
    return new Date( date.getFullYear(), date.getMonth()+1, date.getDate());
});

Array.range = function (min, max, selector) {
    selector = selector || function(x) {return x;};
    return Array(max-min).join().split(',').map(function(e, i) { return selector(min+i); });
}

Array.generate = function(fn) {
    var current = null, i = 0, result = [];
    fn (0, null);
    while ((current = fn(i, current)) !== false) {
        result[i] = current;
        i++;
    }
    console.log(result,i);
    return result;
}