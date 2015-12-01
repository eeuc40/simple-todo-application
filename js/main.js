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
            var lastKey = Object.keys(obj).sort().reverse()[0];
            var lastValue = obj[lastKey];
            // Add a new Row to the table after the last table row
            $('#table tr:last').after('<tr><td><input type="checkbox" name="completed" value="' + lastKey + '"></td><td>' + lastValue[0] + '</td></tr>');
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