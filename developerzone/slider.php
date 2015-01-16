<h3>Dit is een slider</h3>
<style>
#slider_1
{
	width:100px;
}
#dog
{
	width:300px;
	height:225px;
}
</style>

<script>
	$(document).ready(function(){
		
		$('#slider_1').slider({
			max:500,
			min:300,
			orientation:'horizontal',
			slide: function(event, ui){
				$('#dog').css('width' , ui.value);
			}
		});
		
		$('#slider_2').slider({
			orientation:'vertical',
			max:500,
			min:225,
			value:500,
			slide: function(event, ui){
				$('#dog').css('height', 225 + ui.value);
			}
		});
		
	});
	
</script>

<div id='slider_1'></div>
<div id='slider_2'></div>
<img id='dog' src='./images/imagerotator/siberian_husky.jpg' alt='dog' />
