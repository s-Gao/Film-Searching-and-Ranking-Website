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
    else if(isset($_POST['submit'])){
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
        $message = "incorrect username or password";
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
        $message = "not log in";
    }
    
    echo "<div id=\"loginMessage\" style=\"display:none\">".$message."</div>";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome come to the Movie Fun</title>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<style>
   /*spcific to genre*/
    article{
        width: 60%;
        margin: auto;
        background: #e1f3f2;
        padding-top: 1em;
    }
    
    article li{
        display: inline-block;
        padding-bottom: 2em;
    }
    h1{
        font-size:2em;
    }
    h2{
        font-size:1.5em;
    }
    /*spcific to genre*/
    
    nav{
        display: block;
        margin:0;
        background: -webkit-linear-gradient(left, #AEF2EF , #D5F2F1,#AEF2EF);
        background: -o-linear-gradient(right, #AEF2EF, #D5F2F1,#AEF2EF); 
        background: -moz-linear-gradient(right, #AEF2EF,#D5F2F1,#AEF2EF); 
        background: linear-gradient(to right, #AEF2EF , #D5F2F1,#AEF2EF); 
        background: #e1f3f2;
    }
    #navFirstRow{
        
        width: 100%;
        margin: auto;
        
    }
    .navFirstRow  {
        display: inline-block;
        padding-right: 3em;
        vertical-align: middle;
    }
    #searchBar{
      width: 13em;
      height: 1.7em;
      background: #EBF5F4;
      border: none;
      font-size: 2em;
      float: left;
      color: #777;
      padding-left: 1em;
      border-radius: 0.1em;
    }
    #loginPanel{
        font-family: "Lucida Grande",Georgia,Serif;
        font-size: 1.4em;
        
    }
    #loginButton{
        margin-left: 12em;
    }
    .loginBar{
        width: 10em;
        background: #DDEDEC;
    }
    #searchBarButton{
        padding: 0em,3em,10em,0;
    }
    nav section{
        display: inline-block;
        margin-top: 0;
    }
    
    
       #navSecondRow{
        background-color: #C9D4D3;
        height:2.5em;
        width:100%;
        padding: 0;
        margin: 0;
    }
    .genreList{
        list-style-type: none;
        color: blue;
    }
    .moreGenreList{
        list-style-type: none;
        margin: 0;
        padding:inherit;
    }
    .majorGenre{
	 float: left;
	 display:block;
	 line-height: 0.9em;
	 padding:0;
     font-family: "Lucida Grande",Georgia,Serif;
     font-size: 1.2em;
     
     padding-right: 0em;
     padding-left: 2em;
    }
    .minorGenre{
	 float:none;
	 display:block;
	 line-height: 0;
     font-size: 1em;
     padding-top: 2em;
     padding-right: 1em;
     
    }
    #moreGenreListBase ul{
        display: none;
        
        
    }
    #moreGenreListBase:hover ul{
        display:block;
        background-color: #C9D4D3;
        margin-left: -0.9em;
        padding-left: 0.9em;
        padding-bottom: 1em;
    }
</style>
</head>
<body>
<nav>
    <section id="navFirstRow">
    <div id="logo" class="navFirstRow">
    <a href="index.php">
    <img  src="http://i.imgur.com/kaFZatg.png"  alt="logo" width="200" height="200">
    </a>
    </div>
        
    <div id="searchBox" class="navFirstRow">
        <form action="search.php" method="post" >
            <input type="text" name="word" id="searchBar" value="search for films or actors" onmouseover="OnOver()" onmouseout="OnOut()" class="searchForm">
            <button type="submit" name="submit" value="search" id="searchBarButton"  class="btn btn-info btn-lg"><span class="glyphicon glyphicon-search"></span> Search</button>
        </form>
    </div>
    
    <div id="loginPanel" class="navFirstRow">
    <div id="usefulButton">
        <div id="greeting"></div>
        <div id="profile"></div>
        <div id="Logout"></div>
    </div>
    <div id="login">
        <div id="loginReminder"></div>
        <form  method="post">
            username: <input type="text" name="username" value="" class="loginBar"><br>
            password: <input type="password" name="password" value="" class="loginBar"><br>
            <input type="submit" name="submit" value="Login" id="loginButton"  class="button">
        </form>
    </div>
    </div>
    </section>

    <!-- All the above code literally did one thing: Log in and check log in including cookies, which could be applied to all the pages.-->
        



 <!--genre panel--> 
        <section id="navSecondRow">
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
    </section>

        
</nav>
<article>
<?php
    $GName = $_GET['genre'];
    //1.connect
    $dburl="";
    $dbuser="";
    $dbpassword="";
    $dbname="";
    $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
    if(mysqli_connect_errno()){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }
    //2.2query data
    $query = "SELECT * FROM Films WHERE Films.FName = ANY(SELECT H.FName from Has H WHERE H.GName=\"{$GName}\");";
    $result = mysqli_query($connection,$query);
    //3.2use data
    echo "<h1>".$GName." Movies:</h1>";
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "We don't have this type of movies on our website at the moment, sorry<br>";
    }
    else{
        echo "<ul>";
        do{
            echo "<li>";
            echo "<h2>{$row["FName"]}</h2>";
            echo "<a href=\"movie.php?FName={$row["FName"]}\"><img src=\"{$row["FPicture"]}\" alt=\"{$row["FName"]}\" width=\"455\" height=\"720\"></a>";
            echo "</li>";
        }
        while($row = mysqli_fetch_assoc($result));
        echo "</ul>";
    }
//4.released returned data
    mysqli_free_result($result);
//5.close connection
    mysqli_close($connection);
?>

</article>
    
<script>
    
//if the user has already login, remove the login form in HTML
 if(document.getElementById("loginMessage").innerHTML.match("Welcome")){
        var ID = document.getElementById("ID").innerHTML;
        var CName=document.getElementById("CName").innerHTML;
        document.getElementById("greeting").innerHTML="Welcome! "+CName;
        document.getElementById("login").innerHTML = "";
        document.getElementById("profile").innerHTML="<a href=\"profile.php\">My Profile</a>";
        document.getElementById("Logout").innerHTML="<button type=\"button\" onclick=\"Logout()\"  class=\"button\">Logout</button>";
    }
 if(document.getElementById("loginMessage").innerHTML.match("not log in")){
     document.getElementById("loginReminder").innerHTML="Please log in";
 }
 if(document.getElementById("loginMessage").innerHTML.match("incorrect username or password")){
     document.getElementById("loginReminder").innerHTML="Incorrect username or password.<br>Please log in again";
 }
    
    function Logout(){
        document.cookie = 'username' + '=""; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.cookie = 'password' + '=""; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        //window.location.href = "index.php";
        window.location.href=window.location.href;
    }
    
    function OnOver(){
        if(document.getElementById("searchBar").value=="search for films or actors"){
            document.getElementById("searchBar").value="";
        }    
    }
    
    function OnOut(){
        if(document.getElementById("searchBar").value==""){
            document.getElementById("searchBar").value="search for films or actors";
        }
        
        
    }
</script>
</body>
</html>