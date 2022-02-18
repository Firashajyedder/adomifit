/*const butt = document.querySelector('link__icon');
const form = document.querySelector('.fone');

let isVisible = false;
console.log(isVisible);

btn.addEventListener('click', () =>{
  isVisible = !isVisible ;
  isVisible ? fone.classList.add('is-visible') : fone.classList.remove('is-Visible');

});*/



		// jQuery functions to show and hide divisions
		$(document).ready(function () {
			
			$('button').click(function () {
				var list = [  'for1', 'for2', 'for3', 'for4'];
				var inputValue = $(this).attr("value");
				$("." + inputValue).toggle();
				for (l in list){
					
					if (list[l]!=$(this).attr("value")){
						if( $("." + list[l]).css('display') != 'none') {
							$("." + list[l]).toggle();
						}
						
					}
				}
				
			});
			
		});


				// jQuery functions to show and hide divisions
				$(document).ready(function () {
			
					$('span').click(function () {
						var list = [  , 'for3', 'for4'];
						var inputValue = $(this).attr("value");
						$("." + inputValue).toggle();
						for (l in list){
							
							if (list[l]!=$(this).attr("value")){
								if( $("." + list[l]).css('display') != 'none') {
									$("." + list[l]).toggle();
								}
								
							}
						}
						
					});
					
				});