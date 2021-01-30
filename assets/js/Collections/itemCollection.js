var app = app || {};

app.collections.ItemCollection = Backbone.Collection.extend({
	model: app.models.Item,
	comparator: 'item_priority',
	url: '/Wisher/index.php/api/WishList/items',
});
