<script src="js/hls.js"></script>

<!-- <video id="video" width="100%" height="380" controls autoplay muted class="videoCentered"></video> -->
 <video id="video" width="100%" height="380" controls autoplay muted> hier video </video>
<script>
if(Hls.isSupported()) {
	var video = document.getElementById('video');
	var hls = new Hls();

	hls.on(Hls.Events.MANIFEST_PARSED,function(event,data) {
	  console.log( 'manifest loaded, found ' + data.levels.length + ' quality level',);
		console.log(data);
	  video.play();
	});
	

	hls.on(Hls.Events.MEDIA_ATTACHED, function () {
	      console.log('video and hls.js are now bound together !');
    });

	hls.loadSource('https://stream.l45.be/hls/kievu.m3u8');
	hls.attachMedia(video);
	 //video.play();

}


hls.on(Hls.Events.ERROR, function (event, data) {
  var errorType = data.type;
  var errorDetails = data.details;
  var errorFatal = data.fatal;

  switch (data.details) {
    case Hls.ErrorDetails.FRAG_LOAD_ERROR:
      // ....
	console.log("error on frag load");
      break;
    default:
	console.log("error catch all", data,errorDetails, errorType, errorFatal);
      break;
  }
});

</script>