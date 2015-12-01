<?php

include_once 'Database.class.php';

/**
 * The main class which deals with all the operations which can be made upon the
 * todo list.
 *
 * @author Richie
 */
class Todo {

    static $db;

    /**
     * Check to see if the database is already connected, if not then we should
     * connect
     */
    private static function databaseConnect() {
        if (!isset(self::$db)) {
            self::$db = new Database();
        }
    }

    /**
     * Allow the user to add an item to the todo list
     * 
     * @param string $content The content of the todo item
     * @param int $user The user id which added the new item
     */
    public static function addItem($content, $user) {
        self::databaseConnect();
        self::$db->query("INSERT INTO item(uid, todo) VALUES(:uid, :todo)");
        self::$db->bind(":uid", $user);
        self::$db->bind(":todo", $content);
        self::$db->execute();
    }

    /**
     * Wrapper function which allows a user to mark their todo task as complete
     * 
     * @param int $id The id of the item
     */
    public static function markComplete($id) {
        self::updateComplete($id, 1);
    }

    /**
     * Wrapper function to mark a task as incomplete
     * 
     * @param int $id The id of the item
     */
    public static function markIncomplete($id) {
        self::updateComplete($id, 0);
    }

    private static function updateComplete($id, $complete = 1) {
        self::databaseConnect();
        self::$db->query("UPDATE item SET complete = :complete WHERE id = :id");
        self::$db->bind(":complete", $complete);
        self::$db->bind(":id", $id);
        self::$db->execute();
    }

    /**
     * Function to get all the items for a given user
     * 
     * @param int $uid The user id of the user
     * @return string JSON encoded representation of all the items in the todo list
     */
    public static function getAllItems($uid) {
        self::databaseConnect();
        self::$db->query("SELECT * from item where uid=:uid");
        self::$db->bind(":uid", $uid);
        self::$db->execute();

        $array = array();

        while ($row = self::$db->getRow()) {
            $array[$row['id']] = array($row['todo'], $row['complete']);
        }
        
        return json_encode($array);
    }

    /**
     * Not implemented
     * 
     * @param int $id
     */
    public static function removeItem($id) {
        // TODO - Not required
    }

    /**
     * Not implemented
     * 
     * @param int $id
     * @param string $content The new content of the item
     */
    public static function editItem($id, $content) {
        // TODO - Not required
    }

}
