<?php

App::uses('User', 'Model');

//define a fake model for user. That way cakephp does not have any conflicts with multiple forms on the same page
class UserLogin extends User {}
