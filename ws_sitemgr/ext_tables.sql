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
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	developers int(11) DEFAULT '0' NOT NULL,
	productionserver int(11) DEFAULT '0' NOT NULL,
	testserver int(11) DEFAULT '0' NOT NULL,
	devserver int(11) DEFAULT '0' NOT NULL,
	domains int(11) DEFAULT '0' NOT NULL,
	dbdevmethod int(11) DEFAULT '0' NOT NULL,
	hoteldatabases tinytext NOT NULL,
	monitoring int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
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
	name tinytext NOT NULL,
	aliases int(11) DEFAULT '0' NOT NULL,
	monitoring int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_wssitemgr_domainaliases'
#
CREATE TABLE tx_wssitemgr_domainaliases (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	name tinytext NOT NULL,
	monitoring int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);