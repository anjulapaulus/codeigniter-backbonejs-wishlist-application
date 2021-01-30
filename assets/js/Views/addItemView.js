var app = app || {};

app.views.addItemView = Backbone.View.extend({
	el: ".container-add",
	render: function () {
		hideElement();
		$(".container-add").show();
		template = _.template($('#add-item-template').html());
		this.$el.append(template(this.model.attributes));
	},
	events: {
		"click #btnAdd": "add_item",
		"click #btnBack": "go_back",
	},
	add_item: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var validateForm = Add_Item_From_Validation();
		if (typeof (validateForm) == "object") {
			this.model.clear();
			this.model.set(validateForm);
			var url = this.model.url;
			this.model.save(this.model.attributes, {
                headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
				"url": url,
				type: 'POST',
                wait: true,
                success: function (data) {
					alert("Successfully added item")
					app.mainRouter.navigate("#home", {
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
	go_back: function (e) {
		e.preventDefault();
		e.stopPropagation();
		app.mainRouter.navigate("#home", {trigger: true, replace: true});
	}
});
