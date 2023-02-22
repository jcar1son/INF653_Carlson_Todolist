<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List Assignment</title>
    <link rel="stylesheet" href="">
</head>
  <body>

  <!--Checking for xss attacks-->
  <?php
    require ("data.php");
    $nTitle = filter_input(INPUT_POST, "nTitle", FILTER_SANITIZE_STRING);
    $nDescription = filter_input(INPUT_POST, "nDescription", FILTER_SANITIZE_STRING);
  ?>

<section class="List">
  <h1>ToDo list</h1>

<!-- Returns the current list from the database -->
<?php
//Queries the current database for the added items executes the action and then closes the stream from the database
$query = "SELECT * FROM todoitems ORDER BY ItemNum ASC";
$statement = $db -> prepare($query);
$statement -> execute();
$out = $statement -> fetchAll();
$statement -> closeCursor();
?>


  <!--Section for inserting the title and description of the item to the to do list-->
<?php

  if ($nTitle && $nDescription){
    //Insert query for the new title and description of the to do items
    $query = "INSERT INTO todoitems (Title, Description) 
              Values (:nTitle, :nDescription)";

    //prepares the query and then binds the new values to the database and then closes the stream
    $statement = $db -> prepare($query);
    $statement->bindValue(':nTitle', $nTitle);
    $statement->bindValue(':nDescription', $nDescription);
    $statement->execute();
    $statement->closeCursor();

    //sends the user back to see the todo list and add items or remove them
    header("Location: .");
  }
?>

<!-- Section for setting the list containter-->
<?php if (!empty($out)){ ?>

    <div class = "List--container">
    <ul>
      <?php foreach ($out as $tList){
        $itemNum = $tList['ItemNum'];
        $description = $tList['Description'];
        $title = $tList['Title'];
      ?>
    <!-- Section for setting the title and description containter-->
    <li class = "item" id = "item-<?php echo $itemNum; ?>">
      <div class = "listC">
          <p class = "tTitle" id = "tTitle-<?php echo $itemNum; ?>"> <?php echo $title; ?> </p>
          <p class = "tDescription" id = "tDescription-<?php echo $itemNum; ?>"> <?php echo $description; ?> </p>
      </div>
    <!-- Section for setting the removal button-->
    <form action = "remove.php" method = "POST" class = "tDelete">
        <input type="hidden" name = "ItemNum" value = "<?php echo $itemNum; ?>">
        <button class = "dButton"> X </button>
    </form>
  </li>
<?php } ?>
</ul>
</div>
<?php } 
//outputs the message if there is no to do list items
  else { ?>
    <p class="message">There are no ToDo List items.</p>
<?php } ?>

</section>
<!--This section creates the forum for the title and description -->
<section class = "todoForum">
<h2>Add an Item!<h2>
<form action = "." method = "POST">
    <div class = "formDiv">
      <div class = "twoDiv">
        <!--This section allows the user to enter the title of the to do list item-->
        <input type = "text" name = "nTitle" id = "nTitle" maxlength = "20" placeholder = "The title" autocomplete = "off" class = "fField">
        <label for = "nTitle" class = "fLabel">Title</label>
      </div>
      <div class="form--group">
          <!--This section allows the user to enter the description of the to do list item-->
          <input type="text" name="nDescription" id="nDescription" maxlength = "50" placeholder = "The description" autocomplete = "off" class = "fField">
          <label for = "nDescription" class = "fLabel">Description</label>
        </div>
    </div>
    <!--button for adding the item to the database-->
    <button type = "addItem" class ?ItemNum?= "itemAdd">Add Item</button>
  </form>
</section>
</main>
</body>
</html>
