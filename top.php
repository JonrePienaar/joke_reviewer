<?php 
require("header.php");
?>



<nav class="navy navbar navbar-default">
<form action="" method="post">
<div class="container">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand msks" href="#">Joke Reviewer</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
       <li class="hovy"><a href="#tec">Ratings</a></li>

        <li class="active about"><a href="jokes.php">Joke's Home Page<span class="sr-only">(current)</span></a></li>
       <li class="hovy"><input type="submit" name="logout" value="logout" class="logout"></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
<div class=" me container">
</form>

<h1 class='top10'> The top 10 best Jokes</h1>

<?php
 top_sorted(); ?>







<?php require "footer.php"; ?>