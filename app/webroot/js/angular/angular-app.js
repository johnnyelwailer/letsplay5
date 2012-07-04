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
    return new Date(date.getFullYear(), date.getMonth(), 0)
});
Date.prototype.firstDayOfWeek = curryIdentity(Date.firstDayOfWeek = function(date) {
    return date.addDays(-(date.getDay()-1));
});

Date.prototype.lastDayOfWeek = curryIdentity(Date.lastDayOfWeek = function(date) {
    return date.addDays(7 - date.getDay());
});
Array.range = function (min, max, selector) {
    return Array(max-min+2).join().split(',').map(function(e, i) { return min+i; });
}

Array.generate = function(fn) {
    var current, i = 0, result = [];
    while ((current = fn(i, current)) !== false) {
        result[i] = current;
        i++;
    }

    return result;
}