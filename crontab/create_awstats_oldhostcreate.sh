#! /bin/bash 
function make_awstats_vhostconf
{
cat <<- _EOF_
  Alias /awstats-icon/ /usr/share/awstats/icon/
  ScriptAlias /awstats/ "/usr/lib/cgi-bin/"
  RewriteEngine On
  RewriteRule ^/stats/?$ /awstats/awstats.pl [R]
  <Files "awstats.pl"> 
    AuthName  "Awstats"
    AuthType Basic 
    Require valid-user

    AuthBasicAuthoritative Off
    AuthMySQLHost localhost
    AuthMySQLUser root
    AuthMySQLPassword sl56qpsql
    AuthMySQLDB $mysqldb 
    AuthMySQLUserTable be_users
    AuthMySQLNameField username 
    AuthMySQLPasswordField password 
    AuthMySQLPwEncryption md5
  </Files> 
_EOF_
}
function make_awstats_conf
{
cat <<- _EOF_
Include "/etc/awstats/awstats.conf"
LogFile="/var/www/$host/access.log"
SiteDomain="$domain"
HostAliases="www.$domain"
DirData="/var/www/$host/htdocs/awstats"
_EOF_
}

cd 
. .ssh-agent
ssh-add

clear  

mysqldb=$4
domain=$3
host=$2
server=$1


#Inserting include line in apache vhost file
ssh -l root $server.wildside.dk sed -i "'s/.*\(<\/VirtualHost>\).*/\n  Include \/var\/www\/awstatsconf\/$host\*\n\n\1/g' /etc/apache2/sites-available/$host"

#Creating Apache awstats conf
make_awstats_vhostconf > /tmp/$host
scp /tmp/$host root@$server.wildside.dk:/var/www/awstatsconf/

#Creating awstats conf awstats.$domain.conf
make_awstats_conf > /tmp/awstats.$domain.conf
scp /tmp/awstats.$domain.conf root@$server.wildside.dk:/etc/awstats/

#Creating awstats data folder
ssh -l root $server.wildside.dk mkdir /var/www/$host/htdocs/awstats

#Restarting apache on server
ssh -l root $server.wildside.dk apache2ctl graceful

#Running stats
ssh -l root $server.wildside.dk perl /usr/lib/cgi-bin/awstats.pl -config=$domain -update


exit
