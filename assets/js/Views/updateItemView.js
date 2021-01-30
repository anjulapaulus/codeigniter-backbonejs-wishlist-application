var app = app || {};

app.views.updateItemView = Backbone.View.extend({
	el: ".container-update",
	render: function () {
		template = _.template($('#update-item-template').html());
		hideElement();
		$(".container-update").show();
		this.$el.append(template(this.model.attributes));
	},
	events: {
		"click #btnAdd": "update_item",
		"click #btnBack": "back",
	},
	update_item: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var validateForm = Update_Item_Form_Validation();
		if (typeof (validateForm) == "object") {
			this.model.set(validateForm);
			var url = this.model.url + '/id/'+ this.model.get("item_id");;
						this.model.save(this.model.attributes, {
							headers: {'Authorization' :'Bearer ' + localStorage.getItem("auth_token")},
							patch: false,
							type: 'PUT',
							"url": url,
							success: function (model, respose, options) {
								alert("Successfully updated item")
								app.viewHome.collection.sort();
								app.mainRouter.navigate("#home", {
									trigger: true,
									replace: true
								});

							},
							error: function (model, xhr, options) {
								var response = JSON.parse(xhr.responseText)
								$("#errors").html(response.message)
								.show()
								.fadeOut(7000);
							}
						});
					
		} else {
			$("#errors").html(validationResponse)
				.show()
				.fadeOut(7000);
		}
	},
	back: function (e) {
		e.preventDefault();
		e.stopPropagation();
		app.mainRouter.navigate("#home", {trigger: true, replace: true});
	}
});
