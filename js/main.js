/*
 * The MIT License
 *
 * Copyright 2015 Richie.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

function addNewItem() {
    // Get the values from the submitted form
    var uid = $('#uid').val();
    var content = $('#content').val();

    // AJAX to add the item to the list
    $.post('ajax-add-item.php', {uid: uid, content: content}, function(data) {

        // AJAX to get all the items and add the element to the table without refreshing
        $.post('ajax-get-all-items.php', {uid: uid}, function(data) {
            var obj = $.parseJSON(data);
            // Find the last key in the JSON data
            var lastKey = Object.keys(obj).reverse()[0];
            var lastValue = obj[lastKey];
            // Add a new Row to the table after the last table row
            $('#table tr:last').after('<tr id="' + lastKey + '"><td class="center"><input type="checkbox" name="completed" value="' + lastKey + '"></td>\n\
                <td>' + lastValue[0] + '</td><td><input type="submit" value="Delete Item" onclick="deleteItem('+lastKey+')" /></td></tr>');
        });
    });

}

function saveCompletedItems() {
    var checked = [];
    // Get all the checked checkedboxes
    $("input[name='completed']:checked").each(function(i) {
        checked.push($(this).val());
    });

    // AJAX call to complete the item in the TODO list
    $.post('ajax-complete-item.php', {checked: checked}, function(data) {

    });
}

function deleteItem(id) {
    // AJAX call to remove the item from the TODO list
    $.post('ajax-delete-item.php', {id: id}, function(data) {
        // Lets remove the item from the DOM
        $('#' + id).remove();
    });
}