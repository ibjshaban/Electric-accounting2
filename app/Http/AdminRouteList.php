<?php
/*
* To implement in admingroups permissions
* to remove CRUD from Validation remove route name
* CRUD Role permission (create,read,update,delete)
* [it v 1.6.36]
*/
return [
	"employee"=>["create","read","update","delete"],
	"employeetype"=>["create","read","update","delete"],
	"supplier"=>["create","read","update","delete"],
	"stock"=>["create","read","update","delete"],
	"city"=>["create","read","update","delete"],
	"admins"=>["create","read","update","delete"],
	"admingroups"=>["create","read","update","delete"],
];