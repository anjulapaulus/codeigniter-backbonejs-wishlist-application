var app = app || {};

app.views.CreateListView = Backbone.View.extend({
	el: ".container",
	render: function () {
		template = _.template($('#create-list-template').html());
		this.$el.html(template);
		hideElement();
		$(".container").show();
	},
	events: {
		'submit .create-list-form': 'createList',
		'change input[type!="submit"]': 'onFocusInput'
	},
	createList: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var validationResponse = Create_List_Form_Validation();
		if (typeof (validationResponse) == "object") {
			this.model.set(validationResponse);
			var urlPost = this.model.url+'wishList';
			this.model.save(this.model.attributes, {
                headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
				"url": urlPost,
				type: 'POST',
				wait:true,
				success: function (data) {
					alert("Successfully created a list")
                    localStorage.setItem("wish_list_name", data.attributes.list_name);
                    localStorage.setItem("wish_list_description", data.attributes.list_description);
                    app.mainRouter.navigate("#home", {
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
