
jQuery(document).ready(function() {
	var currentId;
	jQuery('.img-polaroid').click(function(event) {
		var currentId = jQuery(this).attr('id');
		var a = [];
		a = jQuery('.item');
		for (var i = a.length - 1; i >= 0; i--) {
			jQuery(a[i]).attr('class', 'item');

			if (currentId == jQuery(a[i]).attr('id')) {
				jQuery(a[i]).attr('class', 'item active');
			};
		};
	});

	// Click On image set the default image in frontend Not in database.
	jQuery('.img-polaroid').click(function(event) {
		var imageName = jQuery(this).attr('id');
		var src = jQuery(this).attr('src');
		var newSrc = src.substr(0,src.indexOf('thumbs/'));
		var newImage = "";
		jQuery.ajax({
			url: 'index.php?option=com_category&task=categories.setImage&tmpl=component',
			dataType : "json",
			data: {image: imageName},
			success: function (json) {
				var image = json.image;
				var newimg = json.thumbs;
				newImage = newSrc + "thumbs/" + newimg;
				jQuery('.img-rounded').attr("src",newImage);
				jQuery('.img-rounded').attr("id",image);
			}
		})
	});

	// Click on image set the default image in backend.
	jQuery('.image').click(function(event) {

		var url =location.href;
		var idpos = url.indexOf("id");
		var ids = url.substr(idpos+3);
		var imageName = jQuery(this).attr('id');
		jQuery.ajax({
			url: 'index.php?option=com_category&task=categories.clickImage&tmpl=component',
			data: {image: imageName,id: ids},
		});

		var a = [];
		a = jQuery('.span7').children('div').children('img');

		for (var i = a.length - 1; i >= 0; i--) {
			jQuery(a[i]).attr('class', 'image');

			if (imageName == jQuery(a[i]).attr('id'))
			{

				jQuery(a[i]).attr('class', 'imgborder');
			}
		};
	});

	// Click on image set the default image in modal.
	jQuery(".img-rounded").click(function(event) {
		var current = jQuery(this).attr('id');
		var item = [];
		item = jQuery('.item');

		for (var i = item.length - 1; i >= 0; i--) {
			jQuery(item[i]).attr('class','item');
			if (current == jQuery(item[i]).attr('id'))
			{
				jQuery(item[i]).attr('class', 'item active');
			}
		};
	});

	// stop the auto slideshow
	jQuery('.carousel').carousel({
	    interval: false
    });

	// Set the default selected menu in sidebar.
	var url = location.href;
	var countActive="";
	var cnt = url.indexOf("index");
	url = url.substr(cnt);
	var defaultpath = "index.php?option=com_category";
	var a = [];
	a = jQuery('.sidebar').children('a');
	for (var i = a.length - 1; i >= 0; i--) {
    	var count = jQuery(a[i]).attr('href').indexOf("index");
		var path = jQuery(a[i]).attr('href').substr(count);
    	if (url == path)
		{
			countActive++;
			var li = jQuery(a[i]).parent('li');
			jQuery(li).attr('class' , 'active');
		}
	};

	if (countActive == 0)
	{
		var category = jQuery('#Categories');
		jQuery(category).attr('class' , 'active');
	}

	// mouseover on image show the delete button
	jQuery('.imagearea').mouseover(function(event) {

		current = jQuery(this).attr('id');
		var items = [];
		items = jQuery('.closebtn');
		for (var i = items.length - 1; i >= 0; i--) {
			if (current == jQuery(items[i]).attr('id'))
			{
				jQuery(items[i]).addClass('show');
			}
		};

	});

	// mouseout on image delete button hide.
	jQuery('.imagearea').mouseout(function(event) {
		current = jQuery(this).attr('id');
		var items = [];
		items = jQuery('.closebtn');


		for (var i = items.length - 1; i >= 0; i--) {
			if (current == jQuery(items[i]).attr('id'))
			{
				jQuery(items[i]).removeClass('show');
			}
		};
	});

	// Delete image click on Delete button
	jQuery('.closebtn').click(function(event) {
		currentimage = jQuery(this).attr('id');
		var href = jQuery(this).next('img').attr('src');
		var thumbs = href.substr(href.indexOf('thumbs/'));
		var newthumbs = thumbs.substr(thumbs.indexOf('/')+1);
		var url =location.href;
		var defaultSelect="";
		var idpos = url.indexOf("id");
		var ids = url.substr(idpos + 3);
		var div = jQuery(this).parent('div');
		jQuery.ajax({
       		type: 'GET',
			url: 'index.php?option=com_category&task=categories.deleteImage&tmpl=component',
			data: {image: currentimage,id: ids,thumb:newthumbs},
			success: function (json) {
				jQuery(div).remove();
			}
		});
	});
});

