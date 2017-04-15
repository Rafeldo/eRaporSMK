<?php
// Start the session.
error_reporting(E_ALL | E_STRICT);
session_start();
$session = unserialize($_COOKIE['erapor_sessions']);
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $session['title']; ?></title>
  <script src="js/jquery.min.js"></script>
  <style>
    #progress {
      width: 100%;
      border: 1px solid #aaa;
      height: 20px;
    }
    #progress .bar {
      background-color: #ccc;
      height: 20px;
    }
	#message {text-align:center;}
  </style>
</head>
<body>
<h3><center>Proses Entry <?php echo $session['title']; ?></center></h3>
<?php
$root = "http://".$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$root = str_replace('step_2/','',$root);
?>
<div id="progress"></div>
<div id="message"></div>
  <script>
    var timer;

    // The function to refresh the progress bar.
    function refreshProgress() {
      // We use Ajax again to check the progress by calling the checker script.
      // Also pass the session id to read the file because the file which storing the progress is placed in a file per session.
      // If the call was success, display the progress bar.
      $.ajax({
        url: "checker.php?file=<?php echo session_id(); ?>",
        success:function(data){
          $("#progress").html('<div class="bar" style="width:' + data.percent + '%"></div>');
          $("#message").html(data.message);
          // If the process is completed, we should stop the checking process.
          if (data.percent == 100) {
		  	window.location.replace('<?php echo $root; ?>');
            //window.clearInterval(timer);
            //timer = window.setInterval(completed, 1000);
          }
        }
      });
    }

    function completed() {
      $("#message").html("Completed");
      window.clearInterval(timer);
    }

    // When the document is ready
    $(document).ready(function(){
      // Trigger the process in web server.
       $.ajax({
	  		url: "process.php",
			type: 'post',
			data: {id:'<?php echo $session['table'] ?>'},
			});
      // Refresh the progress bar every 1 second.
      timer = window.setInterval(refreshProgress, 1000);
    });
  </script>
</body>
</html>
