create table if not exists oc_message(
	id integer not null auto_increment primary key,
	customerid integer not null,
	ToUserName varchar(255) not null,
	FromUserName varchar(255) not null,
	CreateTime integer not null,
	MsgType varchar(32) not null,
	Content varchar(255) default null,
	MsgId bigint not null unique,
	PicUrl varchar(1024) default null,
	MediaId varchar(255) default null,
	Format varchar(64) default null,
	ThumbMediaId varchar(64) default null,
	Location_X double default 0.0,
	Location_Y double default 0.0,
	Scale int default 0,
	Label varchar(512) default null,
	Title varchar(255) default null,
	Description varchar(512) default null,
	Url varchar(1024) default null,
	Others text default null
)ENGINE=MyISAM;

create table if not exists oc_message_reply(
	id integer not null auto_increment primary key,
	customerid integer not null,
	userid integer not null,
	content text default null
)ENGINE=MyISAM;

create table if not exists oc_event(
	id integer not null auto_increment primary key,
	customerid integer not null,
	ToUserName varchar(255) not null,
	FromUserName varchar(255) not null,
	CreateTime integer not null,
	MsgType varchar(32) not null,
	Event varchar(32) not null,
	EventKey varchar(1024) default null,
	Ticket varchar(255) default null,
	Latitude double default 0.0,
	Longitude double default 0.0,
	`Precision` double default 0.0,
	Others text default null
)ENGINE=MyISAM;

alter table oc_customer add `subscribe` integer default 0;
alter table oc_customer add `openid` varchar(255) default null;
alter table oc_customer add `nickname` varchar(255) default null;
alter table oc_customer add `sex` integer default 0;
alter table oc_customer add `city` varchar(64) default null;
alter table oc_customer add `country` varchar(255) default null;
alter table oc_customer add `province` varchar(64) default null;
alter table oc_customer add `language` varchar(64) default null;
alter table oc_customer add `headimgurl` varchar(1024) default null;
alter table oc_customer add `subscribe_time` integer default 0;

create table if not exists oc_(
	id integer not null auto_increment primary key,
	storeid integer default 0,
	
)ENGINE=MyISAM;