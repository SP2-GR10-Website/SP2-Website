<?php


namespace App\Http\Controllers;
define("main", true);
ini_set("allow_url_fopen", true);
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Station;

class InfoController extends Controller {
	public function getRouteInfo(Request $request)
	{
		$data = "";
		$stepOn = $request->stepOn;
		$stepOff = $request->stepOff;
		$date = $request->treinTijd;
		$date.= " GMT";
		$timestamp = strtotime($date);
		$url = sprintf("https://traintracks.online/api/Route/%s/%s/%s", $stepOn, $stepOff, $timestamp);
		$result = json_decode(file_get_contents($url));
		$infoRoute = [];
		$countRoutes = count($result->Routes);
		foreach($result->Routes as $route) {
			$overstappen = [];
			$OverstappenCounter = count($route->TransferStations);
			$k = 0;
			foreach($route->TransferStations as $ts) {
				$FullId = "";
				$overstap = [];
				if (strlen($ts->FullId) >= 7) {
					$FullId = $ts->FullId;
					$fullId = substr($ts->FullId, -5);
				}
				else {
					$fullId = substr($ts->FullId, -4);
					$FullId = $ts->FullId;
				}

				$url2 = sprintf("https://traintracks.online/api/train/%s", $fullId);
				$resultTrein = json_decode(file_get_contents($url2));
				array_push($overstap, $FullId);
				if ($ts->TransferAt != null)
				if ($ts->ArrivalPlatform != null) $plaatsStation = 0;
				$countArray = $resultTrein->Stops->Count;
				$StationsNaam = "";
				for ($i = 0; $i < $countArray; $i++) {
					$station = $resultTrein->Stops->Stations[$i]->Name;
					if ($ts->TransferAt != null) {
						$name = $ts->TransferAt;
						$stationsNaam = $name;
					}
					else {
						$name = $result->StepOn;
						$stationsNaam = $name;
					}

					if ($pos = strpos($station, $name) !== false) {
						$plaatsStation = $i;
					}
				}

				array_push($overstap, $name);
				$halte = $resultTrein->Stops->Stations[$plaatsStation];
				$echtVertrek = $halte->Time->ActualDeparture;
				$geplandVertrek = $halte->Time->Departure;
				$geplandAankomen = $halte->Time->Arrival;
				$echtAankomen = $halte->Time->ActualArrival;
				$lengthGeplandVertrek = strlen($geplandVertrek);
				$lengthEchtAankomen = strlen($echtAankomen);
				$lengthEchtVertrek = strlen($echtVertrek);
				$lengthGeplandAankomen = strlen($geplandAankomen);
				$vertrekMinuut1 = substr($geplandVertrek, 14, 2);
				$vertrekMinuut2 = substr($echtVertrek, 14, 2);
				$vertrekUur1 = substr($geplandVertrek, 11, 2);
				$vertrekUur2 = substr($echtVertrek, 11, 2);
				$delayMinutenVertrek = $vertrekMinuut2 - $vertrekMinuut1;
				$delayUrenVertrek = $vertrekUur2 - $vertrekUur1;
				$echoUrenVertrek = "";
				$echoMinuutVertrek = "";
				$aankomstMinuut1 = substr($geplandVertrek, 14, 2);
				$aankomstMinuut2 = substr($echtVertrek, 14, 2);
				$aankomstUur1 = substr($geplandVertrek, 11, 2);
				$aankomstUur2 = substr($echtVertrek, 11, 2);
				$delayMinutenAankomst = $aankomstMinuut2 - $aankomstMinuut1;
				$delayUrenAankomst = $aankomstUur2 - $aankomstUur1;
				$echoUrenAankomst = "";
				$echoMinuutAankomst = "";
				if ($lengthGeplandAankomen != $lengthEchtAankomen) {
					$delayUrenAankomst = 0;
					$delayMinutenAankomst = 0;
				}

				if ($lengthEchtVertrek != $lengthGeplandVertrek) {
					$delayMinutenVertrek = 0;
					$delayUrenVertrek = 0;
				}

				if ($delayUrenAankomst != 0) {
					$echoUrenAankomst.= $delayUrenAankomst;
					$echoUrenAankomst.= " uur/uren ";
					if ($delayMinutenAankomst != 0) {
						$echoUrenAankomst.= " + ";
						$echoUrenAankomst.= $delayUrenAankomst;
						$echoUrenAankomst.= " minuten vertraging.";
						if ($plaatsStation == 0) {
							array_push($overstap, $halte->DeparturePlatform);
						}
						else {
							array_push($overstap, $halte->DeparturePlatform);
							array_push($overstap, $halte->Time->Arrival . " + " . $echoUrenAankomst);
						}
					}
				}
				else {
					if ($delayMinutenAankomst != 0) {
						$echoMinuutAankomst.= $delayMinutenAankomst;
						$echoMinuutAankomst.= " minuten vertraging.";
						if ($plaatsStation == 0) {
							array_push($overstap, $halte->DeparturePlatform);
						}
						else {
							array_push($overstap, $halte->DeparturePlatform);
							array_push($overstap, $halte->Time->Arrival . " + " . $echoMinuutAankomst);
						}
					}
					else {
						if ($plaatsStation == 0) {
							array_push($overstap, $halte->DeparturePlatform);
						}
						else array_push($overstap, $halte->DeparturePlatform);
						array_push($overstap, $halte->Time->Arrival);
					}
				}

				if ($delayUrenVertrek != 0) {
					$echoUrenVertrek.= $delayUrenVertrek;
					$echoUrenVertrek.= " uur/uren ";
					if ($delayMinutenVertrek != 0) {
						$echoUrenVertrek.= "+";
						$echoUrenVertrek.= $delayMinutenVertrek;
						$echoUrenVertrek.= " minuten ";
						$echoUrenVertrek.= "vertraging.";
						if ($i != ($countArray - 1)) {
							array_push($overstap, $halte->Time->Departure . " + " . $echoUrenVertrek);
						}
						else {
							array_push($overstap, "Eindstation.");
						}
					}
				}
				else {
					if ($delayMinutenVertrek != 0) {
						$echoMinuutVertrek.= $delayMinutenVertrek;
						$echoMinuutVertrek.= " minuten vertraging.";
						if ($i != ($countArray - 1)) {
							array_push($overstap, $halte->Time->Departure . " + " . $echoMinuutVertrek);
						}
						else {
							array_push($overstap, "Eindstation.");
						}
					}
					else {
						if ($i != ($countArray - 1)) {
							array_push($overstap, $halte->Time->Departure);
						}
						else {
							array_push($overstap, "Eindstation.");
						}
					}
				}

				array_push($overstappen, $overstap);
				$k++;
				if ($k == $OverstappenCounter) {
					$overstap = [];
					$FullId = "";
					if (strlen($ts->FullId) >= 7) {
						$FullId = $ts->FullId;
						$fullId = substr($ts->FullId, -5);
					}
					else {
						$FullId = $ts->FullId;
						$fullId = substr($ts->FullId, -4);
					}

					$url2 = sprintf("https://traintracks.online/api/train/%s", $fullId);
					$resultTrein = json_decode(file_get_contents($url2));
					array_push($overstap, $FullId);
					$plaatsStation = 0;
					if ($ts->TransferAt != null)
					if ($ts->ArrivalPlatform != null) $countArray = $resultTrein->Stops->Count;
					$StationsNaam = "";
					for ($i = 0; $i < $countArray; $i++) {
						$station = $resultTrein->Stops->Stations[$i]->Name;
						$name = $result->StepOff;
					}

					if ($pos = strpos($station, $name) !== false) {
						$plaatsStation = $i;
					}

					$stationsNaam = $name;
					array_push($overstap, $name);
					$halte = $resultTrein->Stops->Stations[$plaatsStation - 1];
					$echtVertrek = $halte->Time->ActualDeparture;
					$geplandVertrek = $halte->Time->Departure;
					$geplandAankomen = $halte->Time->Arrival;
					$echtAankomen = $halte->Time->ActualArrival;
					$lengthGeplandVertrek = strlen($geplandVertrek);
					$lengthEchtAankomen = strlen($echtAankomen);
					$lengthEchtVertrek = strlen($echtVertrek);
					$lengthGeplandAankomen = strlen($geplandAankomen);
					$vertrekMinuut1 = substr($geplandVertrek, 14, 2);
					$vertrekMinuut2 = substr($echtVertrek, 14, 2);
					$vertrekUur1 = substr($geplandVertrek, 11, 2);
					$vertrekUur2 = substr($echtVertrek, 11, 2);
					$delayMinutenVertrek = $vertrekMinuut2 - $vertrekMinuut1;
					$delayUrenVertrek = $vertrekUur2 - $vertrekUur1;
					$echoUrenVertrek = "";
					$echoMinuutVertrek = "";
					$aankomstMinuut1 = substr($geplandVertrek, 14, 2);
					$aankomstMinuut2 = substr($echtVertrek, 14, 2);
					$aankomstUur1 = substr($geplandVertrek, 11, 2);
					$aankomstUur2 = substr($echtVertrek, 11, 2);
					$delayMinutenAankomst = $aankomstMinuut2 - $aankomstMinuut1;
					$delayUrenAankomst = $aankomstUur2 - $aankomstUur1;
					$echoUrenAankomst = "";
					$echoMinuutAankomst = "";
					if ($lengthGeplandAankomen != $lengthEchtAankomen) {
						$delayUrenAankomst = 0;
						$delayMinutenAankomst = 0;
					}

					if ($lengthEchtVertrek != $lengthGeplandVertrek) {
						$delayMinutenVertrek = 0;
						$delayUrenVertrek = 0;
					}

					if ($delayUrenAankomst != 0) {
						$echoUrenAankomst.= $delayUrenAankomst;
						$echoUrenAankomst.= " uur/uren ";
						if ($delayMinutenAankomst != 0) {
							$echoUrenAankomst.= " + ";
							$echoUrenAankomst.= $delayUrenAankomst;
							$echoUrenAankomst.= " minuten vertraging.";
							if ($plaatsStation == 0) {
								array_push($overstap, $halte->ArrivalPlatform);
							}
							else {
								array_push($overstap, $halte->ArrivalPlatform);
								array_push($overstap, $halte->Time->Arrival . " + " . $echoUrenAankomst);
							}
						}
					}
					else {
						if ($delayMinutenAankomst != 0) {
							$echoMinuutAankomst.= $delayMinutenAankomst;
							$echoMinuutAankomst.= " minuten vertraging.";
							if ($plaatsStation == 0) {
								array_push($overstap, $halte->ArrivalPlatform);
							}
							else {
								array_push($overstap, $halte->ArrivalPlatform);
								array_push($overstap, $halte->Time->Arrival . " + " . $echoMinuutAankomst);
							}
						}
						else {
							if ($plaatsStation == 0) {
								array_push($overstap, $halte->ArrivalPlatform);
							}
							else array_push($overstap, $halte->ArrivalPlatform);
							array_push($overstap, $halte->Time->Arrival);
						}
					}

					if ($delayUrenVertrek != 0) {
						$echoUrenVertrek.= $delayUrenVertrek;
						$echoUrenVertrek.= " uur/uren ";
						if ($delayMinutenVertrek != 0) {
							$echoUrenVertrek.= "+";
							$echoUrenVertrek.= $delayMinutenVertrek;
							$echoUrenVertrek.= " minuten ";
							$echoUrenVertrek.= "vertraging.";
							if (($plaatsStation - 1) != ($countArray - 1)) {
								array_push($overstap, $halte->Time->Departure . " + " . $echoUrenVertrek);
							}
							else {
								array_push($overstap, "Eindstation.");
							}
						}
					}
					else {
						if ($delayMinutenVertrek != 0) {
							$echoMinuutVertrek.= $delayMinutenVertrek;
							$echoMinuutVertrek.= " minuten vertraging.";
							if ($i != ($countArray - 1)) {
								array_push($overstap, $halte->Time->Departure . " + " . $echoMinuutVertrek);
							}
							else {
								array_push($overstap, "Eindstation.");
							}
						}
						else {
							if ($i != ($countArray - 1)) {
								array_push($overstap, $halte->Time->Departure);
							}
							else {
								array_push($overstap, "Eindstation.");
							}
						}
					}

					array_push($overstappen, $overstap);
				}
			}

			array_push($infoRoute, $overstappen);
		}

		$data = '<div id="routeCont">';
		$countArrayInfoRoute = count($infoRoute);
		$i = 0;
		$j = 0;
		do {
			$countArrayOverstappen = count($infoRoute[$i]);
			$data.= ' <div class="route"><div class="routeInfo">
	              <div class="routeInfo-vertrek">' . $infoRoute[$i][0][1] . '</div>
	              <div class="routeInfo-vertrek-info">
	                <div>Uur: ' . $infoRoute[$i][0][4] . '</div>
	                <div>Perron: ' . $infoRoute[$i][0][2] . '</div>
	              </div>
	              <div class="routeInfo-pijltje"></div>
	              <div class="routeInfo-aankomst">' . $infoRoute[$i][$countArrayOverstappen - 1][1] . '</div>
	              <div class="routeInfo-aankomst-info">
	                <div>Uur: ' . $infoRoute[$i][$countArrayOverstappen - 1][3] . '</div>
	                <div>Perron: ' . $infoRoute[$i][$countArrayOverstappen - 1][2] . ' </div>
	              </div>
	              <div class="routeInfo-duration">Duur<br />2:13:51</div>
	              <div class="routeInfo-overstappen">Overstappen<br /> ' . ($countArrayOverstappen - 2) . '</div>
	              <div class="routeInfo-dropdown">
	                <div class="routeInfo-dropdown-img"></div>
	            </div>
	            </div>
	            <div class="overstappen">';
			do {
				if ($j == $countArrayOverstappen - 1) {
					$data.= '<div class="overstap">
	                <div class="overstap-cel">
	                  <div class="overstap-halte"> ' . $infoRoute[$i][$j][1] . '</div>
	                </div>
	                <div class="overstap-cel overstap-cel-midden">
	                  <div class="overstap-titel">Aankomst ' . $infoRoute[$i][$j][0] . '</div>
	                  <div class="overstap-info">Uur: ' . $infoRoute[$i][$j][3] . '</div>
	                  <div class="overstap-info">Perron: ' . $infoRoute[$i][$j][2] . '</div>
	                </div>
	              </div>';
					$j++;
				}
				else {
					$data.= '<div class="overstap">
	                <div class="overstap-cel">
	                  <div class="overstap-halte"> ' . $infoRoute[$i][$j][1] . '</div>
	                </div>
	                <div class="overstap-cel overstap-cel-midden">
	                  <div class="overstap-titel">Aankomst ' . $infoRoute[$i][$j][0] . '</div>
	                  <div class="overstap-info">Uur: ' . $infoRoute[$i][$j][4] . '</div>
	                  <div class="overstap-info">Perron: ' . $infoRoute[$i][$j][2] . '</div>
	                </div>
	              </div>';
					$j++;
				}
			}

			while ($j < $countArrayOverstappen);
			$data.= '</div></div>';
			$j = 0;
			$i++;
		}

		while ($i < $countArrayInfoRoute - 1);
		$data.= '</div>
	        </div>';
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
	public function stuurMail(Request $request){
		$msg = "";
		$naam = $request->naam;
		$bericht =$request->bericht;
		$email = $request->bericht;
		$msg += $naam + " ";
		$msg += $bericht + " ";
		$msg += $email + " ";

		mail("imswiitch@gmail.com","Contact formulier NMBS-website",$msg);
	}
}