#! /bin/bash 
function make_awstats_vhostconf
{
cat <<- _EOF_
  Alias /awstats-icon/ /usr/share/awstats/icon/
  ScriptAlias /awstats/ "/usr/lib/cgi-bin/"
  RewriteEngine On
  RewriteRule ^/stats/?$ http://$host/awstats/awstats.pl [R]
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
LogFile="/var/www/$server/typo3/hoteller/$host/access.log"
SiteDomain="$host"
HostAliases="$alias"
DirData="/var/www/starscream/typo3/hoteller/$host/awstats"
_EOF_
}



cd 
. .ssh-agent
ssh-add

clear  

mysqldb=$3
host=$2
server=$1

shift
shift
shift

while [ $# -gt 0 ] ; do 
    alias=$alias" "$1
shift
done

#Creating Apache awstats conf
make_awstats_vhostconf > /tmp/$host
scp /tmp/$host root@$server.wildside.dk:/var/www/awstatsconf/

#Creating awstats conf awstats.$host.conf
make_awstats_conf > /tmp/awstats.$host.conf
scp /tmp/awstats.$host.conf root@$server.wildside.dk:/etc/awstats/

#Creating awstats data folder
ssh -l root $server.wildside.dk mkdir /var/www/starscream/typo3/hoteller/$host/awstats

#Restarting apache on server
ssh -l root $server.wildside.dk apache2ctl graceful


exit
