 <?php 

if (isset($_POST['search_books'])) {
  if (isset($_POST['attribute']))
  $selectedAttr = $_POST['attribute'];  // get the selected attribute
  else
    $selectedAttr = ''; // No (default) topic selected 
    } else { // list all books, no search selections
    $searchTerm = '';
    $selectedAttr = ''; }

 include('header.php'); 
 ?>
       <section id="controls">
            <form  method="post" onsubmit="return checkDisable();">
                <input class="button" type="submit" id="browse" name="browse_books" value="Browse" />
                <input class="search" type="text"   name="searchTerm" value="<?php echo $searchTerm;?>" size=10 />
				        <input class="button" type="submit" name="search_books" value="&#128269;" />
	              <select name = 'attribute'>
                  <option disabled = 'disabled' selected id = 'selection'> Select topic to search </option>
	                <option <?php if ($selectedAttr == 'Title') echo 'selected' ; ?> value='Title'>Title</option>
                  <option <?php if ($selectedAttr == 'Author') echo 'selected' ; ?> value='Author'>Author</option>
                  <option <?php if ($selectedAttr == 'Category') echo 'selected' ; ?> value='Category'>Category</option>
                </select>
                <input class="button" type="submit" id="add" name="add_books" value="Add Book"/>
            </form>
        </section>

<script type="text/javascript">
  function checkDisable() {
        document.getElementById('selection').disabled = false;
    }
</script>

<?php
if($bookcount != 0){
   echo "<table>
         <thead>
         <tr>
         <th>Title</th>
         <th>Author</th>
         <th>Category</th>
         <th>Publisher</th>
         </tr>
         </thead>
		 <tbody>";

   /* Add code to
      -- loop through the results associated with the query, e.g., while($result = $statement->fetch(PDO::FETCH_ASSOC))
      -- for each book, display a row (<tr>) with the values (<td>) for the Title, Author, Category
   */
      while($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $title = $result['Title'];
      $author = $result['Author'];
      $category = $result['Category'];
      $publisher = $result['Publisher'];
      $ISBN = $result['ISBN'];
      echo "<tr><td><a href=index.php?ISBN=$ISBN>".$title."</a></td><td>".$author."</td><td>".$category."</td><td>".$publisher."</td></tr>";}

   echo "</tbody></table>";
 }
   
   else{
    echo "No results found";
   }
?>

 <?php 
 include('footer.php'); 
 ?>
