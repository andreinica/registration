<?php

require_once 'config.php';

function search_box(){
      $search_box = '<form name="search_form" method="post" action="search.php" enctype="multipart/form-data" >';
      $search_box .= '<input type="text" name="search_value" id="search_value"/>';
      $search_box .= '<input type="submit" name="search-submit" value="Search" />';
      $search_box .= '</form>';
      return $search_box;
    }

echo "<h1>Search page</h1>";

echo search_box();

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


?>