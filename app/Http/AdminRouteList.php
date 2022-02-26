<?php
/*
* To implement in admingroups permissions
* to remove CRUD from Validation remove route name
* CRUD Role permission (create,read,update,delete)
* [it v 1.6.37]
*/
return [
    "log"=>["update"],
    "admins"=>["create","read","update","delete","log"],
    "admingroups"=>["create","read","update","delete"],
	"subitems"=>["create","read","update","delete"],
	"notebooks"=>["create","read","update","delete"],
	"parentsubitems"=>["create","read","update","delete"],
	"basicparentitems"=>["create","read","update","delete"],
	"basicparents"=>["create","read","update","delete"],
	"withdrawals"=>["create","read","update","delete"],
	"payments"=>["create","read","update","delete"],
	"generalrevenue"=>["create","read","update","delete"],
	"payment"=>["create","read","delete"],
	"employee"=>["create","read","update","delete"],
	"salary"=>["create","read","update","delete"],
	"filling"=>["create","read","delete"],
	"collection"=>["create","read","update","delete"],
	"otheroperation"=>["create","read","update","delete"],
	"expenses"=>["create","read","update","delete"],
	"debt"=>["create","read","update","delete"],
	"revenue"=>["create","read","update","delete"],
	"employeetype"=>["create","read","update","delete"],
	"supplier"=>["create","read","update","delete"],
	"stock"=>["create","read","update","delete"],
	"city"=>["create","read","update","delete"],

];
