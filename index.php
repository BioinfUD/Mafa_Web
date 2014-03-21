<?php
require_once('config.php');
$funct=NULL;
if($_GET){
	$funct=$_GET['f'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="imagetoolbar" content="no">
	<title>MAFA</title>
	<link rel='stylesheet' type='text/css' href='styles.css' />
	<link rel="stylesheet" href="css/style.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type='text/javascript' src='menu_jquery.js'></script>
	<script src="js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      $(function(){
        $("input:checkbox, input:radio, input:file, select").uniform();
      });
    </script>
	<style>
body{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;
}
.info, .desc{
    border: 1px solid;
    border-radius:3px;
    margin: 10px 0px;
    padding: 15px 30px 15px 30px;
    background-repeat: no-repeat;
    background-position: 10px center;
}
.info{
    color: #727272;
	background-color: #DADADA;
}
.desc{
	color: #727272;
	background-color: #D9ECF8;
	text-align:left;
	max-width: 600px;
}
	</style>
</head>
<body>
<table>
	<tr>
	<td style="vertical-align: top;">
		<div id='cssmenu'>
<ul>
   <li><a href='index.php'><span>Home</span></a></li>
   <li class='has-sub'><a href='#'><span>Local Blast Server</span></a>
      <ul>
         <li class='last'><a href='index.php?f=blastexec.py.html'><span>Blast Exec</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Gene Ontology Associator</span></a>
      <ul>
         <li><a href='index.php?f=blastxml2custom.py.html'><span>XML to Custom</span></a></li>
         <li class='last'><a href='index.php?f=hits2go.py.html'><span>Hits to GO</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Gene Ontology Analyzer</span></a>
      <ul>
         <li><a href='index.php?f=godistribution.py.html'><span>GO Distribution</span></a></li>
         <li><a href='index.php?f=graphpie.py.html'><span>GraphPie</span></a></li>
         <li><a href='index.php?f=pdfgen.py.html'><span>Pdf Generator</span></a></li>
         <li class='last'><a href='index.php?f=crossedgosearch.py.html'><span>Crossed GO Search</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Database Administrator</span></a>
      <ul>
         <li class='last'><a href='index.php?f=updatedbs.py.html'><span>Update DB</span></a></li>
      </ul>
   </li>
   <li class='has-sub last'><a href='#'><span>Full Analysis</span></a>
      <ul>
         <li class='last'><a href='index.php?f=gofullanalysis.py.html'><span>GO Full Analysis</span></a></li>
      </ul>
   </li>
   <li><a href='tail.php' target='_blank'><span>tail processes</span></a></li>
</ul>
</div>
	</td>
	<td style="vertical-align: top;padding-left: 25px;border-left: solid 2px gray;">
		<div id="cont" style="text-align:justify; width:50%;" >
			
		</div>
	<?php
	
	if(!$_POST){
		if($funct){
			switch($funct){
				
				case 'blastexec.py.html':
					echo '<script>$("#cont").load("blastexec.py.html");</script>';
				break;
				case 'blastxml2custom.py.html':
					echo '<script>$("#cont").load("blastxml2custom.py.html");</script>';
				break;
				case 'hits2go.py.html':
					echo '<script>$("#cont").load("hits2go.py.html");</script>';
				break;
				case 'godistribution.py.html':
					echo '<script>$("#cont").load("godistribution.py.html");</script>';
				break;
				case 'graphpie.py.html':
					echo '<script>$("#cont").load("graphpie.py.html");</script>';
				break;
				case 'pdfgen.py.html':
					echo '<script>$("#cont").load("pdfgen.py.html");</script>';
				break;
				case 'crossedgosearch.py.html':
					echo '<script>$("#cont").load("crossedgosearch.py.html");</script>';
				break;
				case 'updatedbs.py.html':
					echo '<script>$("#cont").load("updatedbs.py.html");</script>';
				break;
				case 'gofullanalysis.py.html':
					echo '<script>$("#cont").load("gofullanalysis.py.html");</script>';
				break;
			}//endswitch()
		}else{
		echo '<script>$("#cont").load("welcome.html");</script>';
		}
	}else{
		$link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB) or die("Error " . mysqli_error($link));
		$char = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$numlet=5;
		$dir = "";
		for($i=0;$i<$numlet;$i++){
			$dir .= substr($char,rand(0,strlen($char)),1);
		}
		switch($_POST['proc']){
			case 'blastexec.py':
				print '<div class="info">Blast Exec</div><br>';
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file uploaded successfully<br>";
					}else{ 
						print "> Upload error<br>";
						print "> The process cannot be executed<br>";
						break;
					}
				}
				$db=$_POST['db'];
				if('uniprot' == $db){
					$email = $_POST['email'];
					$cmd = 'cd '.DIR_MAFA.' && python2 BlastExec.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_UNIPROT.' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.xml';
					$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
					system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
					$link->query($query);
					if($_POST['email'] && $_POST['email'] != ''){
						print 'An email will be sent to you when the process is complete.<br><br>';
					}
					print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
					print "<a href='outputs/".$dir."'><input type='button' value='Your process output' /></a><br>";
				}else{
					$cmd = 'cd '.DIR_MAFA.' && python2 BlastExec.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_REFSEQ.' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.xml';
					$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
					system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
					$link->query($query);
					if($_POST['email'] && $_POST['email'] != ''){
						print 'An email will be sent to you when the process is complete.<br><br>';
					}
					print "<a href='tail.php'></a><input type='button' value='All processes in server' /><br>";
					print "<a href='outputs/".$dir."'></a><input type='button' value='Your process output' /><br>";
				}
				
			break;
			case 'blastxml2custom.py':
				print '<div class="info">XML to Custom</div><br>';
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file uploaded successfully<br>";
					}else{ print "> Upload error<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				$cmd = 'cd '.DIR_MAFA.' && python2 Utilities/BlastXML2CSVCustom.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.csv';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				system($cmd);
				print "<a href='outputs/".$dir."/".$_FILES["file"]["name"].".csv'><input type='button' value='CVS file' /></a><br>";
			break;
			case 'hits2go.py':
			print '<div class="info">Hits to Go</div><br>';
				$name=$_POST['outputname'];
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file uploaded successfully<br>";
					}else{ print "> Upload error<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				$cmd = 'cd '.DIR_MAFA.' && python2 Hits2Go.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$name.'.csv';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				system($cmd);
				print "<br><a href='outputs/".$dir."/".$name.".csv'><input type='button' value='CVS file' /></a><br>";
			break;
			case 'godistribution.py':
			print '<div class="info">GO Distribution</div><br>';
				$name=$_POST['outputname'];
				$name2=$_POST['outputname'];
				$category=$_POST['category'];
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file uploaded successfully<br>";
					}else{ print "> Upload error<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				//print 'python2 '.DIR_MAFA.'/GoDistribution.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_MAFA.'/Data/'.$category.' '.DIR_OUTPUTS.'/'.$name.'.tab '.DIR_OUTPUTS.'/'.$name2.'.csv';
				print '<br><pre>';
				system('cd '.DIR_MAFA.' && python2 GoDistribution.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_MAFA.'/Data/'.$category.' '.DIR_OUTPUTS.'/'.$name.'.tab '.DIR_OUTPUTS.'/'.$name2.'.csv',$ret);
				//print '<br>RETORNO...: '.$ret;
				print '<br></pre>';
				print "<br><a href='outputs/".$name.".tab' target='_blank'><input type='button' value='TAB file' /></a><br>";
				print "<br><a href='outputs/".$name2.".csv' target='_blank'><input type='button' value='CVS file' /></a><br>";
			break;
			case 'graphpie.py':
			print '<div class="info">Graph Pie</div><br>';
				$name=$_POST['outputname'];
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file uploaded successfully<br>";
					}else{ print "> Upload error";
						print "> The process cannot be executed<br>";
						break; }
				}
				
				//print 'cd '.DIR_MAFA.' && python2 Utilities/GraphPie.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$name.'.png';
				system('cd '.DIR_MAFA.' && python2 Utilities/GraphPie.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$name.'.png',$ret);
				//print "<br>RETURN: ".$ret;
				print "<br><br><img src='outputs/".$name.".png'/>";
			break;
			case 'pdfgen.py':
			print '<div class="info">Pdf Generator</div><br>';
				$name=$_POST['outputname'];
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> file 1 uploaded successfully<br>";
					}else{ print "> Upload error in file 1<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				if ($_FILES["imgfile"]["error"] > 0){
					echo "Error: " . $_FILES["imgfile"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["imgfile"]["tmp_name"],"uploads/" . $_FILES["imgfile"]["name"])){
						print "> file 2 uploaded successfully";
					}else{ print "> Upload error in file 2<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				print '<br><pre>';
				//print 'cd '.DIR_MAFA.' && python2 Utilities/PdfGen.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$name.'.pdf '.DIR_UPLOADS.'/'.$_FILES["imgfile"]["name"];
				system('cd '.DIR_MAFA.' && python2 Utilities/PdfGen.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$name.'.pdf '.DIR_UPLOADS.'/'.$_FILES["imgfile"]["name"],$ret);
				//print '<br>RETORNO: '.$ret;
				print '<br></pre>';
				print "<br><a href='outputs/".$name.".pdf' target='_blank'><input type='button' value='PDF file' /></a><br>";
			break;
			case 'crossedgosearch.py':
			print '<div class="info">Crossed GO Search</div><br>';
				$category=$_POST['category'];
				if ($_FILES["file"]["error"] > 0){
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}else{
					if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
						print "> File uploaded successfully<br>";
					}else{ print "Upload error<br>";
						print "> The process cannot be executed<br>";
						break; }
				}
				print '<br><pre>';
				//print 'cd '.DIR_MAFA.' && python2 CrossedGOSearch.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.$category;
				system('cd '.DIR_MAFA.' && python2 CrossedGOSearch.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.$category,$ret);
				//print "<br>RETURN: ".$ret; 
				print '<br></pre>';
			break;
			case 'updatedbs.py':
			print '<div class="info">Update Data Bases</div>';
				$email = $_POST['email'];
				$cmd = 'cd '.DIR_MAFA.' && python2 UpdateDBs.py';
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				$link->query($query);
				print '> Your process is in queue.';
				if($_POST['email'] && $_POST['email'] != ''){
					print '> An email will be sent to you when the process is complete.<br><br>';
				}
			break;
			case 'gofullanalysis.py':
			print '<div class="info">GO Full Analysis</div>';
				if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
				$db=$_POST['db'];
				$email = $_POST['email'];
				$category=$_POST['category'];
				$cmd = 'cd '.DIR_MAFA.' && python2 GoFullAnalysis.py '.DIR_UPLOADS.'/'.$_FILES["file"]["name"].' '.DIR_MAFA.'/Data/'.$category.' '.DIR_OUTPUTS.'/'.$dir.' '.$db;
				//print $cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				$link->query($query);
				print '> Your process is in queue.<br>';
				if($_POST['email'] && $_POST['email'] != ''){
					print '> An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
				print "<a href='outputs/".$dir."'><input type='button' value='Your process output' /></a><br>";
			break;
		}//endswitch()		
	}//endifelse()
	
	?>
	</td>
	</tr>
</table>
</body>
</html>
