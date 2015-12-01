<?php

include('include/Todo.class.php');

$checked =  $_POST['checked'];

foreach($checked as $itemId){
    Todo::markComplete($itemId);
}

