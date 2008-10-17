#! /bin/bash 
function make_vhost_dev
{
cat <<- _EOF_
<VirtualHost *>
  ServerAdmin hosting@wildside.dk
  ServerName $servername
  ServerAlias$alias
  ServerAlias ${host/./}.dev.wildside.dk

  DirectoryIndex index.html index.htm index.php
  DocumentRoot /var/www/$server/typo3/hoteller/$host/htdocs/

  <Directory /var/www/$server/typo3/hoteller/$host/htdocs/>
    Options FollowSymLinks MultiViews
    AllowOverride All
    Order allow,deny
    Allow from all
  </Directory>
		
  ErrorLog /var/www/$server/typo3/hoteller/$host/error.log
  CustomLog /var/www/$server/typo3/hoteller/$host/access.log combined
</VirtualHost>
_EOF_
}

function make_vhost_prod
{
cat <<- _EOF_
<VirtualHost *>
  ServerAdmin hosting@wildside.dk
  ServerName $servername
  ServerAlias$alias
  ServerAlias ${host/./}.$server.wildside.dk

  DirectoryIndex index.html index.htm index.php
  DocumentRoot /var/www/$server/typo3/hoteller/$host/htdocs/

  <Directory /var/www/$server/typo3/hoteller/$host/htdocs/>
    Options FollowSymLinks MultiViews
    AllowOverride All
    Order allow,deny
    Allow from all
  </Directory>

  ErrorLog /var/www/$server/typo3/hoteller/$host/error.log
  CustomLog /var/www/$server/typo3/hoteller/$host/access.log combined
	
  Include /var/www/awstatsconf/$host*
  Include /var/www/customconf/$host*
	
	
</VirtualHost>
_EOF_
}

cd 
. .ssh-agent
ssh-add

clear  
servername=$3
host=$2
server=$1

shift
shift
shift

while [ $# -gt 0 ] ; do 
    alias=$alias" "$1
shift
done

#make_vhost > /etc/apache2/sites-available/$host

#Make development version of website
make_vhost_dev > /etc/apache2/sites-available/$host
a2ensite $host
/usr/sbin/apache2ctl graceful

#Create production environment for website
make_vhost_prod > /tmp/$host
scp /tmp/$host root@$server.wildside.dk:/etc/apache2/sites-available/
ssh -l root $server.wildside.dk a2ensite $host
ssh -l root $server.wildside.dk apache2ctl graceful

#echo "Reloading apache configuration"
#/usr/sbin/apache2ctl graceful

exit
