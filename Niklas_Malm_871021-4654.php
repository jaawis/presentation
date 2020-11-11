<!DOCTYPE html>

<html>
    
    <head>
        <meta charset="utf-8">
        <style>
            body {
                margin: 0px;
            }
            
            #header{
                position: relative;
                width: 100%;
                height: 100px;
                background: linear-gradient(to bottom, lightslategrey 1%, lightgrey, white);
                text-align: center;
            }
            
            #main{
                position: relative;
                width: 100%;
                height: 500px;
                background-image: url("main-image6.png");
                background-repeat: repeat-x;
                background-size: 100% 100%;
            }
            
            #content{
                position: relative;
                color: white;
                text-align: center;
                padding: 30px;
            }
            
            #footer{
                position: fixed;
                background-color: lightgrey;
                width: 100%;
                height: 100%;
            }
            
            #alien{
                width: 5%;
                height: auto;
                display: block;
                margin: auto;
            }
            
            table {
                border-collapse: collapse;
                background-color: white;
                margin: auto;
                color: black;
            }
            td, th {
                border: 1px solid black;
            }
            
            .tableall th{
                background-color: lightslategrey;
                height: 30px;
                width: 225px;
                font-size: 16px;
            }
            
            .tableall tr:hover {
                background-color: lightgoldenrodyellow;
            }
            
            #buttontop{
                font: 15px Verdana;
                height: 40px;
                width: 100px;
                outline: none;
                background-color: transparent;
            }
            
            #buttontop:hover{
                background-color: lightgoldenrodyellow;
            }
            
            #buttondown{
                width: 100px;
                outline: none;
            }
            
            #buttondown:active{
                background-color: lightgoldenrodyellow;
            }
        </style>
    </head>
    
    <body>
        <div id="header">
            <br>
            <!--MENYVAL-->
            <form action='Niklas_Malm_871021-4654.php' method='POST'>
                <p>
                    <input type='submit' id='buttontop' name='alien' value='Alien' class='alien'>
                    <input type='submit' id='buttontop' name='vapen' value='Vapen' class='vapen'>
                    <input type='submit' id='buttontop' name='skepp' value='Skepp' class='skepp'>
                    <input type='submit' id='buttontop' name='incident' value='Incident' class='incident'>
                </p>
            </form>
        </div>
        
        <div id="main">
            <div id="content">
                <?php
                
                $pdo = new PDO('mysql:dbname=a15nikma;host=wwwlab.iit.his.se', 'sqllab', 'Tomten2009');
                $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
                $pdo->exec('set names utf8');
                
                //MENYVAL -> ALIEN (Isset hanterar här vad som ska visas då användaren valt "Alien" i toppmenyn)
                if(isset($_POST['alien']) || isset($_POST['alien_add']) || isset($_POST['alien_delete']) || isset($_POST['alien_weapon_connect']) || isset($_POST['alien_ship_connect']) || isset($_POST['alien_alienID']) || isset($_POST['alien_alienID1']) || isset($_POST['alien_alienID2']) || isset($_POST['alien_delete_alienID']) || isset($_POST['alien_vapenID'])){
                    //Form för den undermeny som finns tillgänglig under "Alien"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "<p>";
                            echo "<input type='submit' id='buttondown' name='alien_add' value='Lägg till Alien' class='alien_add'>";
                            echo "<input type='submit' id='buttondown' name='alien_weapon_connect' value='Tilldela Vapen' class='alien_weapon_connect'>";
                            echo "<input type='submit' id='buttondown' name='alien_ship_connect' value='Tilldela Skepp' class='alien_ship_connect'>";
                            echo "<input type='submit' id='buttondown' name='alien_delete' value='Ta bort Alien' class='alien_delete'>";
                        echo "</p>";
                    echo "</form>";
                }
                
                //MENYVAL -> ALIEN -> LÄGG TILL ALIEN (Isset hanterar här vad som ska visas då användaren valt "Lägg till Alien" i undermenyn)
                if(isset($_POST['alien_add']) || isset($_POST['alien_alienID'])){
                    //Form för att göra en INSERT till tabellen "Alien"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "Alien-ID: <input type='text' name='alien_alienID' placeholder='25 Tecken' size='25' /> ";
                        echo "Rasnamn: <input type='text' name='alien_rasnamn' size='25' /> ";
                        
                        echo "<select size='1' name='alien_farlighet' />";
                        echo "<option value='0'>Välj Farlighetsgrad</option>";
                        //Tar fram "Farlighetskod" från tabellen "Farlighet" som är valbar i en select box
                        foreach($pdo->query( 'SELECT * FROM farlighet ORDER BY farlighetskod;' ) as $row){
                            echo '<option value="'.$row['farlighetskod'].'">';
                            echo $row['farlighetskod'];
                            echo '</option>';
                        }
                        echo "</select>";
                        
                    echo "<input type='submit' value='Lägg till' />";
                    echo "</form>";
                
                    echo "<br>";
                    //Då "Alien-ID" har initierats och skickats i ovanstående formulär uppdateras databasen (Tabellen Alien) med en INSERT
                    if(isset($_POST['alien_alienID'])){
                        $querystring='INSERT INTO alien (alienID,farlighet,rasnamn) VALUES (:alienID,:farlighet,:rasnamn);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':alienID', $_POST['alien_alienID']);
                        $stmt->bindParam(':farlighet', $_POST['alien_farlighet']);
                        $stmt->bindParam(':rasnamn', $_POST['alien_rasnamn']);
                        $stmt->execute();
                    }
                }
                
                //MENYVAL -> ALIEN -> TA BORT ALIEN (Isset hanterar här vad som ska visas då användaren valt "Ta bort Alien" i undermenyn)
                if(isset($_POST['alien_delete']) || isset($_POST['alien_delete_alienID'])){
                    //Form för att göra en DELETE till tabellen "Alien"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='alien_delete_alienID' />";
                    echo "<option value='0'>Välj Alien-ID</option>";
                    //Då "Alien-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Alien") med en DELETE
                    $sql = "DELETE FROM alien WHERE alienID = :alienID;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':alienID', $_POST['alien_delete_alienID']);   
                    $stmt->execute();
                    //Tar fram "Alien-ID" från tabellen "Alien" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM alien ORDER BY alienID;' ) as $row){
                        echo '<option value="'.$row['alienID'].'">';
                        echo $row['alienID'];
                        echo '</option>';
                    }
                    
                    echo "</select>";
                    echo " <input type='submit' value='Radera' />";
                    echo "</form>";
                    
                    echo "<br>";
                }
                
                //MENYVAL -> ALIEN -> TILLDELA VAPEN (Isset hanterar här vad som ska visas då användaren valt "Tilldela Vapen" i undermenyn)
                if(isset($_POST['alien_weapon_connect']) || isset($_POST['alien_alienID1']) || isset($_POST['alien_vapenID'])){
                    //Form för att göra en INSERT till tabellen "Alienvapen"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='alien_alienID1' />";
                    echo "<option value='0'>Välj Alien-ID</option>";
                    //Tar fram "Alien-ID" från tabellen "Alien" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM alien ORDER BY alienID;' ) as $row){
                        echo '<option value="'.$row['alienID'].'">';
                        echo $row['alienID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo "<select size='1' name='alien_vapenID' />";
                    echo "<option value='0'>Välj Vapen-ID</option>";
                    //Tar fram "Vapen-ID" från tabellen "Vapen" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM vapen ORDER BY vapenID;' ) as $row){
                        echo '<option value="'.$row['vapenID'].'">';
                        echo $row['vapenID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo " <input type='submit' value='Tilldela' />";
                    echo "</form>";
                    
                    echo "<br>";
                    //Då "Alien-ID" samt "Vapen-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Alienvapen") med en INSERT
                    if(isset($_POST['alien_alienID1']) && isset($_POST['alien_vapenID'])){
                        $querystring='INSERT INTO alienvapen (alienID, vapenID) VALUES(:alienID, :vapenID);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':alienID', $_POST['alien_alienID1']);
                        $stmt->bindParam(':vapenID', $_POST['alien_vapenID']);
                        $stmt->execute();
                    }
                }
                
                //MENYVAL -> ALIEN -> TILLDELA SKEPP (Isset hanterar här vad som ska visas då användaren valt "Tilldela Skepp" i undermenyn)
                if(isset($_POST['alien_ship_connect']) || isset($_POST['alien_alienID2']) || isset($_POST['alien_skeppID'])){
                    //Form för att göra en INSERT till tabellen "Alienskepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='alien_alienID2' />";
                    echo "<option value='0'>Välj Alien-ID</option>";
                    //Tar fram "Alien-ID" från tabellen "Alien" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM alien ORDER BY alienID;' ) as $row){
                        echo '<option value="'.$row['alienID'].'">';
                        echo $row['alienID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo "<select size='1' name='alien_skeppID' />";
                    echo "<option value='0'>Välj Skepp-ID</option>";
                    //Tar fram "Skepp-ID" från tabellen "Skepp" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM skepp ORDER BY skeppID;' ) as $row){
                        echo '<option value="'.$row['skeppID'].'">';
                        echo $row['skeppID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo " <input type='submit' value='Tilldela' />";
                    echo "</form>";
                    
                    echo "<br>";
                    //Då "Alien-ID" samt "Skepp-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Alienskepp") med en INSERT
                    if(isset($_POST['alien_alienID2']) && isset($_POST['alien_skeppID'])){
                        $querystring='INSERT INTO alienskepp (alienID, skeppID) VALUES(:alienID, :skeppID);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':alienID', $_POST['alien_alienID2']);
                        $stmt->bindParam(':skeppID', $_POST['alien_skeppID']);
                        $stmt->execute();
                    }
                }
                
                //MENYVAL -> VAPEN (Isset hanterar här vad som ska visas då användaren valt "Vapen" i toppmenyn)
                if(isset($_POST['vapen']) || isset($_POST['vapen_add']) || isset($_POST['vapen_delete']) || isset($_POST['vapen_edit']) || isset($_POST['vapen_edit_vapenID']) || isset($_POST['vapen_namn']) || isset($_POST['vapen_vapenID'])){
                    //Form för den undermeny som finns tillgänglig under "Vapen"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "<p>";
                            echo "<input type='submit' id='buttondown' name='vapen_add' value='Lägg till Vapen' class='vapen_add'>";
                            echo "<input type='submit' id='buttondown' name='vapen_edit' value='Ändra Farlighet' class='vapen_edit'>";
                            echo "<input type='submit' id='buttondown' name='vapen_delete' value='Ta bort Vapen' class='vapen_delete'>";
                        echo "</p>";
                    echo "</form>";
                }
                
                //MENYVAL -> VAPEN -> LÄGG TILL VAPEN (Isset hanterar här vad som ska visas då användaren valt "Lägg till Vapen" i undermenyn)
                if(isset($_POST['vapen_add']) || isset($_POST['vapen_namn'])){
                    //Form för att göra en INSERT till tabellen "Vapen"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "Namn: <input type='text' name='vapen_namn' size='25' /> ";
                        echo "Tillverkat: <input type='text' name='vapen_tillverkat' placeholder='Planet' size='25' /> ";
                        
                        echo "<select size='1' name='vapen_farlighet' />";
                        echo "<option value='0'>Välj Farlighetsgrad</option>";
                        //Tar fram "Farlighetskod" från tabellen "Farlighet" som är valbar i en select box
                        foreach($pdo->query( 'SELECT * FROM farlighet ORDER BY farlighetskod;' ) as $row){
                            echo '<option value="'.$row['farlighetskod'].'">';
                            echo $row['farlighetskod'];
                            echo '</option>';
                        }
                        echo "</select>";
                    
                    echo "<input type='submit' value='Lägg till' />";
                    echo "</form>";
                
                    echo "<br>";
                    //Då "Vapen namn" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Vapen") med en INSERT
                    if(isset($_POST['vapen_namn'])){
                        $querystring='INSERT INTO vapen (namn,tillverkat,farlighet) VALUES (:namn,:tillverkat,:farlighet);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':namn', $_POST['vapen_namn']);
                        $stmt->bindParam(':tillverkat', $_POST['vapen_tillverkat']);
                        $stmt->bindParam(':farlighet', $_POST['vapen_farlighet']);
                        $stmt->execute();
                    }
                }
                
            //MENYVAL -> VAPEN -> ÄNDRA FARLIGHETSGRAD (Isset hanterar här vad som ska visas då användaren valt "Ändra farlighet" i undermenyn)
                if(isset($_POST['vapen_edit']) || isset($_POST['vapen_edit_vapenID'])){
                    //Form för att göra en UPDATE till tabellen "Vapen"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                        echo "<select size='1' name='vapen_edit_vapenID' />";
                        echo "<option value='0'>Välj Vapen-ID</option>";
                        //Tar fram "Vapen-ID" från tabellen "Vapen" som är valbar i en select box
                        foreach($pdo->query( 'SELECT * FROM vapen ORDER BY vapenID;' ) as $row){
                            echo '<option value="'.$row['vapenID'].'">';
                            echo $row['vapenID'];
                            echo '</option>';
                        }
                        echo "</select>";
                    
                        echo "<select size='1' name='vapen_edit_farlighet' />";
                        echo "<option value='0'>Välj Farlighetsgrad</option>";
                            //Tar fram "Farlighetskod" från tabellen "Farlighet" som är valbar i en select box
                            foreach($pdo->query( 'SELECT * FROM farlighet ORDER BY farlighetskod;' ) as $row){
                                echo '<option value="'.$row['farlighetskod'].'">';
                                echo $row['farlighetskod'];
                                echo '</option>';
                            }
                        echo "</select>";
                    echo " <input type='submit' value='Tilldela' />";
                    echo "</form>";
                    
                    echo "<br>";
                    //Då "Vapen-ID" och "Farlighetskod" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Vapen") med en UPDATE
                    if(isset($_POST['vapen_edit_vapenID']) && isset($_POST['vapen_edit_farlighet'])){
                        $sql = "UPDATE vapen SET farlighet = :farlighet WHERE vapenID = :vapenID";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':vapenID', $_POST['vapen_edit_vapenID']);
                        $stmt->bindParam(':farlighet', $_POST['vapen_edit_farlighet']);
                        $stmt->execute();
                    }
                }
                
            //MENYVAL -> VAPEN -> TA BORT VAPEN (Isset hanterar här vad som ska visas då användaren valt "Ta bort Vapen" i undermenyn)
                if(isset($_POST['vapen_delete']) || isset($_POST['vapen_vapenID'])){
                    //Form för att göra en DELETE till tabellen "Vapen"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='vapen_vapenID' />";
                    echo "<option value='0'>Välj Vapen-ID</option>";
                    //Då "Vapen-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Vapen") med en DELETE
                    $sql = "DELETE FROM vapen WHERE vapenID = :vapenID;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':vapenID', $_POST['vapen_vapenID']);
                    $stmt->execute();
                    //Tar fram "Vapen-ID" från tabellen "Vapen" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM vapen ORDER BY vapenID;' ) as $row){
                        echo '<option value="'.$row['vapenID'].'">';
                        echo $row['vapenID'];
                        echo '</option>';
                    }
                    
                    echo "</select>";
                    echo " <input type='submit' value='Radera' />";
                    echo "</form>";
                    
                    echo "<br>";
                }
                
            //MENYVAL -> SKEPP (Isset hanterar här vad som ska visas då användaren valt "Skepp" i toppmenyn)
                if(isset($_POST['skepp']) || isset($_POST['skepp_add']) || isset($_POST['skepp_delete']) || isset($_POST['skepp_delete_skeppID']) || isset($_POST['skepp_search']) || isset($_POST['skepp_edit']) || isset($_POST['skepp_weapon_connect']) || isset($_POST['search']) || isset($_POST['skepp_skeppID']) || isset($_POST['skepp_namn']) || isset($_POST['skepp_weapon_connect_ID'])){
                    //Form för den undermeny som finns tillgänglig under "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "<p>";
                            echo "<input type='submit' id='buttondown' name='skepp_add' value='Lägg till Skepp' class='skepp_add'>";
                            echo "<input type='submit' id='buttondown' name='skepp_weapon_connect' value='Tilldela Vapen' class='skepp_weapon_connect'>";
                            echo "<input type='submit' id='buttondown' name='skepp_search' value='Sök Skepp' class='skepp_search'>";
                            echo "<input type='submit' id='buttondown' name='skepp_edit' value='Ändra Sittplatser' class='skepp_edit'>";
                            echo "<input type='submit' id='buttondown' name='skepp_delete' value='Ta bort Skepp' class='skepp_delete'>";
                        echo "</p>";
                    echo "</form>";
                }
                
            //MENYVAL -> SKEPP -> LÄGG TILL SKEPP (Isset hanterar här vad som ska visas då användaren valt "Lägg till Skepp" i undermenyn)
                if(isset($_POST['skepp_add']) || isset($_POST['skepp_namn'])){
                    //Form för att göra en INSERT till tabellen "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "Namn: <input type='text' name='skepp_namn' size='25' /> ";
                        echo "Sittplatser: <input type='text' name='skepp_sittplatser' placeholder='1-5000' size='25' /> ";
                        echo "Tillverkat: <input type='text' name='skepp_tillverkat' placeholder='Planet' size='25' /> ";
                    echo "<input type='submit' value='Lägg till' />";
                    echo "</form>";
                
                    echo "<br>";
                    //Då "Skepp namn" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Skepp") med en INSERT
                    if(isset($_POST['skepp_namn'])){
                        $querystring='INSERT INTO skepp (namn,sittplatser,tillverkat) VALUES (:namn,:tillverkat,:farlighet);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':namn', $_POST['skepp_namn']);
                        $stmt->bindParam(':tillverkat', $_POST['skepp_sittplatser']);
                        $stmt->bindParam(':farlighet', $_POST['skepp_tillverkat']);
                        $stmt->execute();
                    }
                }
                
            //MENYVAL -> SKEPP -> SÖK SKEPP (Isset hanterar här vad som ska visas då användaren valt "Sök Skepp" i undermenyn)
                if(isset($_POST['skepp_search']) || isset($_POST['search'])){
                    //Form för att göra en SÖKNING mot tabellen "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                    echo "<input type='text' name='search' placeholder='Sök på namn'>";
                    echo "<input type='submit' value='Sök'>";
                    echo "</form>";
                    //Då användaren har initierat ett värde i textfältet och klickat på "Sök" i ovanstående formulär tar databasen fram de rader som innehåller alla de tecken som angetts
                    if(isset($_POST['search'])){
                        $search=$_POST['search'];
                    
                        $sql = 'SELECT * FROM skepp WHERE namn LIKE :search;';
                        $stmt = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    
                    echo "<br>";
                }
                
            //MENYVAL -> SKEPP -> ÄNDRA SITTPLATSER (FROM STORED PROCEDURE) (Isset hanterar här vad som ska visas då användaren valt "Ändra Sittplatser" i undermenyn)
                if(isset($_POST['skepp_edit']) || isset($_POST['skepp_skeppID'])){
                    //Form för att göra en UPDATE på en PROCEDURE till tabellen "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "<select size='1' name='skepp_skeppID' />";
                        echo "<option value='0'>Välj Skepp-ID</option>";
                        //Tar fram "Skepp-ID" från tabellen "Skepp" som är valbar i en select box
                        foreach($pdo->query( 'SELECT * FROM skepp ORDER BY skeppID;' ) as $row){
                            echo '<option value="'.$row['skeppID'].'">';
                            echo $row['skeppID'];
                            echo '</option>';
                        }
                    
                        echo "</select>";
                        echo "Sittplatser: <input type='text' name='skepp_sittplatser' placeholder='1-5000' size='25' /> ";
                    echo "<input type='submit' value='Ändra'>";
                    echo "</form>";
                    //Då "Skepp-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Skepp") med en UPDATE
                    if(isset($_POST['skepp_skeppID'])){
                        $sql = "CALL uppdatera_skepp_sittplatser(:skeppID, :sittplatser)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':skeppID', $_POST['skepp_skeppID']);
                        $stmt->bindParam(':sittplatser', $_POST['skepp_sittplatser']);
                        $stmt->execute();
                    }
                    
                    echo "<br>";
                }
                
            //MENYVAL -> SKEPP -> TILLDELA VAPEN (Isset hanterar här vad som ska visas då användaren valt "Tilldela Vapen" i undermenyn)
                if(isset($_POST['skepp_weapon_connect']) || isset($_POST['skepp_weapon_connect_id']) || isset($_POST['skepp_vapenID'])){
                    //Form för att göra en INSERT till tabellen "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='skepp_weapon_connect_ID' />";
                    echo "<option value='0'>Välj Skepp-ID</option>";
                    //Tar fram "Skepp-ID" från tabellen "Skepp" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM skepp ORDER BY skeppID;' ) as $row){
                        echo '<option value="'.$row['skeppID'].'">';
                        echo $row['skeppID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo "<select size='1' name='skepp_vapenID' />";
                    echo "<option value='0'>Välj Vapen-ID</option>";
                    //Tar fram "Vapen-ID" från tabellen "Vapen" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM vapen ORDER BY vapenID;' ) as $row){
                        echo '<option value="'.$row['vapenID'].'">';
                        echo $row['vapenID'];
                        echo '</option>';
                    }
                    echo "</select>";
                    
                    echo " <input type='submit' value='Tilldela' />";
                    echo "</form>";
                    
                    echo "<br>";
                    //Då "Skepp-ID" och "Vapen-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Skepp") med en INSERT
                    if(isset($_POST['skepp_weapon_connect_ID']) && isset($_POST['skepp_vapenID'])){
                        $querystring='INSERT INTO skeppvapen (skeppID, vapenID) VALUES(:skeppID, :vapenID);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':skeppID', $_POST['skepp_weapon_connect_ID']);
                        $stmt->bindParam(':vapenID', $_POST['skepp_vapenID']);
                        $stmt->execute();
                    }
                }
                
            //MENYVAL -> SKEPP -> TA BORT SKEPP (Isset hanterar här vad som ska visas då användaren valt "Ta bort Skepp" i undermenyn)
                if(isset($_POST['skepp_delete']) || isset($_POST['skepp_delete_skeppID'])){
                    //Form för att göra en DELETE till tabellen "Skepp"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='skepp_delete_skeppID' />";
                    echo "<option value='0'>Välj Skepp-ID</option>";
                    //Då "Skepp-ID" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Skepp") med en DELETE
                    $sql = "DELETE FROM skepp WHERE skeppID = :skeppID;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':skeppID', $_POST['skepp_delete_skeppID']);   
                    $stmt->execute();
                    //Tar fram "Skepp-ID" från tabellen "Skepp" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM skepp ORDER BY skeppID;' ) as $row){
                        echo '<option value="'.$row['skeppID'].'">';
                        echo $row['skeppID'];
                        echo '</option>';
                    }
                    
                    echo "</select>";
                    echo " <input type='submit' value='Radera' />";
                    echo "</form>";
                    
                    echo "<br>";
                }
                
            //MENYVAL -> INCIDENT (Isset hanterar här vad som ska visas då användaren valt "Incident" i toppmenyn)
                if(isset($_POST['incident']) || isset($_POST['incident_add']) || isset($_POST['incident_delete']) || isset($_POST['incident_namn']) || isset($_POST['incident_delete_nummer'])){
                    //Form för den undermeny som finns tillgänglig under "Incident"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "<p>";
                            echo "<input type='submit' id='buttondown' name='incident_add' value='Lägg till Incident' class='incident_add'>";
                            echo "<input type='submit' id='buttondown' name='incident_delete' value='Ta bort Incident' class='incident_delete'>";
                        echo "</p>";
                    echo "</form>";
                }
                
            //MENYVAL -> INCIDENT -> LÄGG TILL (Isset hanterar här vad som ska visas då användaren valt "Lägg till Incident" i undermenyn)
                if(isset($_POST['incident_add']) || isset($_POST['incident_namn'])){
                    //Form för att göra en INSERT till tabellen "Incident"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='POST'>";
                        echo "Namn: <input type='text' name='incident_namn' size='25' /> ";
                        echo "Nummer: <input type='text' name='incident_nummer' size='25' /> ";
                        echo "Plats: <input type='text' name='incident_plats' placeholder='Planet' size='25' /> ";
                    echo "<input type='submit' value='Lägg till' />";
                    echo "</form>";
                
                    echo "<br>";
                    //Då "Incident namn" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Incident") med en INSERT
                    if(isset($_POST['incident_namn'])){
                        $querystring='INSERT INTO incident (namn,nummer,plats) VALUES (:namn,:nummer,:plats);';
                        $stmt = $pdo->prepare($querystring);
                        $stmt->bindParam(':namn', $_POST['incident_namn']);
                        $stmt->bindParam(':nummer', $_POST['incident_nummer']);
                        $stmt->bindParam(':plats', $_POST['incident_plats']);
                        $stmt->execute();
                    }
                }
                
            //MENYVAL -> INCIDENT -> TA BORT (Isset hanterar här vad som ska visas då användaren valt "Ta bort Incident" i undermenyn)
                if(isset($_POST['incident_delete']) || isset($_POST['incident_delete_nummer'])){
                    //Form för att göra en DELETE till tabellen "Incident"
                    echo "<form action='Niklas_Malm_871021-4654.php' method='post'>";
                    echo "<select size='1' name='incident_delete_nummer' />";
                    echo "<option value='0'>Välj Incident-nummer</option>";
                    //Då "Incident nummer" har valts och skickats i ovanstående formulär uppdateras databasen (Tabellen "Incident") med en DELETE
                    $sql = "DELETE FROM incident WHERE nummer = :nummer;";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nummer', $_POST['incident_delete_nummer']);   
                    $stmt->execute();
                    //Tar fram "Incident nummer" från tabellen "Incident" som är valbar i en select box
                    foreach($pdo->query( 'SELECT * FROM incident ORDER BY nummer;' ) as $row){
                        echo '<option value="'.$row['nummer'].'">';
                        echo $row['nummer'];
                        echo '</option>';
                    }
                    
                    echo "</select>";
                    echo " <input type='submit' value='Radera' />";
                    echo "</form>";
                    
                    echo "<br>";
                }
                
            //TABELLER -> VAPEN -> LÄGG TILL/TA BORT/ÄNDRA FARLIGHETSGRAD (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['vapen_add']) || isset($_POST['vapen_delete']) || isset($_POST['vapen_edit']) || isset($_POST['vapen_namn']) || isset($_POST['vapen_vapenID']) | isset($_POST['vapen_edit_vapenID'])){
                echo "<table class='tableall'>";
                    echo "<th>Vapen-ID</th>";
                    echo "<th>Namn</th>";
                    echo "<th>Tillverkat</th>";
                    echo "<th>Farlighet</th>";
                //Tar fram alla rader från tabellen "Vapen" som sedan tilldelas en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM vapen") as $row){
                    echo "<tr>";
                        echo "<td>".$row['vapenID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                        echo "<td>".$row['tillverkat']."</td>";
                        echo "<td>".$row['farlighet']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> ALIEN -> LÄGG TILL/TA BORT (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['alien_add']) || isset($_POST['alien_delete']) || isset($_POST['alien_alienID']) || isset($_POST['alien_delete_alienID'])){
                echo "<table class='tableall'>";
                    echo "<th>Alien-ID</th>";
                    echo "<th>Farlighet</th>";
                    echo "<th>Rasnamn</th>";
                //Tar fram alla rader från tabellen "Alien" som sedan tilldelas en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM alien") as $row){
                    echo "<tr>";
                        echo "<td>".$row['alienID']."</td>";
                        echo "<td>".$row['farlighet']."</td>";
                        echo "<td>".$row['rasnamn']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> ALIEN -> TILLDELA VAPEN (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['alien_weapon_connect']) || isset($_POST['alien_alienID1']) || isset($_POST['alien_vapenID'])){
                echo "<table class='tableall'>";
                    echo "<th>Alien-ID</th>";
                    echo "<th>Vapen-ID</th>";
                    echo "<th>Vapen namn</th>";
                //Tar fram alla rader från tabellerna "Alienvapen" och "Vapen" där attributet "Vapen-ID" finns med i båda tabellerna, de tilldelas sedan en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM alienvapen, vapen WHERE vapen.vapenID = alienvapen.vapenID ORDER BY alienvapen.alienID") as $row){
                    echo "<tr>";
                        echo "<td>".$row['alienID']."</td>";
                        echo "<td>".$row['vapenID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> ALIEN -> TILLDELA SKEPP (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['alien_ship_connect']) || isset($_POST['alien_alienID2']) || isset($_POST['alien_skeppID'])){
                echo "<table class='tableall'>";
                    echo "<th>Alien-ID</th>";
                    echo "<th>Skepp-ID</th>";
                    echo "<th>Skepp namn</th>";
                //Tar fram alla rader från tabellerna "Alienskepp" och "Skepp" där attributet "Skepp-ID" finns med i båda tabellerna, de tilldelas sedan en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM alienskepp, skepp WHERE skepp.skeppID = alienskepp.skeppID ORDER BY alienskepp.alienID") as $row){
                    echo "<tr>";
                        echo "<td>".$row['alienID']."</td>";
                        echo "<td>".$row['skeppID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> SKEPP -> ÄNDRA SITTPLATSER/LÄGG TILL/TA BORT (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['skepp_edit']) || isset($_POST['skepp_skeppID']) || isset($_POST['skepp_add']) || isset($_POST['skepp_namn']) || isset($_POST['skepp_delete']) || isset($_POST['skepp_delete_skeppID'])){
                echo "<table class='tableall'>";
                    echo "<th>Skepp-ID</th>";
                    echo "<th>Namn</th>";
                    echo "<th>Sittplatser</th>";
                    echo "<th>Tillverkat</th>";
                //Tar fram alla rader från tabellen "Skepp" som sedan tilldelas en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM skepp") as $row){
                    echo "<tr>";
                        echo "<td>".$row['skeppID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                        echo "<td>".$row['sittplatser']."</td>";
                        echo "<td>".$row['tillverkat']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> SKEPP -> SÖK (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['search'])){
                echo "<table class='tableall'>";
                    echo "<th>Skepp-ID</th>";
                    echo "<th>Namn</th>";
                    echo "<th>Sittplatser</th>";
                    echo "<th>Tillverkat</th>";
                //Tar fram alla rader från tabellen "Skepp" som innehåller de tecken som angetts i ett sökfält, de tilldelas sedan en rad och visas i en tabell
                foreach($stmt as $key => $row){
                    echo "<tr>";
                        echo "<td>".$row['skeppID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                        echo "<td>".$row['sittplatser']."</td>";
                        echo "<td>".$row['tillverkat']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> SKEPP -> TILLDELA VAPEN (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['skepp_weapon_connect']) || isset($_POST['skepp_weapon_connect_id']) || isset($_POST['skepp_vapenID'])){
                echo "<table class='tableall'>";
                    echo "<th>Skepp-ID</th>";
                    echo "<th>Vapen-ID</th>";
                    echo "<th>Vapen namn</th>";
                //Tar fram alla rader från tabellerna "Skeppvapen" och "Vapen" där attributet "Vapen-ID" finns med i båda tabellerna, de tilldelas sedan en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM skeppvapen, vapen WHERE vapen.vapenID = skeppvapen.vapenID ORDER BY skeppvapen.skeppID") as $row){
                    echo "<tr>";
                        echo "<td>".$row['skeppID']."</td>";
                        echo "<td>".$row['vapenID']."</td>";
                        echo "<td>".$row['namn']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
            //TABELLER -> INCIDENT -> LÄGG TILL/TA BORT (Isset hanterar här när följande tabell skall visas på webbsidan)
                if(isset($_POST['incident_add']) || isset($_POST['incident_namn']) || isset($_POST['incident_delete']) || isset($_POST['incident_delete_nummer'])){
                echo "<table class='tableall'>";
                    echo "<th>Namn</th>";
                    echo "<th>Nummer</th>";
                    echo "<th>Plats</th>";
                //Tar fram alla rader från tabellen "Incident" som sedan tilldelas en rad och visas i en tabell
                foreach($pdo->query("SELECT * FROM incident") as $row){
                    echo "<tr>";
                        echo "<td>".$row['namn']."</td>";
                        echo "<td>".$row['nummer']."</td>";
                        echo "<td>".$row['plats']."</td>";
                    echo "</tr>";
                }
                    
                echo "</table>";
                }
                
                ?>
            </div>  
        </div>

        <div id="footer">
            <br>
            <img id="alien" src="alien_emoji.png">
        </div>
    </body>
    
</html>