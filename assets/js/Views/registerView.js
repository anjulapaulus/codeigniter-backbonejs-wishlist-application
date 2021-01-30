var app = app || {};

app.views.RegisterView = Backbone.View.extend({
	el: ".container",
	render: function () {
		template = _.template($('#register-template').html());
		this.$el.html(template);
		hideElement();
		$(".container").show();
	},
	events: {
		'submit .register-form': 'register',
		'change input[type!="submit"]': 'onFocusInput'
	},
	register: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var validationResponse = Register_Form_Validation();
		if (typeof (validationResponse) == "object") {
			this.model.set(validationResponse);
			var urlPost = this.model.url + "register";
			this.model.save(this.model.attributes, {
				"url": urlPost,
				type: 'POST',
				wait:true,
				success: function (data) {
					alert("Registered Successfully")
					app.mainRouter.navigate("#", {
						trigger: true,
						replace: true
					});
				},
				error: function (response, xhr,options) {
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
