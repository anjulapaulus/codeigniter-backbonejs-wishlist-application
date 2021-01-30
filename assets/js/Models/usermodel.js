var app = app || {};
app.models.User = Backbone.Model.extend({
    urlRoot: "/Wisher/index.php/api/User/",
    url: "/Wisher/index.php/api/User/",
	defaults: {
        id:"",
        name: "",
        email: "",
        password: "",
        list_name: "",
        list_description: ""
    }
});