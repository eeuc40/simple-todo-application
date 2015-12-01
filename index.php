<!DOCTYPE html>
<!--
The MIT License

Copyright 2015 Richie.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Todo List</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>
        <?php
        include 'include/include_fns.php';
        $db = new Database();

        // Display the users name
        $db->query("SELECT uid, name FROM account LIMIT 1");
        $db->execute();
        $row = $db->getRow();
        echo "<div id='nameheader'>";
        echo "<h2>" . $row['name'] . "'s todo list</h2>";
        echo "</div>";
        $uid = $row['uid'];

        // Get all the Todo Items 
        $results = json_decode(Todo::getAllItems($uid));
        ?>
        <div id='table-div'>
            <table id='table'>
                <tr><th>Completed</th><th>Todo Item</th></tr>
                <?php
                foreach ($results as $id => $result) {
                    $checked = "";
                    if ($result[1] == 1) {
                        $checked = "checked";
                    }
                    echo"<tr><td class='center'><input type='checkbox' name='completed' value='$id' $checked> </td><td>" . $result[0] . "</td></tr>";
                }
                ?>
            </table>
            <input type='submit' value='Complete Tasks' onclick='saveCompletedItems()' />
        </div>

        <div id='new-item-div'>
            <h2>Add new item</h2>
            <input type='hidden' name='uid' id='uid' value='<?php echo $uid ?>'/>
            <input type='text' name='content' id='content' placeholder="What do you have to do?"/><br />
            <input type='submit' value='Add new item' onclick='addNewItem()' />
        </div>
    </body>
</html>
