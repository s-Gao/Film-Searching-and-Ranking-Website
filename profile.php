<?php
   if(isset($_POST["Table"])&&(isset($_POST["AName"])||isset($_POST["FName"])||isset($_POST["TName"]))&&isset($_POST["ID"])){
       //1.connect
            $dburl="";
            $dbuser="";
            $dbpassword="";
            $dbname="";
            $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
            if(mysqli_connect_errno()){
                die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
            }
        //2.query data
            
            if(isset($_POST["FName"])){
                $FName = $_POST["FName"];
                $query = "DELETE FROM {$_POST["Table"]} WHERE {$_POST["Table"]}.FName=\"{$FName}\" AND {$_POST["Table"]}.ID=\"{$_POST["ID"]}\";";
            }
            else if(isset($_POST["AName"])){
                $AName = $_POST["AName"];
                $query = "DELETE FROM {$_POST["Table"]} WHERE {$_POST["Table"]}.AName=\"{$AName}\" AND {$_POST["Table"]}.ID=\"{$_POST["ID"]}\";";
            }
            else{
                $TName = $_POST["TName"];
                $query = "DELETE FROM {$_POST["Table"]} WHERE {$_POST["Table"]}.TName=\"{$TName}\" AND {$_POST["Table"]}.ID=\"{$_POST["ID"]}\";";
            }
       
       
            
            
            $result = mysqli_query($connection,$query);
            
            
            if(!$result){
                die("Database query failed<br>");
            }
            else{
                //header("Location: profile.php");
            }
            //3.use data
        //4.released returned data. No need for delete.
                    //mysqli_free_result($result1);
        //5.close connection
                    mysqli_close($connection);
   } if(isset($_POST["cancelID"])&&isset($_POST["TName"])&&isset($_POST["FName"])&&isset($_POST["ShowTime"])){//this means a ticket has been cancelled
        //1.connect
            $dburl="";
            $dbuser="";
            $dbpassword="";
            $dbname="";
            $connection = mysqli_connect($dburl,$dbuser,$dbpassword,$dbname);
            if(mysqli_connect_errno()){
                die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
            }
        //2.query data

            $cancelID = $_POST["cancelID"];
            $TName = $_POST["TName"];
            
            $FName = $_POST["FName"];
            
            $ShowTime = $_POST["ShowTime"];
            
            $query = "DELETE FROM Buys WHERE Buys.TicketID=\"{$cancelID}\";";
            $result = mysqli_query($connection,$query);
            $query1 = "SELECT TicketLeft FROM Shows WHERE TName='{$TName}' AND FName='{$FName}' AND ShowTime='{$ShowTime}';";
            $result1 = mysqli_query($connection,$query1);
            $row = mysqli_fetch_assoc($result1);
            $TicketLeft = $row["TicketLeft"];
            $TicketLeftNew = $TicketLeft + 1;
            $query2 = "UPDATE Shows SET TicketLeft={$TicketLeftNew} WHERE TName='{$TName}' AND FName='{$FName}' AND ShowTime='{$ShowTime}'; ";
            $result2 = mysqli_query($connection,$query2);
            
            
            if(!$result || !$result1 ||!$result2){
                die("Database query failed<br>");
            }
            else{
                //header("Location: profile.php");
            }
            //3.use data
        //4.released returned data. No need for delete.
                    mysqli_free_result($result1);
        //5.close connection
                    mysqli_close($connection);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Profile</title>
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
    
    function cancelFilmComment(FName,ID){
        var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","RankFilms");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","FName");
            hiddenField2.setAttribute("value",FName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","ID");
            hiddenField3.setAttribute("value",ID);
            form.appendChild(hiddenField3);
            
            document.body.appendChild(form);
            form.submit();
    }
    function cancelActorComment(AName,ID){
        var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","RankActors");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","AName");
            hiddenField2.setAttribute("value",AName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","ID");
            hiddenField3.setAttribute("value",ID);
            form.appendChild(hiddenField3);
            
            document.body.appendChild(form);
            form.submit();
    }
    
    function cancelTheaterComment(TName,ID){
        var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","RankTheaters");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","TName");
            hiddenField2.setAttribute("value",TName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","ID");
            hiddenField3.setAttribute("value",ID);
            form.appendChild(hiddenField3);
            
            document.body.appendChild(form);
            form.submit();
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
    <h2>Basic Info</h2>
    <ul id="basicInfo"></ul>
    <?php
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
//2.query data
    
    echo "<li>ID: ".$ID."</li>";
    $query = "SELECT * from Clients C WHERE C.ID=\"{$ID}\";";
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
            
        do{
            
            echo "<li id=\"Email\">Email: ".$row["Email"]."</li>";
        }
        while($row = mysqli_fetch_assoc($result));
    }
//2.1 query data of user profile
    $query = "SELECT * from Customers C WHERE C.ID=\"{$ID}\";";
    $result = mysqli_query($connection,$query);
//3.1 use data
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No data found in the database<br>";
    }
    else{
        //while($row = mysqli_fetch_assoc($result)){
            
        do{
            echo "<li id=\"phone\">Phone: ".$row["Phone"]."</li>";
            echo "<li id=\"address\">Address: ".$row["CAddress"]."</li>";
        }
        while($row = mysqli_fetch_assoc($result));
    }
?>  
    <div id="changeEmail">
    <button id="changeEmailButton" type="button" onclick="changeEmail()">Modify Email</button>
        <div id="changeEmailForm">
        </div>
    </div>
    
<script>
    
    function changeEmail(){
        var str="<form  method=\"post\">New Email:<br><input type=\"text\"name=\"newEmail\" value=\"\"><input type=\"submit\" name=\"submit\" value=\"Change\" onClick=\"afterChangeEmail()\"></form>";
        //eDIV = document.createElement("div");
        //eDIV.setAttribute("id","changeEmailForm");
        //eDIV.appendChild(str);
        //document.getElementById("updateMessage").innerHTML="";
        document.getElementById("changeEmailButton").style.visibility="hidden";
        document.getElementById("changeEmailForm").innerHTML=str;
        
        
    }
    function afterChangeEmail(){
        document.getElementById("changeEmailButton").style.visibility="display";
    }
    
    function cancelTicket(cancelID,TName,FName,ShowTime){
        
        //alert("successfully cancel the ticket"+cancelID);
        var method = "post";
        var form = document.createElement("form");
        form.setAttribute("method",method);
        form.setAttribute("action","profile.php");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type","hidden");
        hiddenField.setAttribute("name","cancelID");
        hiddenField.setAttribute("value",cancelID);
        form.appendChild(hiddenField);
        var hiddenField1 = document.createElement("input");
        hiddenField1.setAttribute("type","hidden");
        hiddenField1.setAttribute("name","TName");
        hiddenField1.setAttribute("value",TName);
        form.appendChild(hiddenField1);
        var hiddenField2 = document.createElement("input");
        hiddenField2.setAttribute("type","hidden");
        hiddenField2.setAttribute("name","FName");
        hiddenField2.setAttribute("value",FName);
        form.appendChild(hiddenField2);
        var hiddenField3 = document.createElement("input");
        hiddenField3.setAttribute("type","hidden");
        hiddenField3.setAttribute("name","ShowTime");
        hiddenField3.setAttribute("value",ShowTime);
        form.appendChild(hiddenField3);
        
        
        document.body.appendChild(form);
        alert("cancel ticket with ID: "+cancelID);
        form.submit();
        
    }
    
</script>
    
    
    <div id="ticketDIV">
        <h2>Tickets(FROM New to Old): </h2>
        <ol id="tickets">
            <?php
            //2.2 query data of tickets
                $query = "SELECT * FROM Buys WHERE ID='{$ID}' ORDER BY TicketID DESC;";
                $result = mysqli_query($connection,$query);
            //3.2 use data
                if(!$result){
                    die("Database query failed<br>");
                }
                else if(empty($row = mysqli_fetch_assoc($result))){
                    echo "No tickets yet<br>";
                }
                else{
                    do{
                        echo "<li><ul>";
                        echo "<li>Movie: <a href=\"movie.php?FName={$row["FName"]}\">{$row["FName"]}</a>";
                        echo "</li>";
                        echo "<li>TicketID: ".$row["TicketID"];
                        echo "<button id=\"{$row["TicketID"]}\" onclick=\"cancelTicket(this.id,'{$row["TName"]}','{$row["FName"]}','{$row["ShowTime"]}')\">Cancel Ticket</button>";
                        echo "</li>";
                        echo "<li>Theater: "."<a href=\"theater.php?TName={$row["TName"]}\">".$row["TName"]."</a>";
                        echo "</li>";
                        echo "<li>ShowTime: ".$row["ShowTime"];
                        echo "</li>";
                        
                        echo "</ul></li>";
                    }
                    while($row = mysqli_fetch_assoc($result));
                }
                //4.released returned data
                    mysqli_free_result($result);
                
            ?>
        </ol>
    </div>
    
    <div id="commentDIV">
        <h2>Rankings and Comment: </h2>
        <ul id="catogoryOfComment">
            
            <li id="commentOnFilm">
                <h3>On Movies:</h3>
        <ol id="commentOnFilmList">
            <?php
            //2.2 query data of tickets
                $query = "SELECT * FROM RankFilms WHERE ID='{$ID}';";
                $result = mysqli_query($connection,$query);
            //3.2 use data
                if(!$result){
                    die("Database query failed<br>");
                }
                else if(empty($row = mysqli_fetch_assoc($result))){
                    echo "No tickets yet<br>";
                }
                else{
                    
                    do{
                        echo "<li><ul>";
                        echo "<li>Movie: <a href=\"movie.php?FName={$row["FName"]}\">{$row["FName"]}</a>";
                        echo "<button id=\"{$row["FName"]}{$row["FScore"]}\" onclick=\"cancelFilmComment('{$row["FName"]}','{$row["ID"]}')\">Cancel Comment</button>";
                        echo "</li>";
                        echo "<li>Ranking: ".$row["FScore"];
                        echo "</li>";
                        echo "<li>Comment: ".$row["FRemarks"];
                        echo "</li>"; 
                        echo "</ul></li>";
                    }
                    while($row = mysqli_fetch_assoc($result));
                    
                }
                //4.released returned data
                    mysqli_free_result($result);
                
            ?>
        </ol>
        </li>
            
        <li id="commentOnActor">
                <h3>On Actors:</h3>
        <ol id="commentOnActorList">
            <?php
            //2.2 query data of tickets
                $query = "SELECT * FROM RankActors WHERE ID='{$ID}';";
                $result = mysqli_query($connection,$query);
            //3.2 use data
                if(!$result){
                    die("Database query failed<br>");
                }
                else if(empty($row = mysqli_fetch_assoc($result))){
                    echo "No tickets yet<br>";
                }
                else{
                    
                    do{
                        echo "<li><ul>";
                        echo "<li>Actor: <a href=\"actor.php?AName={$row["AName"]}\">{$row["AName"]}</a>";
                        echo "<button id=\"{$row["AName"]}{$row["AScore"]}\" onclick=\"cancelActorComment('{$row["AName"]}','{$row["ID"]}')\">Cancel Comment</button>";
                        echo "</li>";
                        echo "<li>Ranking: ".$row["AScore"];
                        
                        echo "</li>";
                        echo "<li>Comment: ".$row["ARemarks"];
                        echo "</li>"; 
                        echo "</ul></li>";
                    }
                    while($row = mysqli_fetch_assoc($result));
                    
                }
                //4.released returned data
                    mysqli_free_result($result);
                
            ?>
        </ol>
        </li>
        
        <li id="commentOnTheater">
                <h3>On Theaters:</h3>
        <ol id="commentOnActorList">
            <?php
            //2.2 query data of tickets
                $query = "SELECT * FROM RankTheaters WHERE ID='{$ID}';";
                $result = mysqli_query($connection,$query);
            //3.2 use data
                if(!$result){
                    die("Database query failed<br>");
                }
                else if(empty($row = mysqli_fetch_assoc($result))){
                    echo "No tickets yet<br>";
                }
                else{
                    
                    do{
                        echo "<li><ul>";
                        echo "<li>Theater: <a href=\"theater.php?TName={$row["TName"]}\">{$row["TName"]}</a>";
                        echo "<button id=\"{$row["TName"]}{$row["TScore"]}\" onclick=\"cancelTheaterComment('{$row["TName"]}','{$row["ID"]}')\">Cancel Comment</button>";
                        echo "</li>";
                        echo "<li>Ranking: ".$row["TScore"];
                        
                        echo "</li>";
                        echo "<li>Comment: ".$row["TRemarks"];
                        echo "</li>"; 
                        echo "</ul></li>";
                    }
                    while($row = mysqli_fetch_assoc($result));
                    
                }
                //4.released returned data
                    mysqli_free_result($result);
                //5.close connection
                    mysqli_close($connection);
            ?>
        </ol>
        </li>
            
            
        </ul>
    </div>
        
<?php
    //modify email address using Object style PHP
    if(isset($_POST["newEmail"])){
        if(strpos($_POST["newEmail"],'@')&&strpos($_POST["newEmail"],'.')){
            //Update User information
            //1.connect
            $dburl="";
            $dbuser="";
            $dbpassword="";
            $dbname="";
            $connectionObject =  new mysqli($dburl,$dbuser,$dbpassword,$dbname);
            if ($connectionObject->connect_error) {
            die("Connection failed: " . $connectionObject->connect_error);
            } 
            $newEmail = $_POST["newEmail"];
            $queryUpdateEmail = "Update Clients SET Email='{$newEmail}' WHERE ID='{$ID}';";
            if ($connectionObject->query($queryUpdateEmail) === TRUE) {
                echo "Record updated successfully";
            } else {
            echo "Error updating record: " . $connectionObject->error;
            }
            //echo "<div>";

                $connectionObject->close();
            echo "<script> alert(\"successfully update!\")</script>";
            header("Refresh:0");   
        }
        else{
            echo "<script> alert(\"You should type in a correct email address\")</script>";
            header("Refresh:0");
        }
        
    }
        
    
?>
</body>
</html>