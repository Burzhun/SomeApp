(function( $ ) {

 
  		$.fn.openPop = function(options,method ){

  			obj =  this;

			 var settings = $.extend( {
			      'width'  : 660,
			      'height' : 'auto',
			      'bgFonOpacity' : 0.4,
			      'duration' : 100,
			      'zindex' : 100,
			      'bgFonColor' : '#000',
			       after : function(){},
			       before : function(){},
			    }, options);



			  return obj.each(function() {   


			 settings.after.call(obj);
  
			if($(".bgFon").length) {		 
			}else{			 
				$("body").append("<div class='bgFon'></div>");
			}
			if(obj.find(".closePop").length) {		 
			}else{			 
				obj.prepend("<div class='closePop'>закрыть X</div>");
			}

			obj.addClass("popBoxTrue");	  


			$(".popBoxTrue").removeClass("popBoxActive");	  
			obj.addClass("popBoxActive");	  


 

			var bgFon = $(".bgFon"),
			    topPop = $(window).scrollTop()+$(window).height()/2;
			    
 
			bgFon.css({
				left:0,
				right:0,
				top:0,
				bottom:0,
				position:"fixed",
				opacity:settings.bgFonOpacity,
				background:settings.bgFonColor,
				zIndex:settings.zindex,
				 display:"none"
			}) 
			obj.css({
				top:topPop,
				left:50+"%",
				marginLeft:-settings.width/2,
				width:settings.width,
				height:settings.height,				 
				position:"absolute",				 
				zIndex:settings.zindex+1,
				display:"none",
			})

			obj.css({
			marginTop:-obj.height()/2,

			})



			$(".popBoxTrue").css("zIndex",settings.zindex+1)
			$(".popBoxActive").css("zIndex",settings.zindex+2)

 
			 	 
			 bgFon.fadeIn(settings.duration);			 
			 obj.fadeIn(settings.duration);

			 if(obj.offset().top < 0){
			  	obj.css({
				marginTop:0,
				top:20,
				})
			  }

			   if(obj.offset().left < 0){
			  	obj.css({
				marginLeft:0,
				left:10,
				})
			  }

			  function closePop(close){
			   
			close.fadeOut(100).removeClass("popBoxTrue");
			if($(".popBoxTrue").length) {		 
			}else{
				$(".bgFon").fadeOut(100);
			}		 

			 
			  }


 
			   bgFon.on("click",function(){
			    closePop($(".popBoxTrue"))	    	 

			    })


			$(".closePop").click(function(){
				 
				closePop(obj)

			})

			 $(document).keydown(function(e) { 
				    if( e.keyCode === 27 ) { 
				    	  closePop($(".popBoxTrue"))	    	
				    	 
				    } 
				});


			  });
			 		
			 
		}
 


})(jQuery);

