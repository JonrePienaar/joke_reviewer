
<?php
require("header.php");


// if($_SESSION['login'] == false){
//     header("location:index.php");
//  }


if(isset($_POST["logout"])){
    header("Location: index.php");
    session_unset();
}

 

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

        <li class="active about"><a href="top.php">Top 10 Jokes<span class="sr-only">(current)</span></a></li>
       <li class="hovy"><input type="submit" name="logout" value="logout" class="logout"></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
<div class=" me container">
</form>


<div class="container">
  <?php 
    // setting the null value to 0 to avoid errors
    if(empty($_POST["rating"])){
        $rating = 0;
    } else{
         $rating = $_POST["rating"];
    }
  
    $fetch_joke = get_joke($rating); 

    if(isset($_POST["rating_btn"])){
      $joke_id = $fetch_joke["id"];
      add_or_update($rating, $fetch_joke);
      update_total($fetch_joke);
    }
  ?>

  <h1 id='setup'>
    <?php 
      echo $fetch_joke["setup"]
    ?>
</h1> 

  <h1 id='punchline'>
    <?php 
      echo $fetch_joke["punchline"]
    ?>
  </h1>

  <form action=""method="POST">
  <select name="rating" id="rating">
  <option value="0">0</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  </select>

  <input type="submit" name="rating_btn">
  
  </form>

  <?php
  

  


  ?>




</div>





 <?php 
require("footer.php");
?>