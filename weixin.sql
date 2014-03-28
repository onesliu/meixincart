create table oc_message(
	id integer not null auto_increment primary key,
	customerid integer not null,
	ToUserName varchar(255) default null,
	