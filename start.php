<!DOCTYPE html>

<?php 
	session_start();
	//if(empty($_SESSION['id_facebook'])){$_SESSION['id_facebook']=0;}
	//if(empty($_SESSION['username'])){$_SESSION['username']="";}
	//if(empty($_SESSION['id_movie'])){$_SESSION['id_movie']=0;}
?>

<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<!--<script src="js/facebook.js"></script>-->
	<script type="text/javascript">
		//var page 1
			var id_facebook = 10005,
				id_movie = 0,
				username = "sugo5";
			
		//var page 4
			var selectedHair = 5,
				colHair = 1,
				selectedBackHair = 5,
				fat = 2,
				rB = 245,
				gB = 197,
				bB = 96,
				rH = 100,
				gH = 100,
				bH = 100,
				uploadStatus=0,
				lastSelected=5,
				lastSelected2=5,
				lastSelected3=2,
				gender = 1,
				selectedBody = 1;
		//var page 5
			var city=12,
				food=7,
				job=1,
				photo_dir = "",
				json_dir = "";
			
			/*
				function page2update(){
					console.log("jalan loh ini page2 nya");
					$.ajax({
						type="POST",
						dataType = "json",
						url: ''
					});
				}
			*/	
			/*
				function saveCustom(){
				}

				function getFile(){
		   			document.getElementById("imageLoader").click();
		 		}

		 		function initialGame(){
		 			
		 		}

		 		function sendPage2(){
		 			$.ajax({
		 				type:"POST",
		 				url:"savePage2.php",
		 				data:{}
		 			});
		 		}

		 		function sendPage4(){
		 			$.ajax({
		 				type:"POST",
		 				url:"savePage3.php",
		 				data:{
		 					userId: userId;
		 					redBody: rB,
		 					greenBody: gB,
		 					blueBody: bB,
		 					redHair: rH,
		 					greenBody: gH,
		 					blueHair: bH,
		 					bodySize: selectedBody,
		 					frontHair: selectedHair,
		 					backHair: selectedBackHair
		 				}
		 			});
		 		}

		 		function sendPage5(){
		 			$.ajax({
		 				type:"POST",
		 				url:"savePage5.php",
		 				data:{
		 					userId: userId;
		 					userName: name,
		 					userJob: job,
		 					userCity: city,
		 					userFood: food
		 				}
		 			});
		 		}
		 	*/

		//document ready
			$(document).ready(function(){
				//alert(photo_dir);
				
				if(gender == 1){
					document.getElementById("col1").style.display="none";
					document.getElementById("col2").style.display="none";
				}

			//page 2 ajax JQuery.Form
				var options = {
					type: "POST",
					data: {
						id_facebook : id_facebook, 
						username : username, 
						id_movie : id_movie
					},
					dataType: "json",
					target: '.mugshot', //Div tag where content info will be loaded in
	            	url:'page2upload.php', //The php file that handles the file that is uploaded
	            	// beforeSubmit: function() {
	            	// 	console.log('beforeSubmit');
		            //     //$('#uploader').html('<img src="ajax-loader.gif" border="0" />'); //Including a preloader, it loads into the div tag with id uploader
	            	// },
	            	success:  function(data) {
	            		var verifyFace = data.face;
						var frontal = data.frontal;

	            		uploadStatus=1;
	            		if(verifyFace == 0){
	            			$('#explanation p').text('Wajah tidak terdeteksi, untuk hasil maksimal pilih foto dengan wajah menghadap kedepan');
	            		}else{
							
	            			//console.log("ini jalan loh");
	            			photo_dir = data.photo_dir;
	            			json_dir = data.json_dir;
	            			alert(photo_dir+"   "+json_dir);
							if(frontal==0){
								$('#explanation p').text('Foto memiliki kekurangan, untuk mendapat hasil maksimal coba untuk upload kembali');
							}else if(frontal==1){
								$('#explanation p').text('Apakah sudah yakin? Jika ya pilih buat avatar');
							}else if(frontal==2){
								$('#explanation p').text('Wajah tidak menghadap kedepan, baiknya upload kembali');
							}
	            			faceImage.src = photo_dir;
	            			drawPhoto();
	            			//drawChara();
	            		}

	                	//Here code can be included that needs to be performed if Ajax request was successful
	                	//$('#uploader').html('');
	            	}
	            };

	            $('#UploadForm').submit(function() {
	                $(this).ajaxSubmit(options);
	                return false;
	            });


				$("#start-button a.button").click( function () {
					page1initial();
					document.getElementById("page1").style.display="none";
					document.getElementById("page2").style.display="block";
					document.getElementById("canvas1").style.display="block";
				});
				$("#create-avatar a.button").click( function () {
					if(uploadStatus==0){

						
						$('#explanation p').text('File Belum Ter Upload');
						document.getElementById("page2").style.display="none";
						document.getElementById("page4").style.display="block";
						drawChara();
					}else{
					document.getElementById("page2").style.display="none";
					document.getElementById("page4").style.display="block";
					initChara();
					drawChara();
				}
				});
				$("#finalize-avatar a.button").click( function () {
					document.getElementById("page4").style.display="none";
					document.getElementById("page5").style.display="block";
					document.getElementById("canvas1").style.display="none";
					document.getElementById("clayer1").style.display="none";
					document.getElementById("clayer2").style.display="none";
					document.getElementById("clayer3").style.display="none";
					//saveCustom();
					
				});
				$("#finalize-movie a.button").click( function () {
					page5submit();
				});
				
			//page 4 custom avatar hair style
				setSelected();
				$("#hair1").click( function () {
					resetSelected();
					if(colHair==1){	
						selectedHair = 1;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 1;
					}else{	selectedBackHair = 1;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 1;
					}
				});
				$("#hair2").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 2;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 2;
					}else{ selectedBackHair = 2;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 2;
					}				
				});
				$("#hair3").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 3;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 3;
					}else{ selectedBackHair = 3;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 3;
					}
				});
				$("#hair4").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 4;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 4;
					}else{	selectedBackHair = 4;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 4;
					}
				});
				$("#hair5").click( function () {
					resetSelected();
					if(colHair==1){ selectedHair = 5;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 5;
					}else{	selectedBackHair = 5;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 5;
					}			
				});
				$("#hair6").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 6;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 6;
					}else{ selectedBackHair = 6;
						setSelected();
						drawBackHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected2 = 6;
					}
				});
				$("#hair7").click( function () {
					resetSelected();
					if(colHair==1){ selectedHair = 7;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 7;
					}
				});
				$("#hair8").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 8;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 8;	
					}	
				});
				$("#hair9").click( function () {
					resetSelected();
					if(colHair==1){	selectedHair = 9;
						setSelected();
						drawFrontHair();

						if(selectedHair==lastSelected){
							changeHair();
						}
						lastSelected = 9;
					}
				});

			//page 4 select front and back
				$("#col1").click( function () {		
					if(colHair==2){
						console.log('col1');
						resetColumn();
						resetSelected();
						document.getElementById("col1").style.background="url(images/rb_on.png)";
						document.getElementById("col2").style.background="url(images/rb_off.png)";
						colHair=1;
						setSelected();
						
					}
				});
				$("#col2").click( function () {		
					if(colHair==1){
						console.log('col2');
						resetColumn();
						resetSelected();
						document.getElementById("col2").style.background="url(images/rb_on.png)";
						document.getElementById("col1").style.background="url(images/rb_off.png)";
						colHair=2;
						setSelected();
					
					}
				});

				//page 5 clear txt name
				$("#btnClear").click( function(){
					console.log("aaaaa");
					$('input[type=text]#txtName').val('');
					$(this).parent().find("input#txtName").focus();
				});
			});

		//ajax page 1
			function page1initial(){
				console.log("page1");
				$.ajax({
					type: "POST",
					dataType: "json",
					url: 'page1initial.php',
					data: {
						username: username, 
						id_facebook: id_facebook, 
						gender: gender, 
						city:city
					},
					success:function(data){
						id_movie = data.id_movie;
					}
				});
			}

		//ajax page 5
			function page5submit(){
				console.log("page5");
				$.ajax({
					type: "POST",
					dataType: "json",
					url: 'page5submit.php',
					data: {
						id_facebook: id_facebook,
						id_movie: id_movie,
						fat: fat,
						rB: rB,
						gB: gB,
						bB: bB,
						rH: rH,
						gH: gH,
						bH: bH,
						gender: gender,
						selectedHair: selectedHair,
						selectedBackHair: selectedBackHair,
						city: city,
						username: username,
						food: food,
						job: job
					},
					success:function(data){
						console.log("cumi");
						window.location.href = "animate.php";
					}
				});
			}

		//page 2 upload form
			function getFile(){
	   			document.getElementById("imageLoader").click();
	 		}
			function submitForm() {
	        	// However you need to submit the form
	            document.getElementById("uploadFile").click(); // Or whatever
	        }

		//page 4 JQuery.UI slider
			$(function(){
				$( "#pointer" ).draggable({
					containment: [230,0,540,10],
					axis:"x",
					stop:function(event,ui){
						if(ui.position.left>-10&&ui.position.left<=100){
							$(" #pointer ").animate({"left": "25px"}, 200);
							selectedBody=1;
							drawBody();

							if(selectedBody==lastSelected3){
								changeBody();
							}
							lastSelected3 = 1;

						}else if(ui.position.left>100&&ui.position.left<=260){
							$(" #pointer ").animate({"left": "180px"}, 200);
							selectedBody=2;
							drawBody();

							if(selectedBody==lastSelected3){
								changeBody();
							}
							lastSelected3 = 2;

							/*$(" #pointer ").animate({"right": "180px"}, 600);*/
						}else if(ui.position.left>260&&ui.position.left<=400){
							$(" #pointer ").animate({"left": "340px"}, 200);
							selectedBody=3;
							drawBody();

							if(selectedBody==lastSelected3){
								changeBody();
							}
							lastSelected3 = 3;

						}
					}  
				});
				$( "#pointer2" ).draggable({
					containment: [71,0,233,0],
					axis:"x",
					stop:function(event,ui){

						//change slider value into ratio between 0 and 1
						var sliderRatio = (ui.position.left - 1) / (163 - 1 );
						console.log(sliderRatio);
						//rB= 111 - 245;
						//gB=68 197
						//bB 26 96;
						rB = 245 - ((245-111) * sliderRatio);
						gB = 197 - ((197-68) * sliderRatio);
						bB = 96 - ((96-26) * sliderRatio);
						console.log(rB);
						console.log(gB);
						console.log(bB);

						changeBody();
					}				
				});
				$( "#pointer3" ).draggable({
					axis:"x",
					containment: [71,0,233,0],
					stop:function(event,ui){
						var sliderRatio = (ui.position.left - 1) / (163 - 1 );
						console.log(sliderRatio);
						// r 155 -45
						//g 124 - 41
						//b 55 - 40
						rH = 155 - ((155-45) * sliderRatio);
						gH = 124 - ((124-41) * sliderRatio);
						bH = 55 - ((55-40) * sliderRatio);
						changeHair();					
					}
				});
			});

		//page 4 custom radio
			function resetSelected(){
				if(colHair==1){
					if(selectedHair==1){ document.getElementById("hair1").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==2){ document.getElementById("hair2").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==3){ document.getElementById("hair3").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==4){ document.getElementById("hair4").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==5){ document.getElementById("hair5").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==6){ document.getElementById("hair6").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==7){ document.getElementById("hair7").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==8){ document.getElementById("hair8").style.background="url(images/checkbox_off.png)";
					}else if(selectedHair==9){ document.getElementById("hair9").style.background="url(images/checkbox_off.png)";
					}
				}else{
					if(selectedBackHair==1){ document.getElementById("hair1").style.background="url(images/checkbox_off.png)";
					}else if(selectedBackHair==2){ document.getElementById("hair2").style.background="url(images/checkbox_off.png)";
					}else if(selectedBackHair==3){ document.getElementById("hair3").style.background="url(images/checkbox_off.png)";
					}else if(selectedBackHair==4){ document.getElementById("hair4").style.background="url(images/checkbox_off.png)";
					}else if(selectedBackHair==5){ document.getElementById("hair5").style.background="url(images/checkbox_off.png)";
					}else if(selectedBackHair==6){ document.getElementById("hair6").style.background="url(images/checkbox_off.png)";
					}
				}
			}
			function setSelected(){
				if(colHair==1){
					if(selectedHair==1){ document.getElementById("hair1").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==2){ document.getElementById("hair2").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==3){ document.getElementById("hair3").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==4){ document.getElementById("hair4").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==5){ document.getElementById("hair5").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==6){ document.getElementById("hair6").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==7){ document.getElementById("hair7").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==8){ document.getElementById("hair8").style.background="url(images/checkbox_on.png)";
					}else if(selectedHair==9){ document.getElementById("hair9").style.background="url(images/checkbox_on.png)";
					}
				}else{
					if(selectedBackHair==1){ document.getElementById("hair1").style.background="url(images/checkbox_on.png)";
					}else if(selectedBackHair==2){ document.getElementById("hair2").style.background="url(images/checkbox_on.png)";
					}else if(selectedBackHair==3){ document.getElementById("hair3").style.background="url(images/checkbox_on.png)";
					}else if(selectedBackHair==4){ document.getElementById("hair4").style.background="url(images/checkbox_on.png)";
					}else if(selectedBackHair==5){ document.getElementById("hair5").style.background="url(images/checkbox_on.png)";
					}else if(selectedBackHair==6){ document.getElementById("hair6").style.background="url(images/checkbox_on.png)";
					}
				}
			}
			function resetColumn(){
				if(colHair==1){
					document.getElementById("hair7").style.display="none";
					document.getElementById("hair8").style.display="none";
					document.getElementById("hair9").style.display="none";
				}else{
					document.getElementById("hair7").style.display="block";
					document.getElementById("hair8").style.display="block";
					document.getElementById("hair9").style.display="block";
				}
			}

		//page 5 select value
			function setCity(){
				city=$('#city').val();
				console.log(city);
				$('#text-city').text(city);
				//document.getElementById("text-city").innerHTML = document.getElementById("city").value;
			}
			function setJob(){
				job=$('#job').val();
				$('#text-job').text(job);
			}
			function setFood(){
				food=$('#food').val();
				$('#text-food').text(food);
			}
	</script>

	<link rel="stylesheet" type="text/css" media="all" href="css/style1.css" />
</head>
<body>
	<div id="fb-root"></div>
	<div id="main">

		<div id="sky" class="ae">
			<div id="cloud1" class="cloud ae"></div>
			<div id="cloud2" class="cloud ae"></div>
			<div id="cloud3" class="cloud ae"></div>
			<div id="cloud4" class="cloud ae"></div>
		</div>

		<div id="page1" name="opening">
			<div id="kobe-logo" class="ae layer1"></div>
			<div id="landmarks" class="ae layer2"></div>
			<div id="grass-back" class="ae layer3"></div>
			<div id="grass-front" class="ae layer3"></div>
			<div id="avatar-middle" class="ae layer3"></div>
			<div id="title" class="ae layer4"></div>
			<div id="gallery-button" class="button ae layer5" >
				<a class="button" href="gallery1.php">Mulai</a>
			</div>
			<div id="start-button" class="button ae layer5" >
				<a class="button" href="#">Mulai</a>
			</div>
		</div>

		<div id="page2" name="selection">
			<div id="boncabe-logo" class="ae"></div>
			<div id="mugshot" class="ae mugshot">
			</div>
			<div id="take-photo" class="ae">
				<!--<a class="button" href="#" onclick="getFile();"></a>-->
			</div>
			<div id="choose-photo" class="ae">
				<a class="button" href="#" onclick="getFile();">Pilih Gambar</a>
			</div>
			<div class="remover">
				<form id="UploadForm" action="#" method="post" enctype="multipart/form-data">					
					<input type="file" name="file" id="imageLoader" onchange="submitForm();"/>
					<input type="submit" id="uploadFile" value="Upload file"> 
				</form>
			</div>
			
			<div id="explanation" class="ae">
				<p>Klik tombol di bawah ini<br/>jika foto kamu sudah sesuai!</p>
			</div>
			<div id="create-avatar" class="ae">
				<a class="button" href="#">Buat Avatar!</a>
			</div>
		</div>

		<div id="page3" name="waiting">
		</div>

		<div id="page4" name="custom">
			<div id="boncabe-logo2" class="ae"></div>
			<div id="mugshot2" class="ae mugshot">
			</div>
			
			<div id="hair1" class="hair-style ae"></div>
			<div id="hair2" class="hair-style ae"></div>
			<div id="hair3" class="hair-style ae"></div>
			<div id="hair4" class="hair-style ae"></div>
			<div id="hair5" class="hair-style ae"></div>
			<div id="hair6" class="hair-style ae"></div>
			<div id="hair7" class="hair-style ae"></div>
			<div id="hair8" class="hair-style ae"></div>
			<div id="hair9" class="hair-style ae"></div>

			<div id="col1" class="ae"></div>
			<div id="col2" class="ae"></div>

			<div id="finalize-avatar" class="ae">
				<a class="button" href="javascript:rtn();">Lanjut</a>
			</div>
			<div id="slider" class="ae">
				<div id="pointer" class="ae ui-widget-content"></div>
			</div>
			<div id="slider2" class="ae">
				<div id="pointer2" class="ae ui-widget-content"></div>
			</div>
			<div id="slider3" class="ae">
				<div id="pointer3" class="ae ui-widget-content"></div>
			</div>
		</div>

		<div id="page5">

			<div Id="nameBg" class="ae">
				<input type="text" id="txtName"/>
				<div Id="btnClear" class="ae">
					<a class="button" href="javascript:rtn();"></a>
				</div>
			</div>
			<div id="mugshot3" class="ae mugshot">
			</div>

			<div Id="page5TxtJob" class="page5Txt ae">Pekejaan</div>
			<div id="jobBg" class="ae">
				<select id="job" class="ae" onchange="setJob();">
					<option value="Karyawan">Karyawan</option>
					<option value="Pelajar">Pelajar</option>
					<option value="Umum">Umum</option>
				</select>
				<span id="text-job">kokoko</span>
			</div>
			<div id="page5TxtCity" class="page5Txt ae">Kota</div>
			<div id="cityBg" class="ae">
				<select id="city" class="ae" onchange="setCity();">
					<option value=1>Aceh</option>
					<option value=2>Sumatra Barat</option>
					<option value=3>Padang</option>
					<option value=4>Pekanbaru</option>
					<option value=5>Jambi</option>
					<option value=6>Palembang</option>
					<option value=7>Bengkulu</option>
					<option value=8>Bandar Lampung</option>
					<option value=9>Pangkal Pinang</option>
					<option value=9>Tanjung Pinang</option>
					<option value=10>Jakarta</option>
					<option value=11>Yogyakarta</option>
					<option value=12>Bandung</option>
					<option value=13>Semarang</option>
					<option value=14>Serang</option>
					<option value=15>Surabaya</option>
					<option value=16>Denpasar</option>
					<option value=17>Kupang</option>
					<option value=18>Mataram</option>
					<option value=19>Pontianak</option>
					<option value=20>Palangka Raya</option>
					<option value=21>Banjarmasin</option>
					<option value=22>Samarinda</option>
					<option value=23>Tanjung Selor</option>
					<option value=24>Manado</option>
					<option value=25>Palu</option>
					<option value=26>Makassar</option>
					<option value=27>Kandari</option>
					<option value=28>Mamuju</option>
					<option value=27>Gorontalo</option>
					<option value=28>Ambon</option>
					<option value=29>Sofifi</option>
					<option value=30>Jayapura</option>
					<option value=31>Manokwari</option>
				</select>
				<span id='text-city'>kokoko</span>
			</div>
			<div id="page5TxtFood" class="page5Txt ae">Makanan Favorit</div>
			<div id="foodBg" class="ae">
				<select id="food" class="ae" onchange="setFood();">
					<option value="Nasi Goreng">Nasi Goreng</option>
					<option value="Bakmi Kuah">Bakmi Kuah</option>
					<option value="Sate">Sate</option>
					<option value="Bakso">Bakso</option>
					<option value="Ayam Goreng">Ayam Goreng</option>
					<option value="Nasi Padang">Nasi Padang</option>
					<option value="Soto">Soto</option>
					<option value="Gado - Gado">Gado - Gado</option>
					<option value="Pizza">Pizza</option>
					<option value="Steik">Steik</option>
					<option value="Spaghetti">Spaghetti</option>
					<option value="Lobster">Lobster</option>
				</select>
				<span id="text-food">kokoko</span>
			</div>

			<div id="finalize-movie" class="ae">
				<a class="button" href="javascript:rtn();">mulai</a>
			</div>
		</div>

		<div id="canvas1" class="ae">
			<canvas id="clayer1" class="ae" width="256" height="256"></canvas>
			<canvas id="clayer2" class="ae" width="256" height="256"></canvas>
			<canvas id="clayer3" class="ae" width="256" height="256"></canvas>
		</div>

	<!-- 	
		<div id="canvasSmall" class="ae">
			<canvas id="slayer1" class="ae" width="128" height="128"></canvas>
			<canvas id="slayer2" class="ae" width="128" height="128"></canvas>
			<canvas id="slayer3" class="ae" width="128" height="128"></canvas>
		</div>
	 -->
	</div>

	<script type="text/javascript">

		// this all for canvas

	/*
		var slayer1 = document.getElementById("slayer1");
			var sctx1 = slayer1.getContext("slayer1");
		var slayer2 = document.getElementById("slayer2");
			var sctx2 = slayer2.getContext("slayer2");
		var slayer3 = document.getElementById("slayer3");
			var sctx3 = slayer1.getContext("slayer3");
	*/

		var clayer1 = document.getElementById("clayer1");
		var ctx1 = clayer1.getContext("2d");
		var clayer2 = document.getElementById("clayer2");
		var ctx2 = clayer2.getContext("2d");
		var clayer3 = document.getElementById("clayer3");
		var ctx3 = clayer3.getContext("2d");
		
		var faceImage = new Image();
			faceImage.src = 'upload/1.jpg';
		var fHairImage = new Image();
		var fHairImageColor = new Image();
		var bodyImage = new Image();
		var bodyImageColor = new Image();
		var bHairImage = new Image();
		var bHairImageColor = new Image();

		//final draw
		function drawChara(){
			ctx1.clearRect(0,0,256,256);
			initChara();
			drawBackHair();
		    drawBody();
		    drawFrontHair();
		}
		function drawPhoto(){
			faceImage.onload = function(){
				ctx1.clearRect(0,0,256,256);
				ctx1.drawImage(faceImage,3,3,250,250);
			};
		}
		//set change of image image hasnot downloaded
		function drawBackHair(){
			if(gender==1){
			}else if(gender==2){
				if(selectedBackHair==1){
					bHairImage.src = "asset/scene2/girl/girlbackhair1.png";
				}else if(selectedBackHair==2){
					bHairImage.src = "asset/scene2/girl/girlbackhair2.png";
				}else if(selectedBackHair==3){
					bHairImage.src = "asset/scene2/girl/girlbackhair3.png";
				}else if(selectedBackHair==4){
					bHairImage.src = "asset/scene2/girl/girlbackhair4.png";
				}else if(selectedBackHair==5){
					bHairImage.src = "asset/scene2/girl/girlbackhair5.png";
				}else if(selectedBackHair==6){
					bHairImage.src = "asset/scene2/girl/girlbackhair6.png";
				}
				bHairImage.onload = function(){
					ctx1.clearRect(0,0,256,256);
					ctx1.drawImage(bHairImage,40,10,180,167); // draw back hair that will be change in color
					changeColor(40,10,180,167,0,ctx1); // change color of back hair
				};
				/*
				ctx1.drawImage(bHairImageColor,40,10,180,167); // draw back hair that will be change in color
				changeColor(40,10,180,167,0,ctx1); // change color of back hair
				ctx1.drawImage(bHairImage,40,10,180,167); // draw back hair of cover
				*/
			}
		}
		function drawBody(){
			if(gender==1){
				if(selectedBody == 1){
					bodyImageColor.src = "asset/scene2/boy/casualslim2.png";
					bodyImage.src = "asset/scene2/boy/casualslim3.png";
				}
				else if(selectedBody == 2){
					bodyImageColor.src = "asset/scene2/boy/casualmed2.png";
					bodyImage.src = "asset/scene2/boy/casualmed3.png";
				}
				else if(selectedBody == 3){
					bodyImageColor.src = "asset/scene2/boy/casualfat2.png";
					bodyImage.src = "asset/scene2/boy/casualfat3.png";
				}
			}else if(gender==2){
				if(selectedBody == 1){
					bodyImageColor.src = "asset/scene2/girl/casualslim2.png";
					bodyImage.src = "asset/scene2/girl/casualslim3.png";
				}
				else if(selectedBody == 2){
					bodyImageColor.src = "asset/scene2/girl/casualmed2.png";
					bodyImage.src = "asset/scene2/girl/casualmed3.png";
				}
				else if(selectedBody == 3){
					bodyImageColor.src = "asset/scene2/girl/casualfat2.png";
					bodyImage.src = "asset/scene2/girl/casualfat3.png";
				}
			}
			bodyImageColor.onload = function(){
				ctx2.clearRect(0,0,256,256);
				ctx2.drawImage(bodyImageColor,69,15,120,227) //draw body that will be change in color
				changeColor(69,15,120,227,1,ctx2); // change the color of image above
				drawEllipse(90,45,80,80,ctx2); // make round face image
				ctx2.drawImage(bodyImage,69,15,120,227); // make body of cover
			};
			
			faceImage.onload = function(){
				ctx2.clearRect(0,0,256,256);
				ctx2.drawImage(bodyImageColor,69,15,120,227) //draw body that will be change in color
				changeColor(69,15,120,227,1,ctx2); // change the color of image above
				drawEllipse(90,45,80,80,ctx2); // make round face image
				ctx2.drawImage(bodyImage,69,15,120,227); // make body of cover
			};
			
			bodyImage.onload = function(){
				ctx2.clearRect(0,0,256,256);
				ctx2.drawImage(bodyImageColor,69,15,120,227) //draw body that will be change in color
				changeColor(69,15,120,227,1,ctx2); // change the color of image above
				drawEllipse(90,45,80,80,ctx2); // make round face image
				ctx2.drawImage(bodyImage,69,15,120,227); // make body of cover
			};
			
			/*
			ctx2.drawImage(bodyImageColor,69,15,120,227) //draw body that will be change in color
			changeColor(69,15,120,227,1,ctx2); // change the color of image above
			drawEllipse(90,45,80,80,ctx2); // make round face image
			ctx2.drawImage(bodyImage,69,15,120,227); // make body of cover
			*/
			//ctx2.clearRect(0,0,256,256);
		}
		function drawFrontHair(){
			
			if(gender==1){
				if(selectedHair==1){
					fHairImage.src = "asset/scene2/boy/hair1.png";
				}else if(selectedHair==2){
					fHairImage.src = "asset/scene2/boy/hair2.png";
				}else if(selectedHair==3){
					fHairImage.src = "asset/scene2/boy/hair3.png";
				}else if(selectedHair==4){
					fHairImage.src = "asset/scene2/boy/hair4.png";
				}else if(selectedHair==5){
					fHairImage.src = "asset/scene2/boy/hair5.png";
				}else if(selectedHair==6){
					fHairImage.src = "asset/scene2/boy/hair6.png";
				}else if(selectedHair==7){
					fHairImage.src = "asset/scene2/boy/hair7.png";
				}else if(selectedHair==8){
					fHairImage.src = "asset/scene2/boy/hair8.png";
				}else if(selectedHair==9){
					fHairImage.src = "asset/scene2/boy/hair9.png";
				}
				
				fHairImage.onload = function(){
					ctx3.clearRect(0,0,256,256);
					ctx3.drawImage(fHairImage,60,-15,140,168); // make hair front that will be change in color
					changeColor(60,-15,140,168,0,ctx3); // change the color of the hair
				}
				
				/*
				ctx3.drawImage(fHairImageColor,60,-6,140,168); // make hair front that will be change in color
				changeColor(60,-6,140,168,0,ctx3); // change the color of the hair
				ctx3.drawImage(fHairImage,60,-6,140,168); // make front hair of cover
				*/
					

			}else if(gender==2){
				if(selectedHair==1){
					fHairImage.src = "asset/scene2/girl/girlponies1.png";
				}else if(selectedHair==2){
					fHairImage.src = "asset/scene2/girl/girlponies2.png";
				}else if(selectedHair==3){
					fHairImage.src = "asset/scene2/girl/girlponies3.png";
				}else if(selectedHair==4){
					fHairImage.src = "asset/scene2/girl/girlponies4.png";
				}else if(selectedHair==5){
					fHairImage.src = "asset/scene2/girl/girlponies5.png";
				}else if(selectedHair==6){
					fHairImage.src = "asset/scene2/girl/girlponies6.png";
				}else if(selectedHair==7){
					fHairImage.src = "asset/scene2/girl/girlponies7.png";
				}else if(selectedHair==8){
					fHairImage.src = "asset/scene2/girl/girlponies8.png";
				}else if(selectedHair==9){
					fHairImage.src = "asset/scene2/girl/girlponies9.png";
				}
				/*
				ctx3.drawImage(fHairImageColor,60,7,140,168); // make hair front that will be change in color
				changeColor(60,7,140,168,0,ctx3); // change the color of the hair
				ctx3.drawImage(fHairImage,60,7,140,168); // make front hair of cover
				*/ 
				fHairImage.onload = function(){
					ctx3.clearRect(0,0,256,256);
					ctx3.drawImage(fHairImage,60,7,140,168); // make hair front that will be change in color
					changeColor(60,7,140,168,0,ctx3); // change the color of the hair
				};
				
				//ctx3.clearRect(0,0,256,256);
			}
		}

		//change color of hair and body
		function changeColor(x,y,w,h,stat,ctx){
			var changeData = ctx.getImageData(x,y,w,h);
			var pixels = changeData.data;
			var r=0; g=0; b=0;
			var numPixel = w * h;

			if(stat==1){
				r=rB;g=gB;b=bB;
			}else{
				r=rH;g=gH;b=bH;
			}

			for(var i=0;i<numPixel; i++){
				if(pixels[i*4]>100 && pixels[i*4+1]>100 && pixels[i*4+2]>100 && pixels[i*4+3]>0){
					pixels[i*4] = r; // Red  
					pixels[i*4+1] = g; // Green  
					pixels[i*4+2] = b; // Blue  
					pixels[i*4+3] = 255; 
				}
			}
			ctx.putImageData(changeData, x, y);
		}

		//draw face in oval shape
		function drawEllipse(x,y,w,h,ctx){
			var kappa = .5522848,
			  ox = (w / 2) * kappa, // control point offset horizontal
			  oy = (h / 2) * kappa, // control point offset vertical
			  xe = x + w,           // x-end
			  ye = y + h,           // y-end
			  xm = x + w / 2,       // x-middle
			  ym = y + h / 2;       // y-middle

			ctx.save();
			ctx.beginPath();
			ctx.moveTo(x+6, ym);
			ctx.bezierCurveTo(x-10, ym - oy-10, xm - ox, y-10, xm, y-10);
			ctx.bezierCurveTo(xm + ox, y+-10, xe+8, ym - oy-10, xe-2, ym);
			ctx.bezierCurveTo(xe-8, ym +oy, xm + ox,  ye-2, xm, ye);
			ctx.bezierCurveTo(xm - ox, ye-2,x+8, ym + oy, x+2, ym);
			ctx.closePath();
			ctx.clip();
			ctx.drawImage(faceImage,x,y,w,h);
			ctx.restore();
		}

		//set first time image
		function initChara(){
			//console.log("initChara");
			if(gender == 1 ){
				fHairImage.src = "asset/scene2/boy/hair5.png";
				bodyImageColor.src = "asset/scene2/boy/casualmed2.png";
				bodyImage.src = "asset/scene2/boy/casualmed3.png";
			}else if(gender==2){	
				fHairImage.src = "asset/scene2/girl/girlponies5.png";
				bodyImageColor.src = "asset/scene2/girl/casualmed2.png";
				bodyImage.src = "asset/scene2/girl/casualmed3.png";
				bHairImage.src = "asset/scene2/girl/girlbackhair5.png";;
			}
		}

		//set change but all image downloaded
		function changeHair(){
			if(gender==1){
				ctx3.drawImage(fHairImage,60,-15,140,168); // make front hair of cover
				changeColor(60,-15,140,168,0,ctx3); // change the color of the hair
			}else if(gender==2){
				ctx1.drawImage(bHairImage,40,10,180,167); // draw back hair of cover
				changeColor(40,10,180,167,0,ctx1); // change color of back hair
				
				ctx3.drawImage(fHairImage,60,7,140,168); // make front hair of cover
				changeColor(60,7,140,168,0,ctx3); // change the color of the hair
			}
		}
		function changeBody(){
			ctx2.drawImage(bodyImageColor,69,15,120,227) //draw body that will be change in color
			changeColor(69,15,120,227,1,ctx2); // change the color of image above
			drawEllipse(90,45,80,80,ctx2); // make round face image
			ctx2.drawImage(bodyImage,69,15,120,227); // make body of cover
		}
	</script>
</body>
</html>