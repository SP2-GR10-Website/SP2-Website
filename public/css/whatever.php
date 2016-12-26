<?php


namespace App\Http\Controllers;
define("main", true);
ini_set("allow_url_fopen", true);
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Station;

class InfoController extends Controller {
	public function getRouteInfo(Request $request){
		$data="";
		$stepOn = $request->stepOn;
		$stepOff = $request->stepOff;
		$date = $request->treinTijd;
		$date.=" GMT";
		$timestamp = strtotime($date);
		$url = sprintf("https://traintracks.online/api/Route/%s/%s/%s", $stepOn, $stepOff,$timestamp);
		$result = json_decode(file_get_contents($url));
		$data.="Jouw verbindingen: ". $result->StepOn." - ".$result->StepOff;
		foreach($result->Routes as $route)
			{
				
			$data.="<ul>";
				
				$data.="<li><b>Van: </b>".$result->StepOn."<br /><b>Naar: </b>".$result->StepOff."</li>";
				
				$data.="<ul>";
			foreach($route->TransferStations as $ts)
				{
					$data.="<li>";
					
					$data.="<b>".$ts->FullId."</b> Richting ".$ts->TerminusStation;
					if(strlen($ts->FullId)>=7)
					{
						$fullId = substr($ts->FullId, -5);
					}
					else {$fullId = substr($ts->FullId, -4);
					}
				$url2 = sprintf("https://traintracks.online/api/train/%s", $fullId);
				$resultTrein = json_decode(file_get_contents($url2));  
							
					if($ts->TransferAt != null)
					$data.=" (Overstap te ".$ts->TransferAt.")";
					$data.="<br />";
					
					if($ts->ArrivalPlatform != null)
					$plaatsStation = 0;
					$countArray = $resultTrein->Stops->Count;
		for($i = 0;$i<$countArray;$i++)
		{
			$station = $resultTrein->Stops->Stations[$i]->Name;
			if($ts->TransferAt != null)
			{
				$name = $ts->TransferAt;
			}
			else 
			{
				$name = $result ->StepOn;
			}
			if($pos = strpos($station, $name) !== false )
			{
			$plaatsStation = $i;
			}
		}
			
			$echtVertrek = $resultTrein->Stops->Stations[$plaatsStation]->Time->ActualDeparture;
			$geplandVertrek = $resultTrein->Stops->Stations[$plaatsStation]->Time->Departure;
			$geplandAankomen = $resultTrein->Stops->Stations[$plaatsStation]->Time->Arrival;
			$echtAankomen=$resultTrein->Stops->Stations[$plaatsStation]->Time->ActualArrival;
			$lengthGeplandVertrek = strlen($geplandVertrek);
			$lengthEchtAankomen = strlen($echtAankomen);
			$lengthEchtVertrek = strlen($echtVertrek);
			$lengthGeplandAankomen = strlen($geplandAankomen);
			$vertrekMinuut1 = substr($geplandVertrek, 14,2);
			$vertrekMinuut2 = substr($echtVertrek, 14,2);
			$vertrekUur1 = substr($geplandVertrek, 11,2);
			$vertrekUur2 = substr($echtVertrek, 11,2);
			$delayMinutenVertrek = $vertrekMinuut2 - $vertrekMinuut1;
			$delayUrenVertrek = $vertrekUur2 - $vertrekUur1;
			$echoUrenVertrek = "";
			$echoMinuutVertrek = "";
			$aankomstMinuut1 = substr($geplandVertrek, 14,2);
			$aankomstMinuut2 = substr($echtVertrek, 14,2);
			$aankomstUur1 = substr($geplandVertrek, 11,2);
			$aankomstUur2 = substr($echtVertrek, 11,2);
			$delayMinutenAankomst = $aankomstMinuut2 - $aankomstMinuut1;
			$delayUrenAankomst = $aankomstUur2 - $aankomstUur1;
			$echoUrenAankomst = "";
			$echoMinuutAankomst = "";
			$data = $data . "<table class='testTable'>";
		if($lengthGeplandAankomen != $lengthEchtAankomen)
			{
				$delayUrenAankomst = 0;
				$delayMinutenAankomst = 0;
			}
				if($lengthEchtVertrek != $lengthGeplandVertrek)
			{
				$delayMinutenVertrek = 0;
				$delayUrenVertrek = 0;
			}
		if($delayUrenAankomst != 0)
		{
				$echoUrenAankomst.=$delayUrenAankomst;
				 $echoUrenAankomst.=" uur/uren ";
			if($delayMinutenAankomst != 0)
				 { 
				 			$echoUrenAankomst.=" + ";
				 			$echoUrenAankomst.=$delayUrenAankomst;
				 			$echoUrenAankomst.=" minuten vertraging.";
				 			
					if($plaatsStation == 0)
				 		 {
				 		 	$data.= "<tr class='testTr'>";
							$data=$data . "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'> Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
				 		 }
				 	else{
				 			$data.= "<tr class='testTr'>";
						$data.= "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'> Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
						$data = $data . "<td class='testTd'>Tijdstip van aankomst: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Arrival ." + ".$echoUrenAankomst ."</td>";
				 		}
				 }
		}
		else {
				if($delayMinutenAankomst != 0)
				 { 
				 			$echoMinuutAankomst.=$delayMinutenAankomst;
				 			$echoMinuutAankomst.=" minuten vertraging.";
				 	if($plaatsStation==0)
				 		 {
				 		 	$data.= "<tr class='testTr'>";
						$data.= "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'> Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
			
				 		 }
				 	else{
				 	
				 		$data.= "<tr class='testTr'>";
						$data.= "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'> Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
						$data = $data . "<td class='testTd'>Tijdstip van aankomst: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Arrival ." + ".$echoMinuutAankomst ."</td>";
				 		}
				 	}
				else {
					if($plaatsStation==0)
				 		 {
				 		 $data.= "<tr class='testTr'>";
						$data.= "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'> Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
				 }	
				 else{
				 	$data.= "<tr class='testTr'>";
						$data.= "<th class='testTh'>Halte: ".$resultTrein->Stops->Stations[$plaatsStation]->Name."</th>";
						$data = $data . "<td class='testTd'>Perron : " . $resultTrein->Stops->Stations[$plaatsStation]->DeparturePlatform . "</td>";
						$data = $data . "<td class='testTd'>Tijdstip van aankomst: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Arrival ."</td>";
				 		}
				 }
				 }
		if($delayUrenVertrek != 0)
		{
				 		$echoUrenVertrek.=$delayUrenVertrek;
				 		$echoUrenVertrek.=" uur/uren ";
			if($delayMinutenVertrek != 0)
				{ 
				 			$echoUrenVertrek.="+";
				 			$echoUrenVertrek.=$delayMinutenVertrek;
				 			$echoUrenVertrek.=" minuten ";
				 		 	$echoUrenVertrek.="vertraging.";
				if($i != ($countArray - 1))
				 {
					$data = $data . "<td class='testTd'>Tijdstip van vertrek: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Departure . " + ".$echoUrenVertrek."</td>";
						$data = $data . "</tr>";
				 		 }
				 else{
				 		$data.="<td class='testTd'>";
				 		$data.="Eindstation.";
				 		$data.="</td>";
				 		$data = $data . "</tr>";
						}
				}
		}
		else
			{
				if($delayMinutenVertrek != 0)
				{
				 		 
				 			$echoMinuutVertrek.=$delayMinutenVertrek;
				 			$echoMinuutVertrek.=" minuten vertraging.";
				 	if($i != ($countArray -1))
				 		 {
					 $data = $data . "<td class='testTd'>Tijdstip van vertrek: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Departure . " + ".$echoMinuutVertrek."</td>";
						$data = $data . "</tr>";
						$data.="<br>";
				 		 }
				 	else{
				 		
				 		$data.="<td class='testTd'>";
				 		$data.="Eindstation.";
				 		$data.="</td>";
				 		$data = $data . "</tr>";
				 		$data.="</br>";
				 		}
				}
				else
				{
					if($i != ($countArray -1))
				 		 {
				 		 	 $data = $data . "<td class='testTd'>Tijdstip van vertrek: " . $resultTrein->Stops->Stations[$plaatsStation]->Time->Departure."</td>";
						$data = $data . "</tr>";
						$data.="<br>";
						 }	
				 else{
				 		$data.="<td class='testTd'>";
				 	 	$data.="Eindstation.";
				 	 	$data.="</td>";
				 		$data = $data . "</tr>";
				 		$data.="</br>";
				 }
				 
			}
			$data.="</table></li>";	
		}		
		}
		}	
		$data.= ("</br>");
		$data.= ("</li>");
		$data.= ("</ul>");
		return $data;
	}

public function getTreinInfo(Request $request){
		$treinId = $request->treinId;
		$url2 = sprintf("https://traintracks.online/api/train/%s", $treinId);
		$treinJSON = json_decode(file_get_contents($url2));

		$data = 
		'<div class="trein">
			<div class="treinInfo">
				<div class="infodeel">
					<info class="nummerContainer">
						<info class="nummer">' . $treinId . '</info>
					</info>
					<div class="begin-eind">
		            	<info class="begin">' . explode('/', $treinJSON->DepartureStation)[0] . '</info><br>
		            	<div class="glyphicon glyphicon-arrow-down pijltje"></div><br>
		            	<info class="eind">' .  explode('/', $treinJSON->TerminusStation)[0] . '</info>
	          		</div>
          		</div>';

		for($i = 0 ; $i < $treinJSON->Stops->Count ; $i++){
			$halte = $treinJSON->Stops->Stations[$i];

			$echtVertrek = $halte->Time->ActualDeparture;
			$geplandVertrek = $halte->Time->Departure;
			$geplandAankomen = $halte->Time->Arrival;
			$echtAankomen= $halte->Time->ActualArrival;


			$vertrekMinuut1 = substr($geplandVertrek, 14,2);
			$vertrekMinuut2 = substr($echtVertrek, 14,2);
			$vertrekUur1 = substr($geplandVertrek, 11,2);
			$vertrekUur2 = substr($echtVertrek, 11,2);


			$aankomstMinuut1 = substr($geplandAankomen, 14,2);
			$aankomstMinuut2 = substr($echtAankomen, 14,2);
			$aankomstUur1 = substr($geplandAankomen, 11,2);
			$aankomstUur2 = substr($echtAankomen, 11,2);

			$stationNaam = explode('/', $halte->Name)[0];
			$aankomstPerron = $halte->ArrivalPlatform;
			$vertrekPerron = $halte->DeparturePlatform;

			if($i == 0){
				
				$data .=
				'<div class="stationdeel">
	              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
	              <div class="perron"><info>Perron ' . $vertrekPerron . '</info></div>
	              <div class="aankomstTijd"><info>';

	              if($aankomstUur1 != "00" || $aankomstMinuut1 != "00"){
	             		$data .= 'Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1;
             	}
	              $data .= '</info></div><div class="vertrekTijd"><info>Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1 . '</info></div>
	            </div></div>';
 		    }
		 	else if ($i == 1){
		 		$data .= '<div class="treinStationsCont" id="' . str_replace(' ', '-', $treinId) . 'stations">
	            <div class="treinStations">
	            <div class="treinStation">
	              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
	              <div class="perron"><info>Perron ' . $aankomstPerron . '</info></div>
	              <div class="aankomstTijd"><info>Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1 . '</info></div><div class="vertrekTijd"><info>';
	             
	             if($vertrekUur1 != "00" || $vertrekMinuut1 != "00"){
	             	$data .= 'Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1;
	             }
	             $data .= '</info></div></div>';
	        }
	        else{
	 			$data .=
				'<div class="treinStation">
	              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
	              <div class="perron"><info>Perron ' . $aankomstPerron . '</info></div>
	              <div class="aankomstTijd"><info>Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1 . '</info></div><div class="vertrekTijd"><info>';
	             
	             if($vertrekUur1 != "00" || $vertrekMinuut1 != "00"){
	             	$data .= 'Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1;
	             }
	             $data .= '</info></div></div>';
	        }
			
		}
		$data.= '</div></div></div>';
		return $data;
	}

	public function getStationInfo(Request $request){


		$aantalStationRequests = $request->input('aantalStationRequests');
		$name = $request->input('name');
		$date = htmlspecialchars($request->input('treinTijd')) . " GMT";
		$data = "";
		

		$timestamp = strtotime($date);
		$url = sprintf("https://traintracks.online/api/stationBoard/%s/%s", $name,$timestamp);
	 	$treinen = json_decode(file_get_contents($url));

		$begin = 5*$aantalStationRequests;
		$einde = $begin + 5;
		$l = $begin;

		//aantal treinen loop
		while($l < $einde && $l < count($treinen)){
			$treinId = $treinen[$l]->FullId;
			$url2 = sprintf("https://traintracks.online/api/train/%s", $treinen[$l]->Number);
			$trein = json_decode(file_get_contents($url2));

			$data .= 
			'<div class="trein">
				<div class="treinInfo">
					<div class="infodeel">
						<info class="nummerContainer">
							<info class="nummer">' . $treinId . '</info>
						</info>
						<div class="begin-eind">
			            	<info class="begin">' . explode('/', $trein->DepartureStation)[0] . '</info><br>
			            	<div class="glyphicon glyphicon-arrow-down pijltje"></div><br>
			            	<info class="eind">' .  explode('/', $trein->TerminusStation)[0] . '</info>
		          		</div>
	          		</div>';

			$countArray =$trein->Stops->Count;

			//plaats bepalen van beginstation
			$i = 0;
			$plaatsStation = -1;
			while($plaatsStation == -1){
				$halte = $trein->Stops->Stations[$i]->Name;
				if($pos = strpos($halte, $name) !== false )
					$plaatsStation = $i;
				$i++;
			}

			for($i = $plaatsStation ; $i < $countArray ; $i++){
				$echtVertrek = $trein->Stops->Stations[$i]->Time->ActualDeparture;
				$geplandVertrek = $trein->Stops->Stations[$i]->Time->Departure;
				$geplandAankomen = $trein->Stops->Stations[$i]->Time->Arrival;
				$echtAankomen= $trein->Stops->Stations[$i]->Time->ActualArrival;


				$vertrekMinuut1 = substr($geplandVertrek, 14,2);
				$vertrekMinuut2 = substr($echtVertrek, 14,2);
				$vertrekUur1 = substr($geplandVertrek, 11,2);
				$vertrekUur2 = substr($echtVertrek, 11,2);


				$aankomstMinuut1 = substr($geplandAankomen, 14,2);
				$aankomstMinuut2 = substr($echtAankomen, 14,2);
				$aankomstUur1 = substr($geplandAankomen, 11,2);
				$aankomstUur2 = substr($echtAankomen, 11,2);

				$stationNaam = explode('/', $trein->Stops->Stations[$i]->Name)[0];
				$aankomstPerron = $trein->Stops->Stations[$i]->ArrivalPlatform;
				$vertrekPerron = $trein->Stops->Stations[$i]->DeparturePlatform;

				if($i == $plaatsStation){
					
					$data .=
					'<div class="stationdeel">
		              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
		              <div class="perron"><info>Perron ' . $vertrekPerron . '</info></div>
		              <div class="aankomstTijd"><info>';

		              if($aankomstUur1 != "00" || $aankomstMinuut1 != "00"){
		             		$data .= 'Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1;
	             	}
		              $data .= '</info></div><div class="vertrekTijd"><info>Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1 . '</info></div>
		              <div id="' . str_replace(' ', '-', $treinId). '" class="meerStations"><div class="meerStationsIMG"></div></div>
		            </div></div>';
	 		    }
			 	else if ($i == $plaatsStation + 1){
			 		$data .= '<div class="treinStationsCont" id="' . str_replace(' ', '-', $treinId) . 'stations">
		            <div class="treinStations">
		            <div class="treinStation">
		              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
		              <div class="perron"><info>Perron ' . $aankomstPerron . '</info></div>
		              <div class="aankomstTijd"><info>Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1 . '</info></div><div class="vertrekTijd"><info>';
		             
		             if($vertrekUur1 != "00" || $vertrekMinuut1 != "00"){
		             	$data .= 'Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1;
		             }
		             $data .= '</info></div></div>';
		        }
		        else{
		 			$data .=
					'<div class="treinStation">
		              <div class="tussenhalte"><info>' . $stationNaam . '</info></div>
		              <div class="perron"><info>Perron ' . $aankomstPerron . '</info></div>
		              <div class="aankomstTijd"><info>Aankomst<br>' . $aankomstUur1 . 'u' . $aankomstMinuut1 . '</info></div><div class="vertrekTijd"><info>';
		             
		             if($vertrekUur1 != "00" || $vertrekMinuut1 != "00"){
		             	$data .= 'Vertrek<br>' . $vertrekUur1 . 'u' . $vertrekMinuut1;
		             }
		             $data .= '</info></div></div>';
		        }
				
			}
			$data.= '</div></div></div>';
			$l++;
		}
		return $data;
	}
	public function autofillStation(){
		$stations = Station::where('active', '1')->get();
		$stationArray=[];
		foreach ($stations as $station) {
			array_push($stationArray,$station->naam);
		}
		return $stationArray;
	}
}