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
    /*spcific to index*/
    article{
        width: 60%;
        margin: auto;
        background: #e1f3f2;
    }
    article #recentMovie{
        display: block;
        padding-left: 3em;
        padding-right: 3em;
        padding-top: 1em;
    }
    #recentMovie li{
        
        display: inline-block;
        padding-bottom: 2em;
    }
    /*spcific to index*/
    
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
    /*.button{
        background: #B0D6D4;
        border-radius: 0.1em;
        font-family: Arial;
        color: #777;
        font-size: 2em;
        padding: 0.3em;
    }
    .button:hover{
        background: #C9F2F0;
        border-radius: 0.1em;
        font-family: Arial;
        color: #777;
        font-size: 2em;
        padding: 0.3em;
    }*/
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
    /*
    nav{
        background: #e1f3f2;
    }
    #Logout, #profile{
        display: inline;
    }
    #searchBox{
        
    }
    nav div{
        display: inline-block;
        width: 20em;
    }
    
    div #loginPanel{
        display: block;
    }
    
    */
    
    
    /*beginning of genre panel*/
    /*
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
    }*/
    /*ending of genre panel*/
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
        <!--    <span class="icon"><i class="fa fa-search"></i></span>-->
            <input type="text" name="word" id="searchBar" value="search for films or actors" onmouseover="OnOver()" onmouseout="OnOut()" class="searchForm">
          <!--  <input type="submit" name="submit" value="search" id="searchBarButton"  class="button" class="searchForm" class="fa fa-search">-->
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
        <form action="index.php" method="post">
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

<!--All the code following is to retrive data on recent movies from DB --> 

<article>
    
<?php

//2.query data
    $query = "SELECT * from Films F WHERE F.Fname=ANY(SELECT DISTINCT S.Fname FROM Shows S);";
    $result = mysqli_query($connection,$query);

//3.use data 
    
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No data found in the database<br>";
    }
    else{
        //while($row = mysqli_fetch_assoc($result)){
        echo "<ul id=\"recentMovie\">";
        echo "<div><h2>Recent Movies<h2></div>";
        do{
            echo "<li class=\"film\">";
            echo "<h3>".$row["FName"]."</h3>";
            
            echo "<a href=\"movie.php?FName={$row["FName"]}\"><img src=\"{$row["FPicture"]}\" alt=\"{$row["FName"]}\"></a>"."<br>";
            //echo $row["FPicture"]."<br>";
            //echo $row["Schedule"]."<br>";
            echo "<p>Length: ".$row["FLength"]."</p>";
            echo "<p> Descritption: ".$row["FDescription"]."</p>";
            //echo "<hr><hr><hr>";
            echo "</li>";
        }
        while($row = mysqli_fetch_assoc($result));
        
        echo"</ul>";
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
        //document.getElementById("ID").style.display="none";
        //document.getElementById("CName").style.display="none";
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
        window.location.href="index.php";
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