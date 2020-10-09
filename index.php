<!DOCTYPE html>
<html lang="en">
	

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-165373938-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-165373938-1');
	</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Lichess Standings Download, Direct Lichess Tournament Data Download">
  <meta name="author" content="Saurabha Joglekar">

  <title>Lichess Tournament Standings Downloader - Saurabha Joglekar</title>
  <link rel="icon" href="favicon.png" sizes="32x32">
  <link rel="icon" href="favicon.png" sizes="192x192">
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
<style>
	/* Center the loader */
	#loader {
	  position: absolute;
	  left: 50%;
	  top: 50%;
	  z-index: 1;
	  width: 150px;
	  height: 150px;
	  margin: -75px 0 0 -75px;
	  border: 16px solid #f3f3f3;
	  border-radius: 50%;
	  border-top: 16px solid #3498db;
	  width: 120px;
	  height: 120px;
	  -webkit-animation: spin 2s linear infinite;
	  animation: spin 2s linear infinite;
	}

	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}

	/* Add animation to "page content" */
	.animate-bottom {
	  position: relative;
	  -webkit-animation-name: animatebottom;
	  -webkit-animation-duration: 1s;
	  animation-name: animatebottom;
	  animation-duration: 1s
	}

	@-webkit-keyframes animatebottom {
	  from { bottom:-100px; opacity:0 } 
	  to { bottom:0px; opacity:1 }
	}

	@keyframes animatebottom { 
	  from{ bottom:-100px; opacity:0 } 
	  to{ bottom:0; opacity:1 }
	}

	#myDiv {
	  display: none;
	  text-align: center;
	}
</style>

	
</head>


  <!-- Page Content -->
  <div id="loader"></div>
  <div class="container" id="myDiv">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 text-center">
	  <br>
		<a href = "https://aurabha.com"><img src = "saurabha design.png" width="40%"></a>
        <h2 class="mt-4">Lichess Tournament Standings Downloader</h2>
		<br>
		<p class="lead text-justify"> 
			Hi, This is Saurabha Joglekar👋 a Chess Enthusiast, <a href="https://lichess.org/">Lichess.org</a> Proponent and Chess Fanboy.
			<br>
			Recently, while organizing a SWISS Tournament on <a href="https://lichess.org/">Lichess.org</a>, it dawned me that we just can not download the standings table 🤦‍♂️ <br>
			<br>Being the Techie that I am, I collaborated with my <b>fellow techie <a href="https://www.linkedin.com/in/vishal-raykar-193962a1/" target="_blank">Vishal Raykar</a></b> 
			(he developed <strike>most</strike> all of it 😋) and made this task easy-pizy for all of us.
			<br>All you have to do is, enter the <strong>URL of your Lichess Swiss Tournament</strong> and Click on the <strong>Download CSV</strong> button and then Magic.✨✨
		</p>
		<br>
			<form class="col-lg-8 offset-lg-2 ">
			  <div class="row justify-content-center">
				<input type="text" class="form-control form-control-lg col-lg-12" id="tournamentlink" placeholder="https://lichess.org/swiss/vQgJZSZC">
				<br>
				<br>
				<br>
				<span class="input-group-btn">
					<button type="button" class="btn btn-primary" onclick="DownloadCSV()">Download CSV</button>	
				</span>					
			  </div>
			</form>
        </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
			  function ShowLoader() {
  document.getElementById("loader").style.display = "block";
  document.getElementById("myDiv").style.opacity = "0.3";
  //document.getElementById("myDiv").style.display = "none";
}
	  function HideLoader() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.opacity = "1";
  document.getElementById("myDiv").style.display = "block";
}  
	function scrapData(urlmain) {
		
		var data = ['Name', 'Id', 'Rating', 'Points', 'TieBreak', 'Rank'];
		var FinalData = [];
		FinalData.push(data);
		data = [];

		//pagecount = Math.ceil(participantcount / 10);
		for (var i = 1; i <= 300; i++) {
			var _getUrl = "https://lichess.org/swiss/" + urlmain + "/standing/" + i;
						
			//var temp = JSON.parse(httpGet(getUrl));
				
			//PHP Call Here
			jQuery .ajax({
				type: 'post',
				async: false,
				url: 'fetch.php',
				data: {getUrl:_getUrl},
				success: function (response) {
					var temp = JSON.parse(response);
					
					if(temp.players.length == 0){
						exportToCsv('Lichess-Standings[Saurabha.com].csv', FinalData);
						i=301;
					HideLoader();
						return;
					}
					
					for (var j = 0; j < temp.players.length; j++) {
						var temp2 = temp.players[j];
						data.push(temp2.user.name);
						data.push(temp2.user.id);
						data.push(temp2.rating);
						data.push(temp2.points);
						data.push(temp2.tieBreak);
						data.push(temp2.rank);
						FinalData.push(data);
						data = [];
					}				
					
				},
				error: function () {
					HideLoader();
				}
			});
			//Till Here

		}
		HideLoader();
		//console.log(FinalData);
	}

	function httpGet(theUrl) {
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.open("GET", theUrl, false); // false for synchronous request
		xmlHttp.send(null);
		return xmlHttp.responseText;
	}


	function exportToCsv(filename, rows) {
		var processRow = function(row) {
			var finalVal = '';
			for (var j = 0; j < row.length; j++) {
				var innerValue = row[j] === null ? '' : row[j].toString();
				if (row[j] instanceof Date) {
					innerValue = row[j].toLocaleString();
				};
				var result = innerValue.replace(/"/g, '""');
				if (result.search(/("|,|\n)/g) >= 0)
					result = '"' + result + '"';
				if (j > 0)
					finalVal += ',';
				finalVal += result;
			}
			return finalVal + '\n';
		};

		var csvFile = '';
		for (var i = 0; i < rows.length; i++) {
			csvFile += processRow(rows[i]);
		}

		var blob = new Blob([csvFile], {
			type: 'text/csv;charset=utf-8;'
		});
		if (navigator.msSaveBlob) { // IE 10+
			navigator.msSaveBlob(blob, filename);
		} else {
			var link = document.createElement("a");
			if (link.download !== undefined) { // feature detection
				// Browsers that support HTML5 download attribute
				var url = URL.createObjectURL(blob);
				link.setAttribute("href", url);
				link.setAttribute("download", filename);
				link.style.visibility = 'hidden';
				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
			}
		}
	}

	function CreateSearchLog(urlmain) {
		
		var _getUrl = urlmain;
				
		//PHP Call Here
		jQuery .ajax({
			type: 'post',
			async: false,
			url: 'CreateSearchLog.php',
			data: {getUrl:_getUrl},
			success: function (response) {	
			},
			error: function () {
			}
		});
		//Till Here

		
	}

	

	function DownloadCSV() {
		var url = document.getElementById("tournamentlink").value;
		
			
		//create log//
		if(url!=""){ CreateSearchLog(url); }
		//////////////
		
		
		var urlmain = url.split("/");
		if(urlmain[0] == "http" || urlmain[0] == "https" || urlmain[0] == "https:" || urlmain[0] == "http:" )
		{
			ShowLoader();
			setTimeout(function(){ scrapData(urlmain[4]); }, 1000);			
		}
		else
		{
			alert("Issue in URL. URL must start with https://");			
		}
	}
	  

HideLoader();
</script>

</body>

</html>
