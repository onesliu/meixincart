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

create table if not exists oc_auto_message(
	id integer not null auto_increment primary key,
	pattern varchar(255) not null,
	MsgType varchar(32) not null,
	ItemCount integer default 0,
	Items text default null
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

//init
insert into oc_setting (`key`,`value`) values('weixin_token', 'wxc0a931d70de89f4c');
insert into oc_setting (`key`,`value`) values('weixin_appid', 'wxc0a931d70de89f4c');
insert into oc_setting (`key`,`value`) values('weixin_appsecret', 'c7153a6b0dba17395e66c7f4d25e35a1');

insert into oc_auto_message(pattern,MsgType,ItemCount,Items) values('order|订|买', 'news', 1, '[{"title":"点击开始买菜","description":"传承老一代，用心卖好菜。青悠悠菜园传统良心蔬菜。","url":"http://oc.ngrok.com/opencart/index.php","picurl":"http://oc.ngrok.com/opencart/image/data/weixin/logo.jpg"}]');

