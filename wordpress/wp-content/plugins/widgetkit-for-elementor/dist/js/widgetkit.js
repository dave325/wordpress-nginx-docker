jQuery(document).ready(function(t){t(".border").length&&jQuery(window).load(function(){$portfolio_selectors=t(".border>li>a"),$portfolio_selectors.on("click",function(){t(this).attr("data-filter");return!1})}),t(".slash").length&&jQuery(window).load(function(){$portfolio_selectors=t(".slash>li>a"),$portfolio_selectors.on("click",function(){t(this).attr("data-filter");return!1})}),t(".round").length&&jQuery(window).load(function(){$portfolio_selectors=t(".round>li>a"),$portfolio_selectors.on("click",function(){t(this).attr("data-filter");return!1})}),[1,2,3,4].forEach(function(e){t(".hover-"+e).length&&t(".hover-"+e).mixItUp({})}),jQuery(document).ready(function(){t("#hover-1 .portfolio-item").each(function(){t(this).hoverdir()})}),t("#tgx-hero-unit .carousel-inner .item").css({height:t(window).height()+"px"}),t(window).resize(function(){t("#tgx-hero-unit .carousel-inner .item").css({height:t(window).height()+"px"})}),t(".tgx-project").length&&jQuery(".tgx-project").addClass("owl-carousel").owlCarousel({pagination:!0,center:!0,margin:100,dots:!1,loop:!0,items:2,nav:!0,navClass:["owl-carousel-left","owl-carousel-right"],navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],autoHeight:!0,autoplay:!1,responsive:{0:{items:1},600:{items:1},1000:{items:2}}}),t(".wkfe-click-to-tweet .wkfe-tweet").on("click",function(){var e=window.location.href.split("?")[0],o=t(this).parentsUntil(".wkfe-click-to-tweet").find(".tweet-text").text().trim(),i="https://twitter.com/share?url="+encodeURIComponent(e)+"&text="+encodeURIComponent(o);window.open(i,"_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=720,height=500")})});