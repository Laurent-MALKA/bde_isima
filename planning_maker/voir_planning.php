<?php
include("inc/bdd.php");
include "inc/head.php";


?>

	<?php
		
			echo "<br />";
			function dispo($day, $bdd){
				$creneaux = $bdd->query("SELECT * FROM creneaux WHERE c_jour=".$day." ORDER BY c_deb");
				foreach($creneaux as $c){
					$dispo=False;
					$d = $bdd->query("SELECT membres.m_nom FROM planning_def, membres WHERE (planning_def.m_id=membres.m_id OR planning_def.m2_id=membres.m_id) AND c_id=".$c['c_id']."");
					$aaa=0;
					foreach($d as $i){
						if($aaa==0)echo "<br /><label for='dispo_".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</label>";
						echo $i['m_nom']." ";
						$aaa++;
					}
				}
			}
//echo "<table style='width:100%;'><tr>";
//			echo "<td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td></tr><tr>";
			
			for($i=0;$i<7;$i++){				
				echo "<div style='width:100%; max-width:300px;height:300px;margin:32px; padding:16px; float:left;box-shadow:2px 2px 5px grey'>";
				echo "<strong>".$jours[$i]."</strong>";
				dispo($i, $bdd);
				echo "</div>";	
			}
			
			?>
<strong>Poubelles:</strong>		
<br />Noire: Lundi & Jeudi
<br />Jaune: Mercredi	
			<?php
		
	?>
		
