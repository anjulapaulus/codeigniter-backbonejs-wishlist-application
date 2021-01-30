var app = app || {};

app.views.LoginView = Backbone.View.extend({
	el: ".container",
	render: function () {
		template = _.template($('#login-template').html());
		this.$el.html(template);
		hideElement();
		$(".container").show();
	},
	events: {
		'submit .login-form': 'login',
		'change input[type!="submit"]': 'onFocusInput'
	},
	login: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var validationResponse = Form_Login_Validation();
		if (typeof (validationResponse) == "object") {
			this.model.set(validationResponse);
			var urlPost = this.model.url + "login";
			this.model.save(this.model.attributes, {
				"url": urlPost,
				type: 'POST',
				wait:true,
				success: function (data) {
					localStorage.setItem("auth_token", data.attributes.acccess_token);
					localStorage.setItem("user_id", data.attributes.id);
					localStorage.setItem("username", data.attributes.name);
					localStorage.setItem("wish_list_name", data.attributes.wish_list_name);
					localStorage.setItem("wish_list_description", data.attributes.wish_list_description);
					app.mainRouter.navigate("#create", {
						trigger: true,
						replace: true
					});
				},
				error: function (response, xhr,options) {
					console.log(xhr)
					var response = JSON.parse(xhr.responseText)
					$("#errors").html(response.message)
					.show()
					.fadeOut(7000);
				},
			});
		} else {
			$("#errors").html(validationResponse)
				.show()
				.fadeOut(7000);
		}
	},
	onFocusInput: function (e) {
		e.preventDefault();
		e.stopPropagation();
		this.$el.find('#errors')
			.hide().fadeOut();
		;
	}
});
