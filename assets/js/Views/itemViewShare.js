var app = app || {};

app.views.ItemViewShare = Backbone.View.extend({

	el:"#placing",
	render:function () {
		template = _.template($('#item-template-share').html());
		this.$el.append(template(this.model.attributes));
	}
});