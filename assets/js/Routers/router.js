var app = app || {};

app.routers.MainRouter = Backbone.Router.extend({
	routes: {
        "": "login",
        "register":"register",
		"create": "createList",
		"home": "viewHome",
		"home/add": "addList",
		"home/update/:id": "updateList",
		"home/delete/:id": "deleteList",
		"share/:id": "sharedLink",
		"share": "shareList",
	},
	login: function (e) {
		token = localStorage.getItem("auth_token")
		userId = localStorage.getItem("user_id")
		username = localStorage.getItem("username")
		listName = localStorage.getItem("wish_list_name")
        listDesc = localStorage.getItem("wish_list_description")
		if (token == null) {
			app.user = new app.models.User();
			app.loginDisplay = new app.views.LoginView({
				model: app.user
			});
			app.loginDisplay.render();
		} else {
			app.user = new app.models.User({'name':username,'list_name':listName, 'list_description':listDesc,'id':userId})
			this.createList();
		}
    },
    register: function (e) {
			app.user = new app.models.User();
			app.registerDisplay = new app.views.RegisterView({
				model: app.user
			});
			app.registerDisplay.render();
	},
	viewHome: function () {
		token = localStorage.getItem("auth_token")
		userId = localStorage.getItem("user_id")
         username = localStorage.getItem("username")
         listName = localStorage.getItem("wish_list_name")
         listDescription = localStorage.getItem("wish_list_description")
        
		if (token != null) {
            app.user = new app.models.User({'name':username,'list_name':listName, 'list_description':listDescription,'id':userId})
			app.viewHome = new app.views.HomeView({collection: new app.collections.ItemCollection()});
			var url = app.viewHome.collection.url;
			app.viewHome.collection.fetch({
				headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
				reset: true,
				"url": url,
				wait: true,
				success: function (collection, response) {
						app.viewHome.collection.sort();
						app.viewHome.render(false);
				},
				error: function (collection, xhr, options) {
					if (xhr.status == 404) {
						app.viewHome.render(true);
					}
				}
			});
		} else {
			this.login();
		}

	},
	createList: function (e) {
		userId = localStorage.getItem("user_id")
        username = localStorage.getItem("username")
		listName = localStorage.getItem("wish_list_name")
        listDesc = localStorage.getItem("wish_list_description")
		if (listName == "" && listDesc == "") {
            app.wishList = new app.models.WishList();
                app.createListDisplay = new app.views.CreateListView({
                    model: app.wishList
                });
            app.createListDisplay.render();
        }else{
            app.user = new app.models.User({'name':username,'list_name':listName, 'list_description':listDesc, 'id':userId});
            this.viewHome();
        }
	},

	addList: function (e) {
		if (!app.addItemView) {
			app.addItemView = new app.views.addItemView({
				model: new app.models.Item()
			});
			cleanHTML();
			app.addItemView.render();


		} else if (app.addItemView) {
			cleanHTML();
			app.addItemView.render();
		}
	},
	updateList: function (e) {
		if (!app.updateItemView) {
			var collection = app.viewHome.collection;
			var existing_collection = collection.models;
			var newVal = existing_collection.find(function (el) {
				return el.attributes.item_id == e;
			});
			app.updateItemView = new app.views.updateItemView({
				model: newVal
			});
			cleanHTML();
			app.updateItemView.render();
		} else if (app.updateItemView) {
			cleanHTML();
			app.updateItemView.render();
		}
	},
	sharedLink: function (id) {
		token = localStorage.getItem("auth_token")
		userId = localStorage.getItem("user_id")
        username = localStorage.getItem("username")
		listName = localStorage.getItem("wish_list_name")
        listDesc = localStorage.getItem("wish_list_description")
		var getUserUrl = "/Wisher/index.php/api/User/" + id;
		if (token != null ) {
			app.user = new app.models.User({'name':username,'list_name':listName, 'list_description':listDesc,'id':userId}),

			app.shareListView = new app.views.shareListView({
				collection: new app.collections.ItemCollection(), 
				model: new app.models.User()
			});
			app.shareListView.model.fetch({
				reset: true,
				"url": getUserUrl,
				wait: true,
				success: function (data) {
					
				},
				error: function (response, xhr,options) {
					var response = JSON.parse(xhr.responseText)
					alert("Cannot Share link due to "+response.responseText)
				},
			});

			var url = app.shareListView.collection.url;
			app.shareListView.collection.fetch({
				reset: true,
				"url": url,
				headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
				wait: true,
				success: function (data) {
					app.shareListView.render();
				},
				error: function (response, xhr,options) {
					var response = JSON.parse(xhr.responseText)
					alert("Cannot Share link due to "+response.responseText)
				},
			});
		} else {
			this.login();
		}
	}
});

function cleanHTML() {
	$(".container-add").html("");
	$(".container-update").html("");
	$(".container").html("");
	$(".container-main").html("");
	$(".container-share").html("");
	$(".container-create-list").html("");
}

function hideElement() {
	$(".container").hide();
	$(".container-create-list").hide();
	$(".container-add").hide();
	$(".container-share").hide();
	$(".container-update").hide();
	$(".container-main").hide();
}
