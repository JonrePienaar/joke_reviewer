<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="default.css">

    <!-- default.css not loading in CHROME, but I didn't fix it because you said style does not matter (; -->
</head>
<body id="index">

    
<?php


function connect_db() {
    $conn = mysqli_connect("localhost", "root", "", "jokes_db");
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}


//  Checking if the details are correct and loging in(redirecting to jokes.php) if the details are correct.
function connect_login() {

    $conn = connect_db();

    $sql = "SELECT * FROM login_users WHERE 
    email = '$_SESSION[email]' AND login_password = '$_SESSION[password]'";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC); 
    var_dump($row);

    if(!empty($row['email']) && !empty($row['login_password']))  {
         $_SESSION['email'] = $row['login_password'];
         header("Location: jokes.php");
         $_SESSION['login'] = true;
     }
      else { echo "SORRY... YOU ENTERD WRONG ID OR PASSWORD... PLEASE RETRY..."; }

      
    

}
        


function get_joke() {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://safe-falls-22549.herokuapp.com/random_joke");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    $joke = json_decode($output, true);
    $_SESSION["global_joke"] = $joke;

    curl_close($ch);


    return $joke;
}


// checking if the joke and or review excists or not and calling functions accordingly.
function add_or_update($joke, $rating) {
    $conn = connect_db();

    $joke_id = $joke["id"];
    $sql = "SELECT * FROM jokes WHERE $joke_id = joke_id;";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    if(empty($row)){
        add_joke($joke);
    }

    $sql = "SELECT * FROM reviews WHERE $joke_id = joke_id;";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC); 
    if(empty($row)){
        add_review($joke, $rating);
        return;
    }
    update_review($joke, $rating);
    return;

}


// Adding the joke to the jokes table.
function add_joke($joke) {
    $joke_id = $joke["id"];
    $setup = $joke["setup"];
    $punchline = $joke["punchline"];

    $conn = connect_db();

    $joke_id = $joke["id"];
    $sql = "INSERT INTO jokes (joke_id, setup, punchline) VALUES ($joke_id, '$setup', '$punchline');";

    return mysqli_query($conn, $sql);

}

// Adding the rating and joke_id to the reviews table.
function add_review($joke, $rating) {
    $joke_id = $joke["id"];
    $conn = connect_db();
    $sql = "INSERT INTO reviews (joke_id, login_id, rating) VALUES ($joke_id, 1, $rating);";

    counter($joke);

    return mysqli_query($conn, $sql);
}


// Updating the rating.
function update_review($joke, $rating) {
    $conn = connect_db();
    $joke_id = $joke["id"];
    $sql = "SELECT rating FROM reviews WHERE $joke_id = joke_id;";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $old_rating = $row["rating"];
    $new_rating = $rating + $old_rating;

    $sql = "UPDATE reviews SET rating = $new_rating WHERE $joke_id = joke_id";

    counter($joke);

    return mysqli_query($conn, $sql);
}


// Adding 1 to the countz column every time the joke is rated.
function counter($joke) {
    $conn = connect_db();
    $joke_id = $joke["id"];
    $sql = "SELECT countz FROM reviews WHERE $joke_id = joke_id;";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $old_countz = $row["countz"];
    $new_countz = 1 + $old_countz;
    $sql = "UPDATE reviews SET countz = $new_countz WHERE $joke_id = joke_id";
    return mysqli_query($conn, $sql);
}


// Adding/Updating the average rating for the joke.
function  update_total($joke) {
    $conn = connect_db();
    $joke_id = $joke["id"];
    $sql = "SELECT rating, countz FROM reviews WHERE $joke_id = joke_id;";

    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $countz = $row["countz"];
    $rating = $row["rating"];
    $total = $rating;
    if(!empty($rating && $countz)) {
        $total = $rating / $countz;
    }
    $sql = "UPDATE reviews SET total = $total WHERE $joke_id = joke_id";
    return mysqli_query($conn, $sql);
}


// default.css not loading with CHROME so I did a bit of styling on here.
// Sorting the top 10 jokes and echoing it out.
function top_sorted() {
    $conn = connect_db();
    $sql = "SELECT setup, punchline, total, countz FROM jokes, reviews WHERE jokes.joke_id = reviews.joke_id ORDER BY total DESC LIMIT 10;";
    $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $i = 1;
    
    while($row = mysqli_fetch_assoc($result)) {
        $total = $row["total"];
        $total = round($total); ?>

        <div class="block">
            <div class="container-fluid">
                <div class="row">
                    <div class="lg-col-6 ">
                        <h1 class="number"><?php echo $i; ?></h1>
                        <p style = "color:grey" class="stup"><?php echo $row["setup"]; ?></p>
                        <p style = "color:blue" class="punchline"><?php echo $row["punchline"]; ?></p>
                        <p style = "color:red" class="rating"><?php echo "Average rating: " . $total; ?></p>
                        <p style = "color:green" class="countz"><?php echo "Total times rated: " . $row["countz"]; ?></p>
                    </div>
                    
                    <div class="lg-col-6 float-left content">
                        
                    </div>
                </div>
            </div>
        </div>

        <?php
    $i++;
        
    }
} else {
    echo "0 results";
}
    return;
}


?>
    
</body>
</html>




