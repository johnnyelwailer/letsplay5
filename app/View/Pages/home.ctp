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
    <script >
        var App = angular.module('app', ['ngResource']);

        function UserViewModel($scope, $resource) {
            var Users = $resource('Users.json');

            Users.get(function(result) {
                $scope.users = result.users;
                console.log(result);
            });
        }
    </script>
        <div ng-app="app">
            <div ng-controller="UserViewModel">
                <div ng-repeat="item in users">
                    {{item.User.username}}
                </div>
            </div>
        </div>
