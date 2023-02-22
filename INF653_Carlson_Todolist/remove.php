<?php
require ("data.php");
//-Checking for xss attacks during the removal of the item
$itemNum = filter_input(INPUT_POST, 'ItemNum', FILTER_VALIDATE_INT);

//if there is and item being requested to be removed
//then it querys the item and then removes it from the program and database
if ($itemNum) {
    $query = 'DELETE FROM todoitems
                WHERE ItemNum = :itemNum';
    $statement = $db->prepare($query);
    $statement -> bindValue(':itemNum', $itemNum);
    $success = $statement->execute();
    //then we close the stream to the database
    $statement -> closeCursor();
}

//sends the user back to see the todo list and add items or remove more
header("Location: .");
