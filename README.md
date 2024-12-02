
<?php
//print "yest";
$req_host = "www.test.com";
    $req_scheme = "https";
    $req_url = "https://www.test.com";
     $new_host = $req_host;
     $new_scheme = "https";
      $domain_parts = explode('.', $req_host);
      $prefix = reset($domain_parts);
      $has_www = $prefix === 'www';
 if (!$has_www ) {
        $new_host = 'www.' . $req_host;
      }
      
      $new_url = $new_scheme . '://' . $new_host;
      if ($req_url !== $new_url) 
      print $new_url;
      print "test";
