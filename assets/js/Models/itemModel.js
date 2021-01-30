var app = app || {};

app.models.Item = Backbone.Model.extend({
	urlRoot: '/Wisher/index.php/api/WishList/item',
	url: '/Wisher/index.php/api/WishList/item',
	defaults: {
		"id": "",
		"item_id": "",
		"item_name": "",
		"item_url": "",
		"item_price": "",
		"item_quantity": "",
		"item_priority": ""
	}
});