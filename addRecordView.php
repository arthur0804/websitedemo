<?php
include('header.php');
?>
<script type="text/javascript">
 	function validateForm(){
	var isbn = document.forms["addbook"]["ISBN"].value;
	var title = document.forms["addbook"]["Title"].value;
	var author = document.forms["addbook"]["Author"].value;
	var publisher = document.forms["addbook"]["Publisher"].value;
	var description = document.forms["addbook"]["Description"].value;
	var cover = document.forms["addbook"]["Cover"].value;

	function checkISBN(){
		// check isbn not null
		if(isbn == ""){
			var isbnErr = document.getElementById("isbnErr");
			isbnErr.textContent = "ISBN cannot be empty!";
			return false;
		}
		// check isbn length
		else if(isbn.length != 14){
			var isbnErr = document.getElementById("isbnErr");
			isbnErr.textContent = "Please check the ISBN length!";
			return false;
		}
		// check isbn format
		else if((isbn.substr(0,4)!= "978-")&&(isbn.substr(0,4)!= "979-")){
			var isbnErr = document.getElementById("isbnErr");
			isbnErr.textContent = "Please enter a correct ISBN format!";
			return false;
		}
		else{
		var isbnErr = document.getElementById("isbnErr");
		isbnErr.textContent = "";
		return true;
		}
	}

	function checkTitle(){
		//	check title
		if(title.length < 1){
		var titleErr = document.getElementById("titleErr");
		titleErr.textContent = "Title must have at least 1 alphanumeric character";
		return false;
		}
		else{
		var titleErr = document.getElementById("titleErr");
		titleErr.textContent = "";
		return true;
		}
	}

	function checkAuthor(){
		// check author
		if(author.length < 3){
		var authorErr = document.getElementById("authorErr");
		authorErr.textContent = "Author must have at least 3 alphanumeric character";
		return false;
		}
		else{
		var authorErr = document.getElementById("authorErr");
		authorErr.textContent = "";
		return true;	
		}
	}

	function checkPublisher(){
		// check publisher
		if(publisher.length < 5){
		var publisherErr = document.getElementById("publisherErr");
		publisherErr.textContent = "Publisher must have at least 5 alphanumeric character";
		return false;
		}
		else{
		var publisherErr = document.getElementById("publisherErr");
		publisherErr.textContent = "";
		return true;
		}
	}

	function checkDescription(){
		// check description
		if(description.length < 20){
		var descriptionErr = document.getElementById("descriptionErr");
		descriptionErr.textContent = "Description must have at least 20 characters";
		return false;
		}
		else{
		var descriptionErr = document.getElementById("descriptionErr");
		descriptionErr.textContent = "";
		return true;	
		}
	}

	function checkCover(){
	// check cover
	if(cover != ""){
		if((cover.substr(-4)!= ".jpg")&&(cover.substr(-4)!= ".png")&&(cover.substr(-4)!= ".gif")){
			var coverErr = document.getElementById("coverErr");
			coverErr.textContent = "Please check cover format";
			return false;
		}
		else{
			var coverErr = document.getElementById("coverErr");
			coverErr.textContent = "";
			return true;
		}
	}
	else{
		return true;
	}
	}

	var a = checkISBN();
	var b = checkTitle();
	var c = checkAuthor();
	var d = checkPublisher();
	var e = checkDescription();
	var f = checkCover();

	if(a&&b&&c&&d&&e&&f){
		return true;
	}
	else{
		checkISBN();
		checkTitle();
		checkAuthor();
		checkPublisher();
		checkDescription();
		checkCover();
		return false;
	}
}
 </script>
<form method="post" action="index.php" name="addbook" onsubmit="return validateForm(this);">
	<section id="controls">
		<input class="button" type="button" id="browse" name="browse_books" value="Browse" onclick="window.location='index.php'" />
		<input class="button" type="submit" id="save" name="save_books" value="Save Book"/>
	</section>
	<section id="input"> 
		<span class="flex-input"><label>ISBN</label><input type="text" name="ISBN" value="<?php echo $_SESSION["ISBN"];?>"><div id = "isbnErr" style="color:red;">
		<?php
			if($_SESSION["result"]==1){
				echo "This book alreay exists";
			}
		?>
		</div>
		</span>
		<span class="flex-input"><label>Title</label><input type="text" name="Title" value="<?php echo $_SESSION["title"];?>"></span><div id = "titleErr" style="color:red;"></div>
		<span class="flex-input"><label>Author</label><input type="text" name="Author" value="<?php echo $_SESSION["author"];?>"></span><div id = "authorErr" style="color:red;"></div>
		<span class="flex-input"><label>Publisher</label><input type="text" name="Publisher" value="<?php echo $_SESSION["publisher"];?>"></span><div id = "publisherErr" style="color:red;"></div>
		<span class="flex-input"><label>Format</label>
			<select name = "Format">
				<option <?php if($_SESSION["format"]=='eBook'){echo 'selected';} ?> value="eBook" >eBook</option>
				<option <?php if($_SESSION["format"]=='Hardcover'){echo 'selected';} ?> value="Hardcover">Hardcover</option>
				<option <?php if($_SESSION["format"]=='Paperback'){echo 'selected';} ?> value="Paperback">Paperback</option>
				<option <?php if($_SESSION["format"]=='Audio'){echo 'selected';} ?> value="Audio">Audio</option>
			</select>
		</span>
		<span class="flex-input"><label>Category</label>
			<select name = "Category">
				<option <?php if($_SESSION["category"]=='Biography'){echo 'selected';} ?> value="Biography" >Biography</option>
				<option <?php if($_SESSION["category"]=='Children'){echo 'selected';} ?> value="Children">Children</option>
				<option <?php if($_SESSION["category"]=='Historical Fiction'){echo 'selected';} ?> value="Historical Fiction">Historical Fiction</option>
				<option <?php if($_SESSION["category"]=='History'){echo 'selected';} ?> value="History">History</option>
				<option <?php if($_SESSION["category"]=='Literary Fiction'){echo 'selected';} ?> value="Literary Fiction">Literary Fiction</option>
				<option <?php if($_SESSION["category"]=='Literature'){echo 'selected';} ?> value="Literature,">Literature,</option>
				<option <?php if($_SESSION["category"]=='Novel'){echo 'selected';} ?> value="Novel">Novel</option>
				<option <?php if($_SESSION["category"]=='Poetry'){echo 'selected';} ?> value="Poetry">Poetry</option>
			</select>
		</span>
		<span class="flex-input"><label>Description</label><input type="text" name="Description" value="<?php echo $_SESSION["description"];?>" maxlength="200" style="width:200%;"></span><div id = "descriptionErr" style="color:red;"></div>
		<span class="flex-input"><label>Rating</label><input type="number" name="Rating" value="<?php echo $_SESSION["rating"];?>" min="1" max="5"></span>
		<span class="flex-input"><label>Cover</label><input type="text" name="Cover" value="<?php echo $_SESSION["cover"];?>"></span><div id = "coverErr" style="color:red;"></div>
	</section> 
</form>

<?php
include('footer.php');
?>