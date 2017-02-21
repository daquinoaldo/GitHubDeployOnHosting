<html>
  <head>
    <title>
      GitHub Deploy
    </title>
  </head>
  <body>
  <style>
  body {
    font-family: Arial, sans-serif;
    text-align: center;
  }
  .codebox {
    border: 1px solid black;
    background-color: #dcdcdc;
    font-family: monospace;
    display: inline-block;
  }
  .result {
    padding: 10px;
    border-radius: 5px;
    background: #6de800;
    display: inline-block;
    margin: 25px;
  }
  </style>
  <?php
      // VALUE PARSING
      $url = htmlentities($_GET[url], ENT_QUOTES);
      $folder = htmlentities($_GET[folder], ENT_QUOTES);
      if (empty($url) || empty($folder)) { ?>
        <form method="get">
          GitHub Project url:<br>
          <input type="text" name="url" id="url" placeholder="myPrj" required><br>
          <br>
          Folder:<br>
          <input type="text" name="folder" id="folder" value="<?php echo dirname(getcwd())."/"; ?>" required><br>
          <br>
          <input type="submit" value="Deploy!">
        </form>
        <script>
        var folder = document.getElementById("folder").value;
        function parseurl() {
            var name = document.getElementById("url").value;
            name = name.substring(name.indexOf(".com")+5, (name.length));
            name = name.substring(name.indexOf("/")+1, (name.length));
            document.getElementById("folder").value = folder + name;
            console.log(name);
          }
          document.getElementById("url").addEventListener("keyup", parseurl);
        </script>
      <?php } else {
        $name = substr($url, strpos($url, ".com/"));
        $name = substr($name, strpos($name, "/")+1);
        $name = substr($name, strpos($name, "/")+1);
        //die ($name);        
  
        $ok = 1;
  
        echo "<h2>Deploying ".$name."</h2>";
        echo "<div class=\"codebox\">";
        
        //DOWNLOAD
        echo "Downloading ".$name.".zip... ";
        file_put_contents($name.".zip", fopen($url."/archive/master.zip", 'r'));
        echo "downloaded!<br>";
  
        //EXTRACTION
        echo "Extracting ".$name.".zip... ";
        $zip = new ZipArchive;
        if ($zip->open($name.".zip") === TRUE) {
          $zip->extractTo(".");
          $zip->close();
          echo "extracted!<br>";
        } else {
          echo "failed: can\'t open the file ".$name.".zip<br>";
          $ok = 0;
        }
        if ($ok) {
          //cleaning
          unlink($name.".zip");
    
          //MOVING
          //Configuration
          $source = $name."-master";
          $destination = $folder;
          //Preliminary operations
          echo "Moving files to '".$destination."'... ";
          $files = scandir($source);
          // Create the destination folder
          if(!file_exists($destination)) {
             mkdir ($destination, 0755, true);
          }
          //Cycle through all source files
          foreach ($files as $file) {
            if (in_array($file, array(".",".."))) continue;
            //If we copied this successfully, mark it for deletion
            if (copy($source."/".$file, $destination."/".$file)) {
              $delete[] = $source."/".$file;
            }
          }
          //Delete all successfully-copied files
          foreach ($delete as $file) {
            unlink($file);
          }
          //Clean the folder
          rmdir($source);
          echo "moved!";
        }
          
        echo "</div>";
        echo "<br>";
        echo "<div class=\"result\">&#10004; Success!</div>";
      }
  ?>
  </body>
</html>