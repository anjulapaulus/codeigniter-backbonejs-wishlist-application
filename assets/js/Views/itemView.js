var app = app || {};

app.views.ItemView = Backbone.View.extend({

	el:"#item_position",
	render:function () {
		template = _.template($('#item-template').html());
		this.$el.append(template(this.model.attributes));
	}
});