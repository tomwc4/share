/*
* // 3D Room functions
*/

// Unity init functions
function enable3DRoomButtons() {

	var activeRoom = '';

	jQuery('.enter-room').click(function(){ 

		var roomWindow = lity(jQuery('.room-content')).options('esc', false); //disable esc for lity close		

		var canvas = document.querySelector("#unity-canvas");
		var progressBarFull = document.querySelector("#unity-progress-bar-full");
		var loadingBar = document.querySelector("#unity-loading-bar");
		var legend = document.querySelector("#unity-legend");
		var options = document.querySelector("#unity-options");
		var nftWindowActive = 0;
		
		if(jQuery('#room').length > 0){

			if(activeRoom == '' && jQuery('#room').data('user') > 0){
				activeRoom = 'currentRoom';			
				createUnityInstance(canvas, config, (progress) => {
					loadingBar.style.display = "block";
					progressBarFull.style.width = 100 * progress + "%";
					}).then((unityInstance) => {

						jQuery(canvas).data('active','1');
						jQuery(canvas).data('audio','1');

						jQuery(loadingBar).fadeOut(500);	
						jQuery(legend).fadeIn(500);	
						jQuery(options).fadeIn(500);

						//trackRoomAction(jQuery('#room').data('room'),jQuery('#room').data('user'),'visited-room',''); //log entry, maybe only there's an event
						
						jQuery('#audio-toggle').click(function(){ 
							if(jQuery(canvas).data('audio') == 1) {
								jQuery(canvas).data('audio','0');
								jQuery(canvas).prop("muted", true);
								jQuery(canvas).prop("volume", 0);
								jQuery(canvas).volume = 0;
								jQuery('#audio-toggle').html('Toggle Audio <i class="fas fa-volume-up"></i>');
							} else {
								jQuery(canvas).data('audio','1');
								jQuery(canvas).prop("muted", false);
								jQuery(canvas).prop("volume", 1);
								jQuery(canvas).volume = 1;
								jQuery('#audio-toggle').html('Toggle Audio <i class="fas fa-volume-mute"></i>');
							}
													
							//console.log("audio "+jQuery(canvas).data('audio'));
						});

						jQuery('#exit-room').click(function(){ 
							roomWindow.close();
						});
					
						/*
						var havePointerLock = 'pointerLockElement' in document ||
						'mozPointerLockElement' in document ||
						'webkitPointerLockElement' in document;

						console.log("pointer lock?? "+havePointerLock);
						

						function updatePosition(e) {
							var movementX = e.movementX ||
							e.mozMovementX          ||
							e.webkitMovementX       ||
							0,
						movementY = e.movementY ||
							e.mozMovementY      ||
							e.webkitMovementY   ||
							0;
							console.log('EVENT!', e);
							//return;
						};
						*/		
						
						
						//unload and clear room on close
						jQuery(document).on('lity:close', function(e, instance) { 
							if(nftWindowActive == 1) {
								nftWindowActive = 0;
							} else {
								console.log('Room Closed');
								unityInstance.Quit();						
								activeRoom = '';
								var gl = canvas.getContext('webgl2');
								gl.clearColor(.14, .12, .13, 1);
								gl.clear(gl.COLOR_BUFFER_BIT);	
								//trackRoomAction(jQuery('#room').data('room'),jQuery('#room').data('user'),'left-room',''); //log entry					
							}
							//console.log(instance);

						});
					}).catch((message) => {
						alert(message);
					});
				}
			}
	});	
}

//log room entry / exit / actions as DB transient
function trackRoomAction(roomID,userID,actionType,eventID) { 

	console.log("roomID: "+roomID+" userID: "+userID+" actionType: "+actionType+" eventID: "+eventID);
	jQuery.ajax({
		type: "GET",
		url: "/wp-admin/admin-ajax.php",
		data:"action=trackRoomAction&isAjax=1&roomID="+roomID+"&userID="+userID+"&actionType="+actionType+"&eventID="+eventID,
		success: function(response) {
			if(response){	
				//var json = jQuery.parseJSON(response);
				//alert(response);
			}
		}
	});
}

//manage external unity messages
function unityShowBanner(msg, type) {
	function updateBannerVisibility() {
	warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
	}
	var div = document.createElement('div');
	div.innerHTML = msg;
	warningBanner.appendChild(div);
	if (type == 'error') div.style = 'background: red; padding: 10px;';
	else {
	if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
	setTimeout(function() {
		warningBanner.removeChild(div);
		updateBannerVisibility();
	}, 5000);
	}
	updateBannerVisibility();
}
