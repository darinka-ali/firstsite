<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
  include('config.php');
  global $link;
  $tableName="content";
  $targetpage = "contents.php";
  $limit = 10;
  $query = "SELECT COUNT(*) as num FROM $tableName";
  $total_pages = mysqli_fetch_array(mysqli_query($link, $query));
  $total_pages = $total_pages['num'];
  $stages = 3;
  if (!empty($_GET['page'])) {
    $page = mysqli_real_escape_string($link, $_GET['page']);
  }
  else $page = 0;
  if($page>0){
    $start = ($page - 1) * $limit;
  }
  else {
    $start = 0;
  }  
  $query1 = "SELECT * FROM $tableName LIMIT $start, $limit";
  $result = mysqli_query($link, $query1);
  if ($page == 0){$page = 1;}
  $prev = $page - 1;
  $next = $page + 1;
  $lastpage = ceil($total_pages/$limit);
  $LastPagem1 = $lastpage - 1;                   
  $paginate = '';
  if($lastpage > 1)   {  
    $paginate .= "<div class='paginate'>";
    if ($page > 1){
      $paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
    }
    else{
      $paginate.= "<span class='disabled'>previous</span>";
    }
    if ($lastpage < 7 + ($stages * 2)) {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page){
          $paginate.= "<span class='current'>$counter</span>";
        }
        else {
          $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
        }
      }
    }
    elseif($lastpage > 5 + ($stages * 2)) {
      if($page < 1 + ($stages * 2)) {
        for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
          if ($counter == $page){
            $paginate.= "<span class='current'>$counter</span>";
          }
          else {
            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
          }
        }
        $paginate.= "...";
        $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
        $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
      }
      elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
        $paginate.= "<a href='$targetpage?page=1'>1</a>";
        $paginate.= "<a href='$targetpage?page=2'>2</a>";
        $paginate.= "...";
        for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
          if ($counter == $page) {
            $paginate.= "<span class='current'>$counter</span>";
          }
          else{
            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
          }
        }
        $paginate.= "...";
        $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
        $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
      }
      else {
        $paginate.= "<a href='$targetpage?page=1'>1</a>";
        $paginate.= "<a href='$targetpage?page=2'>2</a>";
        $paginate.= "...";
        for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page) {
            $paginate.= "<span class='current'>$counter</span>";
          }
          else{
            $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
          }
        }
      }
    }
    if ($page < $counter - 1){
      $paginate.= "<a href='$targetpage?page=$next'>next</a>";
    }
    else {
      $paginate.= "<span class='disabled'>next</span>";
    }
    $paginate.= "</div>";      
  }
  echo $paginate;
?>
<ul>
<?php
  while($row = mysqli_fetch_array($result)) {
    echo '<li>'.$row['teaser'] . '<br>';
    echo $row['author'] . '<br>';
    echo date('d.m.Y', $row['pubdate'])  . '<br>';
    $id = $row['id'];
    $text = trim(strip_tags($row['text']));
    if (strlen($text)>10) {
      echo substr($text, 0, 10) . "<a href=\"content.php?id=". $id ."\">...</a><br>";
    }
    else {
      echo $text . '<br>';
    }
    echo "<a href=\"content.php?id=". $id ."\">Read more</a><br>";
  }
?>
</ul>