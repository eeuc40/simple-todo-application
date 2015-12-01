<?php
include 'include/Todo.class.php';

$uid = $_POST['uid'];

echo Todo::getAllItems($uid);

