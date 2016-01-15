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
        $queryClients = "SELECT * FROM (SELECT C.ID, C.Password FROM Clients C JOIN Admins A ON C.ID=A.ID)CA WHERE CA.ID='{$username}' AND CA.Password='{$password}';";
        //echo $queryClients;
        $resultClients = mysqli_query($connection,$queryClients);
        if(!$queryClients||empty($row = mysqli_fetch_assoc($resultClients))){
            echo "<div id=\"check\"></div>";
        }
        else{//the user is an Admin
                if(isset($_POST["Table"])&&isset($_POST["TName"])&&isset($_POST["Attribute"])&&isset($_POST["Content"])){
        $query="UPDATE {$_POST["Table"]} SET {$_POST["Attribute"]}=\"{$_POST["Content"]}\" WHERE TName=\"{$_POST["TName"]}\"";
        //echo $query;
                    $result = mysqli_query($connection,$query);
                    if(!$result){
        die("Database query failed<br>");
    }
    }
            if(isset($_POST["Table"])&&isset($_POST["FName"])&&isset($_POST["Attribute"])&&isset($_POST["Content"])){
        $query="UPDATE {$_POST["Table"]} SET {$_POST["Attribute"]}=\"{$_POST["Content"]}\" WHERE FName=\"{$_POST["FName"]}\"";
        //echo $query;
                    $result = mysqli_query($connection,$query);
                    if(!$result){
        die("Database query failed<br>");
    }
    }
            if(isset($_POST["Table"])&&isset($_POST["AName"])&&isset($_POST["Attribute"])&&isset($_POST["Content"])){
        $query="UPDATE {$_POST["Table"]} SET {$_POST["Attribute"]}=\"{$_POST["Content"]}\" WHERE AName=\"{$_POST["AName"]}\"";
        //echo $query;
                    $result = mysqli_query($connection,$query);
                    if(!$result){
        die("Database query failed<br>");
    }
    }
            if(isset($_POST["Table"])&&isset($_POST["TName"])&&isset($_POST["FName"])&&isset($_POST["ShowTime"])&&isset($_POST["Attribute"])&&isset($_POST["Content"])){
        $query="UPDATE {$_POST["Table"]} SET {$_POST["Attribute"]}='{$_POST["Content"]}' WHERE TName='{$_POST["TName"]}' AND FName='{$_POST["FName"]}' AND ShowTime='{$_POST["ShowTime"]}'";
        //echo $query;
                    $result = mysqli_query($connection,$query);
                    if(!$result){
        die("Database query failed<br>");
    }
    }
            
            
        }//end of excution of Admin
    }
    else{
        echo "<div id=\"check\"></div>";
    }
//5.close connection
    mysqli_close($connection);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome come to the Movie Fun</title>
</head>
<body>
    <h1>Modify Information</h1>
<script>
    window.onload=function(){
        if(document.getElementById("check")!=null){
            alert("No Authorization");
            window.location.href="index.php";
        }
    };
    function theater(){
        var TName = document.getElementById("selectTheaters").value;
        var Attribute = document.getElementById("selectAttributeTheater").value;
        var Content = document.getElementById("textModifyTheater").value;
        if(TName==0||Attribute==0){
            alert("Please select both terms correctly");
        }
        else{
            var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","Theaters");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","TName");
            hiddenField2.setAttribute("value",TName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","Attribute");
            hiddenField3.setAttribute("value",Attribute);
            form.appendChild(hiddenField3);
            var hiddenField4 = document.createElement("input");
            hiddenField4.setAttribute("type","hidden");
            hiddenField4.setAttribute("name","Content");
            hiddenField4.setAttribute("value",Content);
            form.appendChild(hiddenField4);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    function film(){
        var FName = document.getElementById("selectFilms").value;
        var Attribute = document.getElementById("selectAttributeFilm").value;
        var Content = document.getElementById("textModifyFilm").value;
        if(FName==0||Attribute==0){
            alert("Please select both terms correctly");
        }
        else{
            var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","Films");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","FName");
            hiddenField2.setAttribute("value",FName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","Attribute");
            hiddenField3.setAttribute("value",Attribute);
            form.appendChild(hiddenField3);
            var hiddenField4 = document.createElement("input");
            hiddenField4.setAttribute("type","hidden");
            hiddenField4.setAttribute("name","Content");
            hiddenField4.setAttribute("value",Content);
            form.appendChild(hiddenField4);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function actor(){
        var AName = document.getElementById("selectActors").value;
        var Attribute = document.getElementById("selectAttributeActor").value;
        var Content = document.getElementById("textModifyActor").value;
        if(AName==0||Attribute==0){
            alert("Please select both terms correctly");
        }
        else{
            var form = document.createElement("form");
            form.setAttribute("method","post");
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("type","hidden");
            hiddenField1.setAttribute("name","Table");
            hiddenField1.setAttribute("value","Actors");
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type","hidden");
            hiddenField2.setAttribute("name","AName");
            hiddenField2.setAttribute("value",AName);
            form.appendChild(hiddenField2);
            var hiddenField3 = document.createElement("input");
            hiddenField3.setAttribute("type","hidden");
            hiddenField3.setAttribute("name","Attribute");
            hiddenField3.setAttribute("value",Attribute);
            form.appendChild(hiddenField3);
            var hiddenField4 = document.createElement("input");
            hiddenField4.setAttribute("type","hidden");
            hiddenField4.setAttribute("name","Content");
            hiddenField4.setAttribute("value",Content);
            form.appendChild(hiddenField4);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
</script>
    
    
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
    //2.query data
    $query = "select TName from Theaters order by TName";
    $result = mysqli_query($connection,$query);
    //3.use data
    echo "<h2>Theaters</h2>";
        echo "<div id=\"modifyTheaters\">";
            echo "<select id=\"selectTheaters\">";
                echo "<option value=\"0\">Theater Name</option>";
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No Theater exists";
    }
    else{
        do{
                echo "<option value=\"{$row["TName"]}\">{$row["TName"]}</option>";
    }
    while($row = mysqli_fetch_assoc($result));
                
                
            echo "</select>";
        echo "</div>";
    }
    //4.released returned data
    mysqli_free_result($result);
    
?>  
    <div>
    <select id="selectAttributeTheater">
        <option value="0">Select one attribute</option>
        <option value="TAddress">TAddress</option>
        <option value="TPicture">TPicture</option>
        <option value="TDescription">TDescription</option>
        <option value="Parking">Parking</option>
        <option value="Longitude">Longitude</option>
        <option value="Latitude">Latitude</option>
    </select>
    </div>
    <div>
    <textarea id="textModifyTheater"></textarea>
    </div>
    <div>
    <button onclick="theater()">Change</button>
    </div>
    
    
    
    
<?php
    //2.query data
    $query = "select FName from Films order by FName";
    $result = mysqli_query($connection,$query);
    //3.use data
    echo "<h2>Films</h2>";
        echo "<div id=\"modifyFilms\">";
            echo "<select id=\"selectFilms\">";
                echo "<option value=\"0\">Film Name</option>";
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No Film exists";
    }
    else{
        do{
                echo "<option value=\"{$row["FName"]}\">{$row["FName"]}</option>";
    }
    while($row = mysqli_fetch_assoc($result));
                
                
            echo "</select>";
        echo "</div>";
    }
    //4.released returned data
    mysqli_free_result($result);
    
    
?>
    <div>
    <select id="selectAttributeFilm">
        <option value="0">Select one attribute</option>
        <option value="FPicture">FPicture</option>
        <option value="Schedule">Schedule</option>
        <option value="FLength">FLength</option>
        <option value="FDescription">FDescription</option>
    </select>
    </div>
    <div>
    <textarea id="textModifyFilm"></textarea>
    </div>
    <div>
    <button onclick="film()">Change</button>
    </div>
    
<?php
    //2.query data
    $query = "select AName from Actors order by AName";
    $result = mysqli_query($connection,$query);
    //3.use data
    echo "<h2>Actors</h2>";
        echo "<div id=\"modifyActors\">";
            echo "<select id=\"selectActors\">";
                echo "<option value=\"0\">Actor Name</option>";
    if(!$result){
        die("Database query failed<br>");
    }
    else if(empty($row = mysqli_fetch_assoc($result))){
        echo "No Actor exists";
    }
    else{
        do{
                echo "<option value=\"{$row["AName"]}\">{$row["AName"]}</option>";
    }
    while($row = mysqli_fetch_assoc($result));
                
                
            echo "</select>";
        echo "</div>";
    }
    //4.released returned data
    mysqli_free_result($result);
    //5.close connection
    mysqli_close($connection);
?>
    <div>
    <select id="selectAttributeActor">
        <option value="0">Select one attribute</option>
        <option value="APicture">APicture</option>
        <option value="Biography">Biography</option>
    </select>
    </div>
    <div>
    <textarea id="textModifyActor"></textarea>
    </div>
    <div>
    <button onclick="actor()">Change</button>
    </div>
</body>
</html>