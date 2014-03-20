<?php
  include_once("config.php");
  global $link;
  $query="SELECT `id`, `teaser`, `text`, `author`, `pubdate` FROM `content`";
  $result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
  while ($content = mysqli_fetch_assoc($result)) {
    print '<h2>' . $content['teaser'] .'</h2>';
    print '<br><h3>' . $content['author'] . '</h3>';
    print '<br>' . date('d.m.Y',$content['pubdate']) . '<br>';
    $id = $content['id'];
    if (strlen($content['text'])>10) {
       print substr($content['text'], 0, 10) . "<a href=\"content.php?id=". $id ."\">...</a><br>";
    }
    else {
      print $content['text'] . '<br>';
    }
    print "<a href=\"content.php?id=". $id ."\">Read more</a><br>";
  }
  
?>