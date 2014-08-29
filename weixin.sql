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
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists oc_message_reply(
	id integer not null auto_increment primary key,
	customerid integer not null,
	userid integer not null,
	content text default null
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists oc_auto_message(
	id integer not null auto_increment primary key,
	pattern varchar(255) not null,
	MsgType varchar(32) not null,
	ItemCount integer default 0,
	Items text default null
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

//配送区域
CREATE TABLE if not exists `oc_district` (
  `id` int(11) NOT NULL auto_increment,
  `city` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(512) NOT NULL,
  `map` varchar(1024) NOT NULL,
  `desp` text default null,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists pos_exchange_data (
	`id` int(11) NOT NULL auto_increment,
	`datatype` int(11) not null,
	`dataval` text,
	`uploadtime` timestamp default now(),
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists pos_exchange_store (
	`id` int(11) NOT NULL auto_increment,
	`storeid` int(11) not null,
	`dataid` int(11) not null,
	`gettime` timestamp default now(),
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

//地址信息微信使用说明
/*oc_address
CREATE TABLE `oc_address` (
  `address_id` int(11) NOT NULL auto_increment,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL, 姓名
  `lastname` varchar(32) NOT NULL,  电话
  `company` varchar(32) NOT NULL,   
  `company_id` varchar(32) NOT NULL,
  `tax_id` varchar(32) NOT NULL,
  `address_1` varchar(128) NOT NULL, 省市区（从微信合并）
  `address_2` varchar(128) NOT NULL, 详细地址
  `city` varchar(128) NOT NULL,     
  `postcode` varchar(10) NOT NULL,  邮编
  `country_id` int(11) NOT NULL default '0', 国家码看情况转换成本系统ID
  `zone_id` int(11) NOT NULL default '0', 
  `district_id` int(11) not null default '0',
  PRIMARY KEY  (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
*/
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
alter table oc_customer add customer_type int(11) default 0; //0 opencart, 1 微信, 2 淘宝
alter table oc_customer add `access_token` varchar(1024) default null;

alter table oc_order modify order_id bigint NOT NULL auto_increment;
alter table oc_order add shipping_time datetime default null;
alter table oc_order add shipping_districtid integer default 0;
alter table oc_order add `shipping_pay` double default 0.0;
alter table oc_order add other_order_id bigint default 0;
alter table oc_order add shipping_telephone varchar(32);
alter table oc_order add transaction_id varchar(256) default "";

alter table oc_order_product add `realweight` double default 0.0;
alter table oc_order_product add `realtotal` double default 0.0;
alter table oc_order_product add `other_product_id` bigint default 0;

alter table oc_product add `other_product_id` bigint default 0;

alter table oc_address add `district_id` int(11) not null default '0';
alter table oc_address add telephone varchar(32);

alter table oc_user add district_id int(11) default 0;

insert into oc_setting (`key`,`value`) values('first_shipping_time', '9');
insert into oc_setting (`key`,`value`) values('last_shipping_time', '19');

//init
insert into oc_setting (`group`, `key`,`value`) values('weixin', 'weixin_token', 'wxc0a931d70de89f4c');
insert into oc_setting (`group`, `key`,`value`) values('weixin', 'weixin_appid', 'wxc0a931d70de89f4c');
insert into oc_setting (`group`, `key`,`value`) values('weixin', 'weixin_appsecret', 'c7153a6b0dba17395e66c7f4d25e35a1');

insert into oc_auto_message(pattern,MsgType,ItemCount,Items) values('order|订|买', 'news', 1, '[{"title":"点击开始买菜","description":"传承老一代，用心卖好菜。青悠悠菜园传统良心蔬菜。","url":"http://qy.gz.1251102575.clb.myqcloud.com/index.php","picurl":"http://qy.gz.1251102575.clb.myqcloud.com//image/data/weixin/logo.jpg"}]');
insert into oc_auto_message(pattern,MsgType,ItemCount,Items) values('testpay', 'news', 1, '[{"title":"点击开始测试","description":"传承老一代，用心卖好菜。青悠悠菜园传统良心蔬菜。","url":"http://qy.gz.1251102575.clb.myqcloud.com/pay/weixin.php","picurl":"http://qy.gz.1251102575.clb.myqcloud.com//image/data/weixin/logo.jpg"}]');

