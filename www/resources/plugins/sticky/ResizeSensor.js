!function(){var r=function(i,e){function f(){var e,t;this.q=[],this.add=function(e){this.q.push(e)},this.call=function(){for(e=0,t=this.q.length;e<t;e++)this.q[e].call()}}function t(e,t){if(e.resizedAttached){if(e.resizedAttached)return void e.resizedAttached.add(t)}else e.resizedAttached=new f,e.resizedAttached.add(t);e.resizeSensor=document.createElement("div"),e.resizeSensor.className="resize-sensor";var i="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;",s="position: absolute; left: 0; top: 0; transition: 0s;";e.resizeSensor.style.cssText=i,e.resizeSensor.innerHTML='<div class="resize-sensor-expand" style="'+i+'"><div style="'+s+'"></div></div><div class="resize-sensor-shrink" style="'+i+'"><div style="'+s+' width: 200%; height: 200%"></div></div>',e.appendChild(e.resizeSensor),{fixed:1,absolute:1}[function(e,t){return e.currentStyle?e.currentStyle[t]:window.getComputedStyle?window.getComputedStyle(e,null).getPropertyValue(t):e.style[t]}(e,"position")]||(e.style.position="relative");function o(){l.style.width=r.offsetWidth+10+"px",l.style.height=r.offsetHeight+10+"px",r.scrollLeft=r.scrollWidth,r.scrollTop=r.scrollHeight,c.scrollLeft=c.scrollWidth,c.scrollTop=c.scrollHeight,n=e.offsetWidth,d=e.offsetHeight}var n,d,r=e.resizeSensor.childNodes[0],l=r.childNodes[0],c=e.resizeSensor.childNodes[1];c.childNodes[0];o();function h(e,t,i){e.attachEvent?e.attachEvent("on"+t,i):e.addEventListener(t,i)}function a(){e.offsetWidth==n&&e.offsetHeight==d||e.resizedAttached&&e.resizedAttached.call(),o()}h(r,"scroll",a),h(c,"scroll",a)}var s=Object.prototype.toString.call(i),o="[object Array]"===s||"[object NodeList]"===s||"[object HTMLCollection]"===s||"undefined"!=typeof jQuery&&i instanceof jQuery||"undefined"!=typeof Elements&&i instanceof Elements;if(o)for(var n=0,d=i.length;n<d;n++)t(i[n],e);else t(i,e);this.detach=function(){if(o)for(var e=0,t=i.length;e<t;e++)r.detach(i[e]);else r.detach(i)}};r.detach=function(e){e.resizeSensor&&(e.removeChild(e.resizeSensor),delete e.resizeSensor,delete e.resizedAttached)},"undefined"!=typeof module&&void 0!==module.exports?module.exports=r:window.ResizeSensor=r}();