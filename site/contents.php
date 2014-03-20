<?php
  include_once("config.php");
  include_once('iflogged.php');
  $result = getAllContent();
  //if (!empty($result)) {
  //  while ($content = mysqli_fetch_assoc($result)) {
  //    print '<h2>' . trim(strip_tags($content['teaser'])) .'</h2>';
  //    print '<br><h3>' . trim(strip_tags($content['author'])) . '</h3>';
  //    print '<br>' . date('d.m.Y',$content['pubdate']) . '<br>';
  //    $id = $content['id'];
  //    $text = trim(strip_tags($content['text']));
  //    if (strlen($text)>10) {
  //       print substr($text, 0, 10) . "<a href=\"content.php?id=". $id ."\">...</a><br>";
  //    }
  //    else {
  //      print $text . '<br>';
  //    }
  //    print "<a href=\"content.php?id=". $id ."\">Read more</a><br>";
  //  }
  //}
  //else {
  //  print "There are no records in our database";
  //}
  ?>
