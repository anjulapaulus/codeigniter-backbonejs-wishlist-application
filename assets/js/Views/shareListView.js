var app = app || {};

app.views.shareListView = Backbone.View.extend({
	el: ".container-share",

	render: function () {
		template = _.template($('#list-template-share').html());
		this.$el.html(template(this.model.attributes));
		hideElement();
		$(".container-share").show();
		this.collection.each(function (item) {
			var ItemView = new app.views.ItemViewShare({model: item});
			ItemView.render();
		});
	},
	events: {
		"click #btn-copy-link": "copylink",
		"click #go-back": "back",
	},
	back: function (e) {
		e.preventDefault();
		e.stopPropagation();
		app.mainRouter.navigate("#home", {trigger: true, replace: true});
	},
	copylink: function (e) {
		e.preventDefault();
		e.stopPropagation();
		var url = window.location.href;
		$("#show_url").html(url).show();
		console.log($('#show_url').select().html());
		document.execCommand('copy');
	}
});