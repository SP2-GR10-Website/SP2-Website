<?php

namespace App\Http\Controllers;

class PagesController extends Controller {
	public function getIndex(){
		return view('pages.home');
	}
	public function getTreinInfo(){
		return view('pages.trein-info');
	}
	public function getStationInfo(){
		return view('pages.station-info');
	}
	public function getRouteInfo(){
		return view('pages.route-info');
	}
	public function getTarieven(){
		return view('pages.tarieven');
	}
	public function getContact(){
		return view('pages.contact');
	}
}