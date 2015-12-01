<?php

include('include/Todo.class.php');

$content = $_POST['content'];
$uid = $_POST['uid'];

Todo::addItem($content, $uid);
