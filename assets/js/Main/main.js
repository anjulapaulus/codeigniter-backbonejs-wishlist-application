var app = app || {};
app.views = {};
app.models = {};
app.routers = {};
app.collections = {};

function Form_Login_Validation() {
	var user = {
		'email': $("#email").val(),
		'password': $("#password").val()
	};
	var message = "";
	if (!user.email) {
		message = "Please enter a email";
		return message;
	} else if (!user.password) {
		message = "Please enter a password";
		return message;
	} else {
		return user;
	}
}

function Register_Form_Validation() {
	var user = {
		'name': $("#name").val(),
		'password': $("#password").val(),
		'confPassword': $("#confPassword").val(),
		'email': $("#email").val()
	};
	var message = "";
	if (!user.name) {
		message = "Please enter a name";
		return message;
	} else if (!user.password) {
		message = "Please enter a password";
		return message;
	} else if (!user.confPassword) {
		message = "Please confirm password";
		return message;
	}else if (!user.email) {
		message = "Please enter an email";
		return message;
	} else if(user.confPassword != user.password){
		message = "Passwords do not match!";
		return message;
	} else {
        return user;
    }
}

function Create_List_Form_Validation() {
	var wishList = {
		'list_name': $("#listName").val(),
		'list_description': $("#listDesc").val(),
	};
	var message = "";
	if (!wishList.list_name) {
		message = "Please enter a Wish List name";
		return message;
	} else if (!wishList.list_description) {
		message = "Please enter a Wish List description";
		return message;
	} else {
        return wishList;
    }
}


function Add_Item_From_Validation() {
	var item = {
		'item_name': $("#itemName").val(),
		'item_url': $("#url").val(),
		'item_price': $("#itemPrice").val(),
		'item_quantity': $("#itemQuantity").val(),
		'item_priority': $("#itemPriority").val(),
	};
	var message = "";
	if (!item.item_name) {
		message = "Please enter a item name";
		return message;
	} else if (!item.item_url) {
		message = "Please enter a url for item";
		return message;
	} else if (!item.item_price) {
		message = "Please enter a price for the item";
		return message;
	}else if (!item.item_priority) {
		message = "Please select priority";
		return message;
	}else {
		return item;
	}
}

function Update_Item_Form_Validation() {
	var item = {
		'item_name': $("#itemName").val(),
		'item_url': $("#url").val(),
		'item_price': $("#itemPrice").val(),
		'item_quantity': $("#itemQuantity").val(),
		'item_priority': $("#itemPriority").val(),
	};
	var message = "";
	if (!item.item_name) {
		message = "Please enter a item name";
		return message;
	} else if (!item.item_url) {
		message = "Please enter a url for item";
		return message;
	} else if (!item.item_price) {
		message = "Please enter a price for the item";
		return message;
	}else if (!item.item_priority) {
		message = "Please select priority";
		return message;
	}else {
		return item;
	}
}

$(document).ready(function () {
	app.mainRouter = new app.routers.MainRouter();
	$(function () {
		Backbone.history.start();
    });
});