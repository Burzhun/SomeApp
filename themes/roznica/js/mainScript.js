  function testAnim(x) {
    $('#gg').removeClass().addClass(x + ' animated popup_text').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass('animated');
      $(this).removeClass(x);
    });
  };



function isChooseStone(){
		//$('.to_cart.btn.toCart.itemCart').on('click', function(){
			
			var activeKamen = $('.kamenBox label.activekamenBox');
			var kamens = $('.kamenBox label');
			if(!activeKamen.length&&kamens.length){
				$('.popup_text').show();
				testAnim('shake');
				return false;
			}

			return true;
		//});
}

$(function(){



		$('.closePopup').on('click',function(){
			$('.popup_text').hide();
		});

	   $(".left_menu").accordion({
		        accordion:true,
		        speed: 500,		        
		    });


	   //$(".kamenBox label").click(function(){
	   	$('body').on('click',".kamenBox label",function(){

	   	 $(".kamenBox label").removeClass("activekamenBox")
	   	 $(this).addClass("activekamenBox")



	   	 $(".kamenBoxSize.size").hide();
	   	 var id = $(this).data('id');
	   	 $('#ss'+id).show();

	   	$('#ss'+id+' label').first().click();

	   	 $('#formstonekod').val(id);

	   })

	    //$(".kamenBoxSize label,.radioBut").click(function(){
	    $("body").on('click',".kamenBoxSize label,.radioBut",function(){
	   		$(".kamenBoxSize label,.radioBut").removeClass("activekamenBox")
	   		$(this).addClass("activekamenBox")

			var serialkod = $(this).data('serialkod');
			/*$('.priceItem').hide();
			$('#priceItem'+serialkod).show();*/

			$('#formserialkod').val(serialkod);

	   		var size = $(this).data('size');
		   	 $('#formsize').val(size);
	   });



  $('input[type=checkbox]').css({'opacity': 0}).wrap('<span class="wrap-checkbox"></span>');
  	$("input:radio:checked").parent().addClass('active')
  	$("input:checkbox:checked").parent().addClass('active')

  	
  $('.wrap-checkbox').click(function() {
  	
  $(this).toggleClass('active'); /* переключатель класса .active */

})

  $(".topCityActive").click(function(){
  	$(".topCityDropBox").toggleClass("openTopCityDropBox")
  })

  $(".topCityDropBox a").click(function(){
     $(".topCity  strong").text($(this).data("address"));
     $(".topCityDropBox").removeClass("openTopCityDropBox");
      $(".topCityActive").text($(this).text());
     return false;
  })

 
		
})