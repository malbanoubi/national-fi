"use strict";jQuery(window).on("elementor/frontend/init",function(){elementorFrontend.hooks.addAction("frontend/element_ready/industrium_countdown.default",function(e){function t(e){let t=jQuery(this).parent();for(let n=3;n<e.length;n++){let o=(e[n]<10?"0":"")+e[n],i=t.find(".countdown_item").eq(n-3).find(".countdown_digits span").addClass("hide");for(let e=o.length-1;e>=0;e--)i.eq(e+(3==n&&o.length<3?1:0)).removeClass("hide").text(o.substr(e,1))}}function n(){let t=e.find(".countdown").data("action").split(",");-1!=t.indexOf("hide")&&e.find(".countdown_inner").hide(),-1!=t.indexOf("message")&&e.find(".countdown_message").show()}e.find(".countdown:not(.inited)").each(function(){jQuery(this).addClass("inited");let e=new Date,o=e.getFullYear()+"-"+(e.getMonth()<9?"0":"")+(e.getMonth()+1)+"-"+(e.getDate()<10?"0":"")+e.getDate()+" "+(e.getHours()<10?"0":"")+e.getHours()+":"+(e.getMinutes()<10?"0":"")+e.getMinutes()+":"+(e.getSeconds()<10?"0":"")+e.getSeconds(),i=jQuery(this).data("date"),d=i.split("-"),u=jQuery(this).data("time"),s=u.split(":");s.length<3&&(s[2]="00");let a=i+" "+u;o<a?jQuery(this).find(".countdown_placeholder").countdown({until:new Date(d[0],d[1]-1,d[2],s[0],s[1],s[2]),tickInterval:1,onTick:t,onExpiry:n}):(n(),jQuery(this).find(".countdown_placeholder").countdown({since:new Date(d[0],d[1]-1,d[2],s[0],s[1],s[2]),tickInterval:1,onTick:t}))})})});