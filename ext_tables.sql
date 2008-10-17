#
# Table structure for table 'tx_wssitemgr_hotels_developers_mm'
# 
#
CREATE TABLE tx_wssitemgr_hotels_developers_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);




#
# Table structure for table 'tx_wssitemgr_hotels_devdatabases_mm'
# 
#
CREATE TABLE tx_wssitemgr_hotels_devdatabases_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);




#
# Table structure for table 'tx_wssitemgr_hotels_domains_mm'
# 
#
CREATE TABLE tx_wssitemgr_hotels_domains_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_wssitemgr_hotels'
#
CREATE TABLE tx_wssitemgr_hotels (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	creationdate int(11) DEFAULT '0' NOT NULL,
	developers int(11) DEFAULT '0' NOT NULL,
	devdatabases int(11) DEFAULT '0' NOT NULL,
	server int(11) DEFAULT '0' NOT NULL,
	domains int(11) DEFAULT '0' NOT NULL,
	status tinytext NOT NULL,
	reseterrorstatus tinyint(3) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_wssitemgr_databases'
#
CREATE TABLE tx_wssitemgr_databases (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	dbname tinytext NOT NULL,
	dbuser tinytext NOT NULL,
	dbpass tinytext NOT NULL,
	developer blob NOT NULL,
	isdefault tinyint(3) DEFAULT '0' NOT NULL,
	isempty tinytext NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_wssitemgr_servers'
#
CREATE TABLE tx_wssitemgr_servers (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	host tinytext NOT NULL,
	dbuser varchar(255) DEFAULT '' NOT NULL,
	dbpass varchar(255) DEFAULT '' NOT NULL,
	dirhotels varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_wssitemgr_domainsaliases'
#
CREATE TABLE tx_wssitemgr_domainsaliases (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_wssitemgr_domains_aliases_mm'
# 
#
CREATE TABLE tx_wssitemgr_domains_aliases_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_wssitemgr_domains'
#
CREATE TABLE tx_wssitemgr_domains (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	aliases int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_wssitemgr_queue'
#
CREATE TABLE tx_wssitemgr_queue (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	callclass tinytext NOT NULL,
	parms tinytext NOT NULL,
	depend tinytext NOT NULL,
	server tinytext NOT NULL,
	status tinytext NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);