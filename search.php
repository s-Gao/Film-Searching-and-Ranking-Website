<?php
    $word = $_POST["word"];
    //echo $word;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome come to the Movie Fun</title>
    <style>
    #Logout, #profile{
        display: inline;
    }
    nav div{
        display: inline-block;
        width: 20em;
    }
    
    div #loginPanel{
        display: block;
    }
    ul #recentMovie li{
        display: inline-block;
    }
    
    /*beginning of genre panel*/
        #genrePanel{
        background-color: #999;
        height:35px;
        width:100%;
        margin-top: 20px;
    }
    .genreList{
        list-style-type: none;
    }
    .moreGenreList{
        list-style-type: none;
    }
    .majorGenre{
	 float: left;
	 display:block;
	 line-height: 5px;
	 padding: 0 20px;
    }
    .minorGenre{
	 float:none;
	 display:block;
	 line-height: 20px;
        padding-top: 20px;
	 padding: 10px 0 1px 0;
    }
    #moreGenreListBase ul{
        display: none;
    }
    #moreGenreListBase:hover ul{
        display:inherit;
    }
    /*ending of genre panel*/
</style>
</head>
<body>
<nav>
    <div id="logo">
    <a href="index.php">
    <img  src="http://i.imgur.com/iFfRG8n.png"  alt="logo" width="150" height="150">
    </a>
    </div>
    
    <div id="loginPanel">
    <?php
    //1.connect
    $dburl="";
    $dbuser="";
    $dbpassword="";
    $dbname="";
    $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
    if(mysqli_connect_errno()){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }
    
    //check if the cookie exists
    if(isset($_COOKIE["username"])&&isset($_COOKIE["password"])){
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];
        $queryClients = "SELECT * FROM Clients WHERE ID='{$username}' AND Password='{$password}'";
        $resultClients = mysqli_query($connection,$queryClients);
        if(!$queryClients||empty($row = mysqli_fetch_assoc($resultClients))){
            $message = "Please log in";
        }
        else{
            $cname = $row["CName"];
            $message = "Welcome! <div id='CName'>{$cname}</div><div id='ID'>{$username}</div>";
        }
    }
    //Verify User login information 
    else if(isset($_POST['submit'])&&isset($_POST['username'])&&isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        //2.query data
    $queryClients = "SELECT * FROM Clients WHERE ID='{$username}' AND Password='{$password}'";
    
    $resultClients = mysqli_query($connection,$queryClients);
//3.use data 
    if(!$queryClients){//No result result returned indicating synta error
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($resultClients))){
        $message = "incorrect username or password<br>please log in again";
    }
    else{
        $cname = $row["CName"];
        $message = "Welcome! <div id='CName'>{$cname}</div><div id='ID'>{$username}</div>";
        
        setcookie("username",$username,time()+3000);
        setcookie("password",$password,time()+3000);
        //$username = $_COOKIE["username"];
        //echo "cookie is".$_COOKIE["username"];
    }
    }
    else{
        $message = "Please log in";
    }
    
    echo "<div id=\"loginMessage\">".$message."</div>";
    ?>
    
    <div id="usefulButton">
        <div id="profile"></div>
        <div id="Logout"></div>
    </div>
    <div id="login">
        <form action="index.php" method="post">
            username:<input type="text" name="username" value=""><br>
            password: <input type="password" name="password" value=""><br>
            <input type="submit" name="submit" value="Login" id="loginButton">
        </form>
    </div>
    </div>
    
    
<script>
    
//if the user has already login, remove the login form in HTML
 if(document.getElementById("loginMessage").innerHTML.match("Welcome")){
        var ID = document.getElementById("ID").innerHTML;
        document.getElementById("ID").style.visibility="hidden";
        document.getElementById("login").innerHTML = "<br>";
        document.getElementById("profile").innerHTML="<a href=\"profile.php\">My Profile</a>";
        document.getElementById("Logout").innerHTML="<button type=\"button\" onclick=\"Logout()\">Logout</button>";
    }
    
    function Logout(){
        document.cookie = 'username' + '=""; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.cookie = 'password' + '=""; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        //window.location.href="index.php";
        window.location.href=window.location.href;
    }
    
    function OnOver(){
        if(document.getElementById("searchBar").value=="search for films,actors and theaters"){
            document.getElementById("searchBar").value="";
        }    
    }
    
    function OnOut(){
        if(document.getElementById("searchBar").value==""){
            document.getElementById("searchBar").value="search for films,actors and theaters";
        }
        
    }
</script>
    <!-- All the above code literally did one thing: Log in and check log in including cookies, which could be applied to all the pages.-->
        

    
    
        <div id="searchBox">
        <form action="search.php" method="post">
            <input type="text" name="word" id="searchBar" value="search for films,actors and theaters" onmouseover="OnOver()" onmouseout="OnOut()">
            <input type="submit" name="submit" value="search">
        </form>
        </div>


 <!--genre panel-->   
        <div id="genrePanel">
    <ul id="genreList" class="genreList">
        <li class="majorGenre"><a href="genre.php?genre=Action">Action</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Adventure">Adventure</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Comedy">Comedy</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Drama">Drama</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Family">Family</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Fantasy">Fantasy</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Film-Noir">Film-Noir</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Sci-Fi">Sci-Fi</a></li>
        <li class="majorGenre"><a href="genre.php?genre=Thriller">Thriller</a></li>
        <li class="majorGenre" id="moreGenreListBase">More Genres
        <ul class="moreGenreList">
            <li class="minorGenre"><a href="genre.php?genre=Animation">Animation</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Biography">Biography</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Crime">Crime</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Documentary">Documentary</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Family">Family</a></li>
            <li class="minorGenre"><a href="genre.php?genre=History">History</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Horror">Horror</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Music">Music</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Musical">Musical</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Mystery">Mystery</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Romance">Romance</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Sport">Sport</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Thriller">Thriller</a></li>
            <li class="minorGenre"><a href="genre.php?genre=War">War</a></li>
            <li class="minorGenre"><a href="genre.php?genre=Western">Western</a></li>
		</ul>
        </li>
        </ul>
    </div>

        
</nav>

    <?php
    ////1.connect
    $dburl="";
    $dbuser="";
    $dbpassword="";
    $dbname="";
    $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
    if(mysqli_connect_errno()){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }
    //2.1 query data of Actors
    
    $query = "SELECT * from Actors A WHERE A.AName LIKE '%{$word}%';";
    $result = mysqli_query($connection,$query);
    //3.1 use data
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "<div id=\"ActorNoResult\"><h3>No actor data found on \"{$word}\"</h3></div>";
    }
    else{
        //while($row = mysqli_fetch_assoc($result)){
        echo "<ol id=\"ActorResult\">";
        echo "<div><h3>Actor<h3></div>";
        do{ 
            echo "<li>";
            echo "{$row["AName"]}";
            echo "<br>";
            echo "<a href=\"actor.php?AName={$row["AName"]}\"><img src=\"{$row["APicture"]}\"></a>"."<br>";
             echo "</li>";
        }
        while($row = mysqli_fetch_assoc($result));
        echo "</ol>";
    }  
    
//2.2 query data of films
    $query = "SELECT * from Films F WHERE F.FName LIKE'%{$word}%';";
    $result = mysqli_query($connection,$query);
//3.2 use data
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "<div id=\"FilmNoResult\"><h3>No film data found on \"{$word}\"</h3></div>";
    }
    else{
        echo "<ol id=\"FilmResult\">";
        echo "<div><h3>Films<h3></div>";
        do{
            echo "<li>";
            echo $row["FName"]."<br>";
            
            echo "<a href=\"movie.php?FName={$row["FName"]}\"><img src=\"{$row["FPicture"]}\" alt=\"{$row["FName"]}\"></a>"."<br>";
            //echo $row["FPicture"]."<br>";
            //echo $row["Schedule"]."<br>";
            echo $row["FLength"]."<br>";
            echo $row["FDescription"]."<br>";
            //echo "<hr><hr><hr>";
            echo "</li>";
        }
        while($row = mysqli_fetch_assoc($result));
        
        echo"</ol>";
    }
   
//4.released returned data
    mysqli_free_result($result);
//5.close connection
    mysqli_close($connection);
    ?>
    

        
</body>
</html>