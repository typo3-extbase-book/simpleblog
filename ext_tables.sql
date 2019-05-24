#
# Table structure for table 'tx_simpleblog_domain_model_blog'
#
CREATE TABLE tx_simpleblog_domain_model_blog (

	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	image int(11) unsigned NOT NULL default '0',
	posts int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_post'
#
CREATE TABLE tx_simpleblog_domain_model_post (

	blog int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	content text,
	postdate datetime DEFAULT NULL,
	comments int(11) unsigned DEFAULT '0' NOT NULL,
	author int(11) unsigned DEFAULT '0',
	tags int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_comment'
#
CREATE TABLE tx_simpleblog_domain_model_comment (

	post int(11) unsigned DEFAULT '0' NOT NULL,

	comment varchar(255) DEFAULT '' NOT NULL,
	commentdate datetime DEFAULT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_author'
#
CREATE TABLE tx_simpleblog_domain_model_author (

	fullname varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_tag'
#
CREATE TABLE tx_simpleblog_domain_model_tag (

	tagvalue varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_post'
#
CREATE TABLE tx_simpleblog_domain_model_post (

	blog int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_domain_model_comment'
#
CREATE TABLE tx_simpleblog_domain_model_comment (

	post int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_simpleblog_post_tag_mm'
#
CREATE TABLE tx_simpleblog_post_tag_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
