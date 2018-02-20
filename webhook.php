<?php
  /* CONFIGURATIONS */

  // URL of the project you want to update with webhook
  $project_url = "https://github.com/daquinoaldo/git-deploy-on-hosting";

  // PATH in which to deploy (ABSOLUTE!)
  $folder = "/myprojects/git-deploy-on-hosting";

  // PATH of the git-deploy-on-hosting index.php file
  // Must NOT include index.php, start with http (or https) and end with "/"
  $gdoh_path = "https://mydomain.com/deploy/";

  // Username and password of git-deploy-on-hosting
  $username = "iamtheadmin";
  $password = "yesitsme";



  /* STOP! DO NOT EDIT */
  $project_url = urlencode($project_url);
  $folder = urlencode($folder);
  $url = $gdoh_path."index.php?url=".$project_url."&folder=".$folder;

  $curl_handle = curl_init();
  curl_setopt($curl_handle, CURLOPT_URL, $url);
  curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($curl_handle, CURLOPT_USERPWD, $username.":".$password);  
  $html = curl_exec($curl_handle);
  curl_close($curl_handle);

  echo $html;

?>
