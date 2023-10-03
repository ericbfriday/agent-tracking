<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;

use Vanguard\SpymasterReport;

class SpymasterReportController extends Controller
{
    public function index() {

        $reports = SpymasterReport::orderBy('created_at', 'DESC')->get();

        return view('spymaster_reports.list', compact('reports'));
    }

    public function view($end_date) {

        $report = SpymasterReport::where('end_date', $end_date)->first();

        $report_data = json_decode($report->report_data, true);

        $agentGroupChart = [];
        foreach($report_data['active_groups'] as $c) {
            $agentGroupChart[$c['name']] = $c['active_agents'];
        }

        $agentTagChart = [];
        foreach($report_data['active_tags'] as $c) {
            $agentTagChart[$c['name']] = $c['active_agents'];
        }

        $agentTimezoneChart = [];
        foreach($report_data['active_timezones'] as $c) {
            $agentTimezoneChart[$c['name']] = $c['active_agents'];
        }    

        $agentActivityChart = [];
        foreach($report_data['agent_activity'] as $c) {
            $agentActivityChart[$c['name']] = $c['agent_activity'];
        }   

        $handlerActivityChart = [];
        foreach($report_data['handler_activity'] as $c) {
            $handlerActivityChart[$c['name']] = $c['handler_activity'];
        }   

        return view('spymaster_reports.view', 
        compact(
            'report',
            'report_data',
            'agentGroupChart',
            'agentTagChart',
            'agentTimezoneChart',
            'agentActivityChart',
            'handlerActivityChart'
        ));
    }
}
