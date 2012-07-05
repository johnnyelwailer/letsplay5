<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @var $this View
 */
if (Configure::read('debug') == 0):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>

<a href="Users">Users</a> |
<a href="Groups">Groups</a>

    <script src="js/jquery.js"></script>
    <script src="js/angular/angular.js"></script>
    <script src="js/angular/angular-resource.js"></script>
    <script src="js/angular/angular-app.js"></script>
    <script src="js/angular/angular-directives-calendar.js"></script>
    <style>
        .calendar {
            width: 210px;
        }

        .calendar .head {
            overflow: hidden;
        }

        .calendar .body {
            position: relative;
            overflow: hidden;
            width: 210px;
            height: 150px;

        }

        .calendar .nav {
            overflow: hidden;
            position: relative;
            width: 100%;
            height: 20px;
        }

        .calendar .button {
            z-index: 1;
            position: absolute;
        }

        .calendar .button:hover, .calendar .day:hover {
            font-weight: bold;
            cursor: pointer;
        }

        .calendar .current.button {
            z-index: 0;
            width: 100%;
            left: 0;
            text-align: center;
        }

        .calendar .prev.button {

            left: 0;
        }

        .calendar .next.button {
            right: 0;
        }

        .calendar .days {
            width: 210px;
            height: 150px;
        }
        .calendar .day, .calendar .head > div {
            float: left;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            vertical-align: middle;
        }

        .calendar .day[aria-selected=true] {
            background: #87cefa;
        }
    </style>
    <script >


        function UserViewModel($scope, $resource) {
            var Users = $resource('Users.json');

            $scope.date = new Date;

            Users.get(function(result) {
                $scope.users = result.users;
                console.log(result);
            });
        }
    </script>
        <div ng-app="app">
            <div ng-controller="UserViewModel">
                <p>date: ({{date}})</p>
                <calendar selectedDate="date" />

                <div ng-repeat="item in users">
                    {{item.User.username}}{{what}}
                </div>
            </div>
        </div>
