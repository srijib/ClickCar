RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ $1.php [NC,L]

ErrorDocument 404 /./clickcar/404.php

RewriteRule ^profile/([^/]+)$ profile.php?username=$1
