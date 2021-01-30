var app = app || {};

app.views.HomeView = Backbone.View.extend({
	el: ".container-main",

	render: function (empty) {
		template = _.template($('#list-template').html());
		this.$el.html(template(app.user.attributes));
		hideElement();
		$(".container-main").show();
		if (empty) {
			$("#no-items").show();
		} else {
			$("#no-items").hide();
		}
		this.collection.each(function (item) {
			var itemView = new app.views.ItemView({
				model: item
			});
			itemView.render();
		});
	},
	events: {
		"click #btn-add": "add_item",
		"click #btn-share": "share_list",
		"click #btn-logout": "logout",
		"click #btn-update-item": "update_item",
		"click #btn-delete-item": "delete_item",
		"click #btn-view": "view_list_link",
	},
	add_item: function (e) {
		e.preventDefault();
		e.stopPropagation();
		app.mainRouter.navigate("#home/add", {
			trigger: true,
			replace: true
		});
	},
	update_item: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(e.currentTarget).val();
		app.mainRouter.navigate("#home/update/" + id, {
			trigger: true,
			replace: true
		});
	},
	delete_item: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var collection = app.viewHome.collection;
		var existing_arr = collection.models;
		var id = $(e.currentTarget).val();
		var newVal = existing_arr.find(function (el) {
			if(el.attributes.item_id == id){
				return el.attributes.item_id == id;
			}
		});

		var url = newVal.url + "/"+ id;
		newVal.destroy({
			headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
			url: url,
			type: 'DELETE',
			success : _.bind(function(model, response, options) {
				app.viewHome.collection.remove(newVal);
				app.viewHome.render();
				alert("Successfully deleted Item id "+id)
			}, this),
  			error : _.bind(function(model, xhr, options) {
				alert("Couldn't delete Item id "+id)
			}, this),
		})
	},
	share_list: function (e) {
		e.preventDefault();
		e.stopPropagation();
		id = localStorage.getItem("user_id")
		alert('http://localhost/Wisher/#share/'+id);
	},
	logout: function () {
		localStorage.removeItem("auth_token");
		localStorage.removeItem("user_id");
		localStorage.removeItem("username");
		localStorage.removeItem("wish_list_name");
		localStorage.removeItem("wish_list_description");
	}
});