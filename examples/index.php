<?php
   require_once('../app/classes/error.php');
   require_once('../app/classes/str.php');
   require_once('../app/classes/validator.php');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
   <title>Example page</title>
   <meta name="description" content="AlvinTran" />
   <meta name="keyword" content="AlvinTran"/>
   <meta name="viewport" content="width=device-width" />
</head>
<body>
   <h1>String class</h1>
   <?php
      $myurl = "http://mytour.vn/3059-khach-san-time-door.html";
      echo "URL: " . $myurl . "<br />";
      // Str::contains
      echo "<h3>Str::contains</h3>";
      echo "URL has contains [time-door]? ";
      if (Str::contains($myurl, 'time-door')) {
         echo "YES <br />";
      } else {
         echo "NO <br />";
      }

      // Str::startsWith
      echo "<h3>Str::startsWith </h3>";
      echo "URL has starts with [http]? ";
      if (Str::contains($myurl, 'http')) {
         echo "YES <br />";
      } else {
         echo "NO <br />";
      }

      // Str::endsWith
      echo "<h3>Str::endsWith </h3>";
      echo "URL has ends with [html]? ";
      if (Str::contains($myurl, 'html')) {
         echo "YES <br />";
      } else {
         echo "NO <br />";
      }

      // Str::cut_string
      $mystr = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus, reprehenderit, eveniet labore nulla modi quia ea eaque sapiente doloribus aliquid error blanditiis ipsum eligendi voluptate eum id rem natus porro?";
      echo "<h3>Str::cut_string </h3>";
      echo "Before use cut_string: <br />" . $mystr;
      echo "<br />Length: " . Str::length($mystr) . "<br />";
      echo "After use cut_string with param = 16: <br />" . Str::cut_string($mystr, 16) . "<br />";
      echo "Length: " . Str::length(Str::cut_string($mystr, 16)) . "<br />";

      // Str::limits
      echo "<h3>Str::limits </h3>";
      echo "Before use cut_string: <br />" . $mystr;
      echo "<br />Length: " . Str::length($mystr) . "<br />";
      echo "After use cut_string with param = 16: <br />" . Str::limits($mystr, 16) . "<br />";
      echo "Length: " . Str::length(Str::limits($mystr, 16)) . "<br />";

      // Str::words
      echo "<h3>Str::words </h3>";
      echo "Before use cut_string: <br />" . $mystr;
      echo "<br />Words: " . count(explode(' ', $mystr)) . "<br />";
      echo "After use cut_string with param = 16: <br />" . Str::words($mystr, 16) . "<br />";
      echo "Words: " .count(explode(' ', Str::words($mystr, 16))) . "<br />";

      // Str::random
      echo "<h3>Str::random </h3>";
      echo "Random string with 20 characters: " . Str::random(20);

      // Str::lower
      echo "<h3>Str::lower </h3>";
      echo "Lower above string: <br />" . Str::lower($mystr);

      // Str::upper
      echo "<h3>Str::upper </h3>";
      echo "Upper above string: <br />" . Str::upper($mystr);

      // Str::slug
      echo "<h3>Str::slug </h3>";
      echo "Slug above string: <br />" . Str::slug($mystr);

   ?>
</body>
</html>