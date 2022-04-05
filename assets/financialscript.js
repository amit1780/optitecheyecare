$(document).ready(function () {
	var nextYear = new Date().getFullYear().toString().substr(-2);
		nextYear = parseInt(nextYear)+1;		
	var fqyear = new Date().getFullYear() +''+ nextYear;
	$("#fqyear").val(fqyear);
	$(".quotedropdown").click(function(){
		var title = $(this).text();
		var id = $(this).attr("id");		
		$("#titlequote").html(title);
		$("#fqyear").val(id);
	});

	var foyear = new Date().getFullYear() +''+ nextYear;
	$("#foyear").val(foyear);
	$(".orderdropdown").click(function(){
		var title = $(this).text();
		var id = $(this).attr("id");		
		$("#titleorder").html(title);		
		$("#foyear").val(id);
	});
	
	var fcyear = new Date().getFullYear() +''+ nextYear;
	$("#fcyear").val(fcyear);
	$(".challandropdown").click(function(){
		var title = $(this).text();
		var id = $(this).attr("id");		
		$("#titlechallan").html(title);		
		$("#fcyear").val(id);
	});
	
	var fcomyear = new Date().getFullYear() +''+ nextYear;
	$("#fcomyear").val(fcomyear);
	$(".complaindropdown").click(function(){
		var title = $(this).text();
		var id = $(this).attr("id");		
		$("#titleComplain").html(title);		
		$("#fcomyear").val(id);
	});
});