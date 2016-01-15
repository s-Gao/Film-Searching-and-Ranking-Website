<?php 
    $FName = $_GET["FName"];
    if(isset($_POST["TName"])&&isset($_POST["ShowTime"])&&isset($_POST["TicketLeft"])){
        $TName = $_POST["TName"];
        $ShowTime = $_POST["ShowTime"];
        $TicketLeft = $_POST["TicketLeft"];
        $TicketLeftNew = $TicketLeft-1;
        
        $TicketID = time();
        $ID = $_COOKIE["username"];
        
        //1.connect
        $dburl="";
        $dbuser="";
        $dbpassword="";
        $dbname="";
        $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
        if(mysqli_connect_errno()){
            die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
        }
        //2.1 query of inserting
        $query = "INSERT INTO Buys VALUES ($TicketID,'$ID','$ShowTime','$FName','$TName');";
        $result = mysqli_query($connection,$query);
        //2.2 query of updating TicketLeft info
        $queryUpdate = "UPDATE Shows SET TicketLeft={$TicketLeftNew} WHERE TName='{$TName}' AND FName='{$FName}' AND ShowTime='{$ShowTime}';";
        $resultUpdate = mysqli_query($connection,$queryUpdate);
        //3. use data

        if(!$result || !$resultUpdate){
            die("Database query failed<br>");
        }
        else{
            header("Location: profile.php");
        }
        
        
        //4.released returned data. No need for insertion.
        //mysqli_free_result($result);
        //5.close connection
        mysqli_close($connection);
        }
        
        if(isset($_POST["score"])&&isset($_POST["comment"])){
            
            $score=$_POST["score"];
            $comment=$_POST["comment"];
            $ID = $_COOKIE["username"];
            //1.connect
            $dburl="";
            $dbuser="";
            $dbpassword="";
            $dbname="";
            $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
            if(mysqli_connect_errno()){
                die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
            }
            //2.1 query of inserting
            $query = "INSERT INTO RankFilms VALUES ($score,'$comment','$ID','$FName');";
            $result = mysqli_query($connection,$query);
            
            //3. use data

            if(!$result){
                die("Database query failed<br>");
            }
            else{
                //header("Location: profile.php");
            }


            //4.released returned data. No need for insertion.
            //mysqli_free_result($result);
            //5.close connection
            mysqli_close($connection);
        }

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Movie Page</title>

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
        window.location.href="index.php";
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
    
    function buyTicket(TName, FName, ShowTime,TicketLeft){
        
        
        var coo = document.cookie;
        if(coo==""){
            
            alert("Please log in before buying a ticket~");
        }
        else if(TicketLeft==0){
            alert("There's no ticket of this option");
        }
        else{
            var form = document.createElement("form");
            form.setAttribute("method","post");
            form.setAttribute("action","movie.php?FName="+FName);
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","TName");
            hiddenField1.setAttribute("value",TName);
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","ShowTime");
            hiddenField2.setAttribute("value",ShowTime);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","TicketLeft");
            hiddenField3.setAttribute("value",TicketLeft);
            form.appendChild(hiddenField3);

            document.body.appendChild(form);
            form.submit();
        } 
    }
    
    function comment(){
        var coo = document.cookie;
        if(coo==""){
            alert("Please log in before adding a comment~");
        }
        else if(document.getElementById("comment"+getCookie("username"))){
            alert("You have already added a comment");
        }
        else if(document.getElementById("selectScore").value==0){
            alert("Please give a score of the movie~");
        }
        else if(document.getElementById("textComment").value==""){
            alert("Please add comment on the movie~");
        }
        else{
            var comment=document.getElementById("textComment").value;
            var score=document.getElementById("selectScore").value;
            
            var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","score");
            hiddenField1.setAttribute("value",score);
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","comment");
            hiddenField2.setAttribute("value",comment);
            form.appendChild(hiddenField2);
            
            document.body.appendChild(form);
            form.submit();
            
        }
        
        
    }
    function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
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
    
    

    $query = "SELECT * FROM (SELECT F.FName,F.FLength,F.FPicture,F.FDescription,S.TName,S.Price,S.ShowTime,S.TimeZone,S.TicketLeft,S.Venue from Films F JOIN Shows S ON F.FName=S.FName) FS WHERE FS.FName=\"{$FName}\";";
    $result = mysqli_query($connection,$query);
//3.1 use data
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No data found in the database<br>";
    }
    else{
        //while(){
            
        echo $row["FName"]."<br>";
            
            echo "<a href=\"movie.php?FName={$row["FName"]}\"><img src=\"{$row["FPicture"]}\" alt=\"{$row["FName"]}\"></a>"."<br>";
            //echo $row["FPicture"]."<br>";
            //echo $row["Schedule"]."<br>";
            echo "Length:<br>".$row["FLength"]."<br>";
            echo "Description:<br>".$row["FDescription"]."<br>";
            echo "<h3>Tickets Info</h3>";
            echo "<ul>";
            do{
                echo "<li>";
                echo "<ul>";
                echo "<li>";
                echo "<a href=\"theater.php?TName={$row["TName"]}\">".$row["TName"]."</a>";
                echo "<button  onClick=\"buyTicket('{$row["TName"]}','{$row["FName"]}','{$row["ShowTime"]}','{$row["TicketLeft"]}')\">Buy!</button>";
                echo "</li>";
                echo "<li>";
                echo "Venue: ".$row["Venue"];
                echo "</li>";
                echo "<li>";
                echo "Price: $".$row["Price"];
                echo "</li>";
                echo "<li>";
                echo "ShowTime: ".$row["ShowTime"]." ".$row["TimeZone"];
                echo "</li>";
                echo "<li>";
                echo "TicketLeft: ".$row["TicketLeft"];
                echo "</li>";
                echo "</ul>";
                echo "</li>";
            }
            while($row = mysqli_fetch_assoc($result));
            echo "</ul>";
    }
    
    
    
//2.2 query data of Actors
    echo "<h3>Actors:</h3>";
    $query = "SELECT A.AName from Acts A WHERE A.FName=\"{$FName}\";";
    $result = mysqli_query($connection,$query);
//3.2 use data
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No Actors information at the moment<br>";
    }
    else{
        //while($row = mysqli_fetch_assoc($result)){
            
        do{ 
            echo "<a href=\"actor.php?AName={$row["AName"]}\">{$row["AName"]}</a>"."<br>";
            //echo $row["FPicture"]."<br>";
            //echo $row["Schedule"]."<br>";
        }
        while($row = mysqli_fetch_assoc($result));
    }    
//2.3 query data of Comments
    
    
    $query = "SELECT * from RankFilms WHERE RankFilms.FName=\"{$FName}\";";
    $result = mysqli_query($connection,$query);
//3.3 use data 
    echo "<h3>Rankings and Comments of {$FName}</h3>";
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No comments on this movie yet<br>";
    }
    else{
        
    echo "<ol>";
            do{
                echo "<li>";
                echo "<ul id=\"comment{$row["ID"]}\">";
                
                echo "<li>";
                echo "ID: ".$row["ID"];
                echo "</li>";
                echo "<li>";
                echo "Score: ".$row["FScore"];
                echo "</li>";
                echo "<li>";
                echo "Comments: ".$row["FRemarks"];
                echo "</li>";
                
                echo "</ul>";
                echo "</li>";
            }
            while($row = mysqli_fetch_assoc($result));
            echo "</ol>";
    }
    
//4.released returned data
    mysqli_free_result($result);
//5.close connection
    mysqli_close($connection);
    
?>
    <h3>Your Ranking and Comment:</h3>
    <div id="score">
        <select id="selectScore">
            <option value="0">score</option>
            <option value="1">1: very poor</option>
            <option value="2">2: poor</option>
            <option value="3">3: fair</option>
            <option value="4">4: good</option>
            <option value="5">5: very good</option>
        </select>
    </div>
    <div id="comment">
        <textarea id="textComment"></textarea>
    </div>
    <button onclick="comment()">Add Comment</button>

<script>
    
</script>

        
</body>
</html>