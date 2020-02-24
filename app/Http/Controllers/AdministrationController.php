<?php

namespace App\Http\Controllers;

use App\AuthTokens;
use App\ModerationLog;
use App\Reports;
use Illuminate\Http\Request;

class AdministrationController extends Controller
{
	private function logEndpointAccess($message, Request $request) {
		$id = AuthTokens::getTokenData($request->token)[0]->user->id;

		$modlog_entry = new ModerationLog();
		$modlog_entry->moderator_id = $id;
		$modlog_entry->description = $message;
		$modlog_entry->save();
	}

	public function listReports(Request $request) {
		$this->logEndpointAccess("Griff auf die Reportliste zu.", $request);

		$show_all = $request->all;

		if($show_all === null || $show_all === false) {
			return Reports::where("processed", false)->oldest()->get();
		} else {
			return Reports::orderBy("created_at", "DESC")->get();
		}
	}
}
