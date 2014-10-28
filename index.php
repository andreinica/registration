<html>
<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Register here!</h1>
    <p>Fill in your name, email address and company name, then click <strong>Submit</strong> to register.</p>
<form name="register_form" method="post" action="index.php" enctype="multipart/form-data" >
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Company name <input type="text" name="company_name" id="company_name"/></br>
      <input type="submit" name="details-submit" value="Submit" />
</form>
<?php

    // Connect to database.
    
    require_once 'config.php';
    
    // Insert registration info

    function search_box(){
      $search_box = '<form name="search_form" method="post" action="index.php" enctype="multipart/form-data" >';
      $search_box .= '<input type="text" name="search_value" id="search_value"/>';
      $search_box .= '<input type="submit" name="search-submit" value="Search" />';
      $search_box .= '</form>';
      return $search_box;
    }


    if(!empty($_POST['name'])) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
	$company_name = $_POST['company_name'];
        $date = date("Y-m-d");
        // Insert data
        $sql_insert = "INSERT INTO registration_tbl (name, email, company_name, date) 
                   VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_insert);
	
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
	$stmt->bindValue(3, $company_name);
        $stmt->bindValue(4, $date);
        $stmt->execute();
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    echo "<h3>Your're registered!</h3>";
    }
    // Retrieve data
    $sql_select = "SELECT * FROM registration_tbl";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
    echo "<br><br>";
    if(count($registrants) > 0) {
	if(count($registrants) > 1){
	  echo search_box();
	  echo "<a href='search.php'>Search in new page</a>";
	}
	if (!empty($_POST['search_value'])){
	  $search_value = $_POST['search_value'];
	  $sql_search = "SELECT * FROM registration_tbl WHERE name LIKE '%" . $search_value . "%' OR email LIKE '%" . $search_value . "%' OR company_name LIKE '%" . $search_value . "%'";
	  $stmt = $conn->query($sql_search);
	  $search_result = $stmt->fetchAll();
	  if (count($search_result) > 0 && strlen($search_value) > 1){
	    echo "<h2>Search results:</h2>";
	    echo "<table>";
	    echo "<tr><th>Name</th>";
	    echo "<th>Email</th>";
	    echo "<th>Company name</th>";
	    echo "<th>Date</th></tr>";
	    foreach($search_result as $result) {
	      echo "<tr><td>".$result['name']."</td>";
	      echo "<td>".$result['email']."</td>";
	      echo "<td>".$result['company_name']."</td>";
	      echo "<td>".$result['date']."</td></tr>";
	    }
	    echo "</table>";
	    echo "<br>";
	  }
	  else{
	    echo "<p>No results!</p>";
	  }

	}
	echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
	echo "<th>Company name</th>";
        echo "<th>Date</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
	    echo "<td>".$registrant['company_name']."</td>";
            echo "<td>".$registrant['date']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No one is currently registered.</h3>";
    }
?>
</body>
</html>