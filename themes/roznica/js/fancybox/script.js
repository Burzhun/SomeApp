

	$(document).ready(function() {
		$(".fancybox").fancybox();


	var arr_imgs=$("img.dm-box-group")
	for(i=0; i<arr_imgs.length; i++)
	{


		var arr_imgs_href=arr_imgs.eq(i).parent().attr('href');


		var arr_img=arr_imgs.eq(i)
		var src=arr_img.attr('src')
		if(arr_imgs.eq(i).parent().is('a'))
		{
			arr_imgs.eq(i).parent().removeClass()
			arr_imgs.eq(i).parent().addClass("fancybox")

		}
		else{

		arr_img.wrap("<a class='fancybox'></a>");
		
		var link=arr_img.parent()
		
		link.attr({href:src})
		}
	}

	$("img.group").parent().attr({rel:'group'})



});