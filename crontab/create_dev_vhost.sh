#! /bin/bash 
function make_developer_vhost
{
cat <<- _EOF_
<VirtualHost *>
  ServerAdmin hosting@wildside.dk
  ServerName ${host/./}.$developer.dev.wildside.dk
  
  DirectoryIndex index.html index.htm index.php
  DocumentRoot /var/www/dev/developers/$developer/$host/htdocs/

  <Directory /var/www/dev/developers/$developer/$host/htdocs/>
    Options FollowSymLinks MultiViews
    AllowOverride All
    Order allow,deny
    Allow from all
  </Directory>
		
  ErrorLog /var/www/dev/developers/$developer/$host/error.log
  CustomLog /var/www/dev/developers/$developer/$host/access.log combined
  
  Include /var/www/dev/developers/$developer/customconf/$host*
  
</VirtualHost>
_EOF_
}



clear  

host=$2
developer=$1

#make_vhost > /etc/apache2/sites-available/$host

#Make development version of website

make_developer_vhost > /etc/apache2/sites-available/$developer\_$host
a2ensite $developer\_$host

#/usr/sbin/apache2ctl graceful


exit
