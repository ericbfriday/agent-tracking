<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Carbon\Carbon;
use Vanguard\Agent;
use Vanguard\Handler;
use Vanguard\Group;
use Vanguard\AgentTimezones;
use Vanguard\AgentTags;
use Vanguard\AgentHasTag;
use Vanguard\AgentNotes;
use Vanguard\SpymasterReport;

class SpymasterReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:spymaster';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Spymaster Report Daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* What do we want to report 
         * Count of Agents Active/Inactive
         * Count of Handlers Active/Inactive
         * Count of Groups Reporting Active/Inactive
         * ...
         * #original: array:24 [
            "id" => 1
            "name" => "Agent Smith"
            "handler" => "Handler 1"
            "notes" => """
            <p>Clone Status: Alpha/Omega<br />\r\n
            Current SP:<br />\r\n
            Active PVP: Yes/No<br />\r\n
            Any SIGs/Squads or Special Skills: N/A</p>
            """
            "group" => "Brave Collective"
            "status" => "Active"
            "created_at" => "2022-05-03 19:37:57"
            "updated_at" => "2022-05-05 10:09:34"
            "owner" => "Handler"
            "logger_active" => "Active"
            "logger_id" => "1234"
            "jabber_name" => "jonny"
            "skype_name" => "jay@outlook.com"
            "discord_name" => "jay#1234"
            "timezone" => "GMT - London"
            "bh_forum_name" => null
            "gsf_forum_name" => "jay@goonfleet.com"
            "main_character_name" => "jonny"
            "main_character_corporation" => null
            "main_character_alliance" => "TEST"
            "confirm_relay" => ""
            "recieved_training_manual" => ""
            "completed_questionaire" => ""
            "last_contacted" => "2022-05-03 19:38:31"
        ]
        */

        // When should we generate a report.
        // Check If it exists
        // If it exists update it as long as we have not run past the reporting period now() > week ending (end_date)
        // If it does not exist, create it providing we are past the reporting period start date - tbc.
        // Run a scheduled task to updateOrCreate the report every hour.
        // schema id: start_date: end_date: week_number: year: report_type: status: active_agents: active_handlers: active_groups: report_data(json): created_at: updated_at: 

        // Todays Date
        $now = Carbon::now();
        $start_date = $now->startOfWeek()->format('Y-m-d');
        $end_date = $now->endOfWeek()->format('Y-m-d');

        // Report Type
        $report_period = [
            'report_type'           => 'weekly',
            'start_date'            => $start_date,
            'end_date'              => $end_date,
            'week'                  => $now->startOfWeek()->format('W'),
            'month'                 => $now->startOfWeek()->format('M'),
            'year'                  => $now->startOfWeek()->format('Y'),
        ];

        /* Agent Activity Count */
        $agent_activity = DB::table('agent_notes')
        ->whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)])
        ->orderBy('agent', 'ASC')
        ->select('agent as name', DB::raw('count(*) as agent_activity'))
        ->groupBy('agent')
        ->get();

        /* Handler Activity Count */
        $handler_activity = DB::table('agent_notes')
        ->whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)])
        ->orderBy('handler', 'ASC')
        ->select('handler as name', DB::raw('count(*) as handler_activity'))
        ->groupBy('handler')
        ->get();      

        /* Agent Tags Count */
        $agent_tags = DB::table('agent_has_tags')
        ->join('agent_tags', 'agent_has_tags.tag_id', '=', 'agent_tags.id')
        ->join('agents', 'agent_has_tags.agent_id', '=', 'agents.id')
        ->where('agents.status', 'Active')
        ->orderBy('agent_tags.name', 'ASC')
        ->select('agent_tags.id as id', 'agent_tags.name as name',DB::raw('count(*) as active_agents'))
        ->groupBy('tag_id')
        ->get();

        /* Agent Timezones Count */
        $agent_timezones = DB::table('agent_has_timezones')
        ->join('agent_timezones', 'agent_has_timezones.timezone_id', '=', 'agent_timezones.id')
        ->join('agents', 'agent_has_timezones.agent_id', '=', 'agents.id')
        ->where('agents.status', 'Active')
        ->orderBy('agent_timezones.name', 'ASC')
        ->select('agent_timezones.id as id', 'agent_timezones.name as name',DB::raw('count(*) as active_agents'))
        ->groupBy('timezone_id')
        ->get();

        /* Agent Timezones Count */
        $agent_groups = DB::table('agent_has_groups')
        ->join('groups', 'agent_has_groups.group_id', '=', 'groups.id')
        ->join('agents', 'agent_has_groups.agent_id', '=', 'agents.id')
        ->where('agents.status', 'Active')
        ->orderBy('groups.group', 'ASC')
        ->select('groups.id as id', 'groups.group as name',DB::raw('count(*) as active_agents'))
        ->groupBy('group_id')
        ->get();

        /* Agents */
        $agents = Agent::get();
        $active_agents = $agents->where('status', 'Active')->count();
        $agents_report = [
            'total'                => $agents->count(),
            'active'               => $active_agents,
            'inactive'            => $agents->where('status', 'Inactive')->count(),
            'percentage_active'    => $active_agents / $agents->count() * 100,
        ];

        /* Handlers */
        $handlers = Handler::get();
        $active_handlers = $handlers->where('status', 'Active')->count();
        $handlers_report = [
            'total'                 => $handlers->count(),
            'active'                => $active_handlers,
            'inactive'              => $handlers->where('status', 'Inactive')->count(),
            'percentage_active'     => $active_handlers / $handlers->count() * 100,
        ];

        /* Groups */
        $groups = Group::get();
        $active_groups = $groups->where('status', 'Active')->count();
        $groups_report = [
            'total'                 => $groups->count(),
            'active'                => $active_groups,
            'inactive'              => $groups->where('status', 'Inactive')->count(),
            'percentage_active'     => $active_groups / $groups->count() * 100,
        ];


        /* Report */
        $report = [
            'report_period'        => $report_period,            
            'agents'               => $agents_report,
            'handlers'             => $handlers_report,
            'groups'               => $groups_report,
            'active_tags'          => $agent_tags,
            'active_timezones'     => $agent_timezones,
            'active_groups'        => $agent_groups,
            'agent_activity'       => $agent_activity,
            'handler_activity'     => $handler_activity
        ];

        // schema id: start_date: end_date: week_number: year: report_type: status: active_agents: active_handlers: active_groups: report_data(json): created_at: updated_at: 
        //SpymasterReport::where('start_date', $start_date)->where('report_type', 'weekly')->delete();

        SpymasterReport::updateOrCreate([
            'start_date'                    => $start_date,
            'report_type'                   => 'weekly',
        ],[
            'end_date'                      => $end_date,
            'week_number'                   => $now->startOfWeek()->format('W'),
            'month'                         => $now->startOfWeek()->format('M'),
            'year'                          => $now->startOfWeek()->format('Y'),
            'status'                        => 'incomplete',
            'active_agents'                 => $active_agents,
            'active_handlers'               => $active_handlers,
            'active_groups'                 => $active_groups,
            'report_data'                   => json_encode($report),
        ]);

        $this->info('Creating Report for ' . $start_date);

    }
}
