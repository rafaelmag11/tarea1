window.onload = function(){
	Monitor.comenzar();
};
$(window).resize(function(e){
	Monitor.ajustarDivs();
});