var app = app || {};
app.models.WishList = Backbone.Model.extend({
    urlRoot: "/Wisher/index.php/api/WishList/",
    url: "/Wisher/index.php/api/WishList/",
	defaults: {
        list_name: "",
        list_description: ""
    }
});