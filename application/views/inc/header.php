<html>
<head>
	<title><?php if(isset($pageTitle)){ echo $pageTitle; }?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/header-style.css" type="text/css">
</head>
<body>
    <div  id="logout">
         <?php if(isset($username)){
            echo " Welcome <span style='color: lightblue'>$username! </span>";
            echo "<a style='color: white' href='home/logout'>Logout</a>";
         }?>
    </div>
	<div class="header">

		<div class="wrapper">
			<h1 class="branding-title"><a href="./">Personal Media Library</a></h1>

			<ul class="nav">
                <li class="books <?php if($section == "books"){echo " on";}?>"><a href="<?php echo base_url();?>index.php/catalog?cat=books">Books</a></li>
                <li class="movies <?php if($section == "movies"){echo " on";}?>"><a href="catalog.php?cat=movies">Movies</a></li>
                <li class="music <?php if($section == "music"){echo " on";}?>"><a href="catalog.php?cat=music">Music</a></li>
                <li class="suggest <?php if($section == "suggest"){echo " on";}?>"><a href="suggest.php">Suggest</a></li>
            </ul>

		</div>

	</div>

	<div class="search">
		<form method="get" action="catalog.php">
			<label for="s">Search</label>
			<input type="text" name="s" id="s" />
			<input type="submit" value="go" />
		</form>
	</div>

	<div id="content">
