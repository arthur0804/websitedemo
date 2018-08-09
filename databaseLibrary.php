<?php
function connectToDatabase() {
   global $db;
   /* Add code to
      -- connect to the database
      -- set the error mode
      -- if an exception occurs, display an error message
   */
   try { 
      $db = new PDO('sqlite:Books.db'); 
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
   } 
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
}

function getListOfAllBooks() {
   global $db;
   /* Add code to
      -- execute a SELECT query that gets a list of all books
      -- this function must return $statement (after executing the prepared query)
      -- if an exception occurs, display an error message
      -- set a variable, e.g.,$bookCount, to the number of books returned by the query
         -- this variable will be useful in determining whether or not to display the "No results found" message
         -- there is no built-in function to obtain this value for SELECT queries, so you will need to develop your own algorithm
   */
   try{
      $query = "SELECT * FROM BOOK";
      $statement = $db->prepare($query);
      $statement->execute();
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;
}

function searchBooks($attr, $term) {
   global $db;
   global $bookcount;
   /* Add code to
      -- execute a SELECT query for the list of books that meet the search criteria
         -- $attr parameter corresponds to the selected value from the dropdown list (Title, Author, or Category)
         -- $term parameter corresponds to the search term entered by the user
      -- this function must return $statement (after executing the prepared query)
      -- if an exception occurs, display an error message
	  -- as in the previous function, set a variable, e.g.,$bookCount, to the number of books returned by the query
   */
   try{
      $searchterm = trim($term);
      switch ($attr) {
         case "Title":
            $query = "SELECT * FROM BOOK where Title LIKE '%$searchterm%' ORDER BY Title";
            $statement = $db->prepare($query);
            $statement->execute();

            $query2 = "SELECT count(*) FROM BOOK where Title LIKE '%$searchterm%' ORDER BY Title";
            $result = $db->query($query2);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            $bookcount = $data['count(*)'];
            break;

         case "Author":
            $query = "SELECT * FROM BOOK where Author LIKE '%$searchterm%' ORDER BY Author";
            $statement = $db->prepare($query);
            $statement->execute();

            $query2 = "SELECT count(*) FROM BOOK where Author LIKE '%$searchterm%' ORDER BY Author";
            $result = $db->query($query2);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            $bookcount = $data['count(*)'];
            break;

         case "Category":
            $query = "SELECT * FROM BOOK where Category LIKE '%$searchterm%' ORDER BY Category";
            $statement = $db->prepare($query);
            $statement->execute();

            $query2 = "SELECT count(*) FROM BOOK where Category LIKE '%$searchterm%' ORDER BY Category";
            $result = $db->query($query2);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            $bookcount = $data['count(*)']; 
            break;

         default:
            $query = "SELECT * FROM BOOK WHERE Title LIKE '%$searchterm%' OR Author LIKE '%$searchterm%' OR Category LIKE '%$searchterm%' ORDER BY Title";
            $statement = $db->prepare($query);
            $statement->execute();

            $query2 = "SELECT count(*) FROM BOOK WHERE Title LIKE '%$searchterm%' OR Author LIKE '%$searchterm%' OR Category LIKE '%$searchterm%' ORDER BY Title";
            $result = $db->query($query2);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            $bookcount = $data['count(*)']; 
            break;
      }
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;
}

function getBook ($isbn){
   global $db;
   try{
      $query = "SELECT * FROM BOOK where ISBN = '$isbn'";
      $statement = $db->prepare($query);
      $statement->execute();
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;
}

function getAward($isbn){
   global $db;
   try{
      $query = "SELECT AWARD.Award, AWARD.Category, AWARD.Year FROM AWARD where ISBN = '$isbn' ORDER BY AWARD.Year";
      $statement = $db->prepare($query);
      $statement->execute();
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;
}

function getAwardNum($isbn){
   global $db;
   try{
      $query = "SELECT COUNT(*) FROM AWARD where ISBN = '$isbn'";
      $result = $db->query($query);
      $data = $result->fetch(PDO::FETCH_ASSOC);
      $awardcount = $data['COUNT(*)']; 
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $awardcount;
}


function saveNewBook($ISBN,$title,$author,$publisher,$format,$category,$description,$rating,$cover){
   global $db;
   try{
      $insertstatement = "INSERT INTO BOOK VALUES ('$ISBN','$title','$author','$publisher','$format','$category','$description','$rating','$cover')";
      $statement = $db->prepare($insertstatement); 
      $statement->execute();
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;
}

function saveBookUpdate($ISBN,$title,$author,$publisher,$format,$category,$description,$rating,$cover){
  global $db;
  try{
      $updatestatement = "UPDATE BOOK SET Title = '$title', Author = '$author', Publisher = '$publisher', Format = '$format', Category = '$category', Description = '$description', Rating = '$rating', Cover = '$cover' WHERE ISBN = '$ISBN'";
      $statement = $db->prepare($updatestatement); 
      $statement->execute();
  }
  catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $statement;  
}

function deleteBook($ISBN){
  global $db;
  try{
      $deletestatement = "DELETE FROM BOOK WHERE ISBN = '$ISBN'";
      $statement = $db->prepare($deletestatement); 
      $statement->execute();
  }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return True;
}

function deleteAward($ISBN){
  global $db;
  try{
      $deletestatement = "DELETE FROM AWARD WHERE ISBN = '$ISBN'";
      $statement = $db->prepare($deletestatement); 
      $statement->execute();
  }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return True;
}

function getISBNarray(){
   global $db;
   global $isbnarray;
   try{
      $query = "SELECT ISBN FROM BOOK";
      $statement = $db->prepare($query);
      $statement->execute();
      while($result = $statement->fetch(PDO::FETCH_ASSOC)){
         $isbnarray[] = $result['ISBN'];
      }
   }
   catch (PDOException $e) { 
   $errorMessage = $e->getMessage(); 
   echo "<p>SQL error: $errorMessage </p>"; 
   $db = null; 
   exit(); 
   }
   return $isbnarray;
}
?>
