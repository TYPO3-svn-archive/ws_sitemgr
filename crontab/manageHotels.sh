#!/usr/bin/perl

if (-e "/tmp/manageHotelsScript.run") {
 halt;
}
else {
   print `touch /tmp/manageHotelsScript.run`;
   while(1) {
       print `/usr/bin/php -d safe_mode=off /var/www/sitemgr.wildside.dk/typo3conf/ext/ni_hotelmanager/crontab/manageHotels.php`;
       sleep(5);
   }
   print `rm /tmp/makeHotelsScript.run`;
}

