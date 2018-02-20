# GitHub Deploy on web Hosting
Deploy your GitHub project on your web server with one click using PHP (no bash or ssh is required).   
**It works only with public repository.**

## How to use
Just upload the index.php file on your website (NOT in the root, **in a dedicated folder** like www.mywebsite.com/deployGit).  
Visit the page and choose an username and a password: an .htaccess file will be generated.  
Follow the instructions to deploy your project.   

## Webhook support
**You can use thw webhook.php script for the GitHub Webhooks.**   
First follow the "How to use" instructions.   
Then edit the script and change the variables as explained in the comments in the file.   
Upload it wherever you want, but not in the same folder of index.php.   
Visiting this page will be made the automatic deploy of the repository chosen in the chosen path.
