<?php
require_once('databaseLibrary.php');
$db = null;
$bookcount = 1;
connectToDatabase();
$searchTerm = '';
$isbnarray = array();
$awardcount = 0;
$showaward = 0; //this variable controls whether to show the award info, bc adding the award info is not supported. so after adding, the info will not be showed. But when browsing or updating the info, the award info will be showed.

session_start();
// store the data of adding the book 
    $_SESSION["ISBN"] = '';
    $_SESSION["title"] = '';
    $_SESSION["author"] = '';
    $_SESSION["publisher"] = '';
    $_SESSION["format"] = '';
    $_SESSION["category"] = '';
    $_SESSION["description"] = '';
    $_SESSION["rating"] = '';
    $_SESSION["result"] = 0;
    $_SESSION["cover"] = '';

// Initial display of the index.php page
if ( empty($_POST) && empty($_GET) ){
   $statement = getListOfAllBooks();
   include('listView.php');
}

// User has clicked the Browse button
elseif (isset($_POST['browse_books'])){
    // Sets the Location HTTP header to the index page.
    // This will clear any $_POST or $_GET array contents.
	header('Location: index.php');
}

// User has clicked the Search button
elseif (isset($_POST['search_books'])){
   $searchAttribute = $_POST['attribute'];
   $searchTerm = $_POST['searchTerm'];
   $statement = searchBooks($searchAttribute, $searchTerm);
   include('listView.php');
}

// add a record
elseif (isset($_POST['add_books'])){
  include('addRecordView.php');
}

// save the record
elseif (isset($_POST['save_books'])){
      $ISBN = $_POST['ISBN'];
      $title = $_POST['Title'];
      $author = $_POST['Author'];
      $publisher = $_POST['Publisher'];
      $format = $_POST['Format'];
      $category = $_POST['Category'];
      $description = $_POST['Description'];
      $rating = $_POST['Rating'];
      $cover = $_POST['Cover'];

      //get the array of all the ISBNs
      getISBNarray();
      
      //if the book exists, then redirect to a same page but stores the value
      if(in_array($ISBN, $isbnarray)){
        $_SESSION["ISBN"] = $ISBN;
        $_SESSION["title"] = $title;
        $_SESSION["author"] = $author;
        $_SESSION["publisher"] = $publisher;
        $_SESSION["format"] = $format;
        $_SESSION["category"] = $category;
        $_SESSION["description"] = $description;
        $_SESSION["rating"] = $rating;
        $_SESSION["result"] = 1;
        $_SESSION["cover"] = $cover;
        include('addRecordView.php');
      }

      // if the book does not exist, just go and store it. Adding the award info is not supported, so $showaward = 0 by default.
      else{
      $statement = saveNewBook($ISBN,$title,$author,$publisher,$format,$category,$description,$rating, $cover);
      include('detailedRecordView.php');
      }
}
    
// update the record
elseif (isset($_POST['update_books'])) {
    $isbn = $_POST['isbn'];
    $statement = getBook($isbn);
    include('updateRecordView.php');
}

//save the updates
elseif (isset($_POST['save_updates'])) {
      $ISBN = $_POST['ISBN'];
      $title = $_POST['Title'];
      $author = $_POST['Author'];
      $publisher = $_POST['Publisher'];
      $format = $_POST['Format'];
      $category = $_POST['Category'];
      $description = $_POST['Description'];
      $rating = $_POST['Rating'];
      $cover = $_POST['Cover'];
      $statement = saveBookUpdate($ISBN,$title,$author,$publisher,$format,$category,$description,$rating,$cover);
      $statement_2 = getAward($ISBN); // no need to update the award info, just keep the same
      $awardcount = getAwardNum($ISBN); // get the award count
      if($awardcount!=0){ $showaward = 1; } // if the award count is not zero, then show the award info
      include('detailedRecordView.php');
}

//delete the book
elseif (isset($_POST['delete_books'])) {
      $isbn = $_POST['isbn'];
      $result = deleteBook($isbn);
      $result_2 = deleteAward($isbn); // delete from the book and award table
      if(($result)&&($result_2)){
        header('Location: index.php');
      }
}

// show detailed record view
elseif(!empty($_GET)){
  $isbn = $_GET['ISBN'];
  $statement = getBook($isbn);
  $statement_2 = getAward($isbn);
  $awardcount = getAwardNum($isbn); // get the award count
  if($awardcount!=0){ $showaward = 1; }// if the award count is not zero, then show the award info
  include('detailedRecordView.php');
}


?>

