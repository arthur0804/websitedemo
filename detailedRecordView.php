<?php
include('header.php');
?>

<?php
global $showaward;

while($result = $statement->fetch(PDO::FETCH_ASSOC)){
	  $title = $result['Title'];
      $author = $result['Author'];
      $category = $result['Category'];
      $ISBN = $result['ISBN'];
      $publisher = $result['Publisher'];
      $format = $result['Format'];
      $description = $result['Description'];
      $rating = $result['Rating'];
      $cover = $result['Cover'];
}

//control whether to get the award info
if($showaward!=0){
	  while($result_2 = $statement_2->fetch(PDO::FETCH_ASSOC)){
	  $award[] = $result_2['Year'].' '.$result_2['Award'].' for '.$result_2['Category'];
}
}
?>

<form method="post" action="index.php"> 
	<section id="controls"> 
		<input class="button" type="submit" name="browse_books" value="Browse" /> 
		<input class="button" type="submit" name="update_books" value="Update" />
		<input class="button" type="submit" name="delete_books" value="Delete" />
		<input class="button" type="hidden" name="isbn" value="<?php echo $ISBN;?>"/>
		<!-- use a hidden variable to save the value -->
	</section> 

	<div class="col-container">
		<div class="flex-container">
		<aside id="cover">
		<?php 
		 $coverFileName = trim($cover);
		if((strlen($coverFileName) > 0) && (file_exists("images/".$cover))){
			echo "<img class = 'coverimg' src='images/".$cover."'>";}
		else{
			echo "<img class = 'coverimg' src='images/placeholder.png'>";
		}
		?>
		</aside>
			<section id="input"> 
		<span class="flex-input"><label>ISBN</label><?php echo $ISBN; ?></span>
		<span class="flex-input"><label>Title</label><?php echo $title; ?></span>
		<span class="flex-input"><label>Author</label><?php echo $author; ?></span>
		<span class="flex-input"><label>Publisher</label><?php echo $publisher; ?></span>
		<span class="flex-input"><label>Format</label><?php echo $format; ?></span>
		<span class="flex-input"><label>Category</label><?php echo $category; ?></span>	
		<span class="flex-input"><label>Rating</label>
		<?php 
		for ($i=0; $i < $rating ; $i++) { 
			echo "<i class='fas fa-book' style = 'font-size: 24px; color:red; margin-left:0.25em;'></i>";
		}
		?>
		</span>
		</section>
		</div> 
	<section id="bottominput">
		<p><label>Description</label>
		<p id="description"></p>
		<p id="moreLess" style="color: blue;">See more</p>
		</p>
		<?php 
		//control whether show the award info: if a book does not have any awards, then do not show
		if($showaward!=0){
			echo "<label>Award</label>";
			foreach ($award as $a) {
			echo $a.'&nbsp&nbsp';}	
		}
		?>
	</section>
	</div>
</form>

<script>
var description = "<?php echo $description ?>";
var short_description = description.substr(0,80);

document.getElementById("description").innerHTML = short_description; //show short at first
document.getElementById("moreLess").addEventListener('click', toggleContent);

function toggleContent(){
	if (this.textContent == 'See more'){
		document.getElementById("description").innerHTML = description;
		this.textContent = "See less";
	}
	else{
		document.getElementById("description").innerHTML = short_description;
		this.textContent = "See more";
	}
}

</script>

<?php
include('footer.php');
?>