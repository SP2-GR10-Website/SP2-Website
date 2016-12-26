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
	public function getContact(){
		return view('pages.contact');
	}
	public function ripram(){
		return view('pages.ripram');
	}
}