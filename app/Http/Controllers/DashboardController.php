<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use App\Models\Announcement;
use App\Models\AttendanceEmployee;
use App\Models\BalanceSheet;
use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\Bug;
use App\Models\BugStatus;
use App\Models\Contract;
use App\Models\Deal;
use App\Models\DealTask;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Job;
use App\Models\LandingPageSection;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\Meeting;
use App\Models\Order;
use App\Models\Payees;
use App\Models\Payer;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Pos;
use App\Models\ProductServiceCategory;
use App\Models\ProductServiceUnit;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Purchase;
use App\Models\Revenue;
use App\Models\Stage;
use App\Models\Tax;
use App\Models\Ticket;
use App\Models\Timesheet;
use App\Models\TimeTracker;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Genre;
use App\Models\ProductService;
use App\Models\MaterialUsed;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account_dashboard_index()
    {

        if(Auth::check())
        {
            if(Auth::user()->type == 'super admin')
            {
                return redirect()->route('client.dashboard.view');
            }
            elseif(Auth::user()->type == 'client')
            {
                return redirect()->route('client.dashboard.view');
            }
            else
            {
                if(\Auth::user()->can('show account dashboard'))
                {
                $data['latestIncome']  = Revenue::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['latestExpense'] = Payment::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $currentYer           = date('Y');

                $incomeCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())
                                                        ->where('type', '=', 'income')->get();

                $inColor        = array();
                $inCategory     = array();
                $inAmount       = array();
                for($i = 0; $i < count($incomeCategory); $i++)
                {
                    $inColor[]    = '#' . $incomeCategory[$i]->color;
                    $inCategory[] = $incomeCategory[$i]->name;
                    $inAmount[]   = $incomeCategory[$i]->incomeCategoryRevenueAmount();
                }


                $data['incomeCategoryColor'] = $inColor;
                $data['incomeCategory']      = $inCategory;
                $data['incomeCatAmount']     = $inAmount;


                    $expenseCategory = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())
                                                    ->where('type', '=', 'expense')->get();
                $exColor         = array();
                $exCategory      = array();
                $exAmount        = array();
                for($i = 0; $i < count($expenseCategory); $i++)
                {
                    $exColor[]    = '#' . $expenseCategory[$i]->color;
                    $exCategory[] = $expenseCategory[$i]->name;
                    $exAmount[]   = $expenseCategory[$i]->expenseCategoryAmount();
                }

                $data['expenseCategoryColor'] = $exColor;
                $data['expenseCategory']      = $exCategory;
                $data['expenseCatAmount']     = $exAmount;

                $data['incExpBarChartData']  = \Auth::user()->getincExpBarChartData();
//                dd( $data['incExpBarChartData']);
                $data['incExpLineChartData'] = \Auth::user()->getIncExpLineChartDate();

                $data['currentYear']  = date('Y');
                $data['currentMonth'] = date('M');

                $constant['taxes']         = Tax::where('created_by', \Auth::user()->creatorId())->count();
                $constant['category']      = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->count();
                $constant['units']         = ProductServiceUnit::where('created_by', \Auth::user()->creatorId())->count();
                $constant['bankAccount']   = BankAccount::where('created_by', \Auth::user()->creatorId())->count();
                $data['constant']          = $constant;
                $data['bankAccountDetail'] = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get();
                $data['recentInvoice']     = Invoice::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['weeklyInvoice']     = \Auth::user()->weeklyInvoice();
                $data['monthlyInvoice']    = \Auth::user()->monthlyInvoice();
                $data['recentBill']        = Bill::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->get();
                $data['weeklyBill']        = \Auth::user()->weeklyBill();
                $data['monthlyBill']       = \Auth::user()->monthlyBill();
                $data['goals']             = Goal::where('created_by', '=', \Auth::user()->creatorId())->where('is_display', 1)->get();


                //Storage limit
                $data['users'] = User::find(\Auth::user()->creatorId());
                $data['plan'] = Plan::find(\Auth::user()->show_dashboard());
                if($data['plan']->storage_limit > 0){
                    $data['storage_limit'] = ($data['users']->storage_limit / $data['plan']->storage_limit) * 100;
                }
                else{
                    $data['storage_limit'] = 0;
                }

                return view('dashboard.account-dashboard', $data);
                }
                else
                {

                  return $this->hrm_dashboard_index();
                }


            }
        }
        else
        {
            if(!file_exists(storage_path() . "/installed"))
            {
                header('location:install');
                die;
            }
            else
            {
                $adminSettings = Utility::settings();
                if ($adminSettings['display_landing_page'] == 'on' && \Schema::hasTable('landing_page_settings'))
                {

                    return view('landingpage::layouts.landingpage', compact('adminSettings'));
                }
                else
                {
                    return redirect('login');
                }

            }
        }
    }

    public function activity_dashboard_index() 
    {
        $user = Auth::user();

        if(\Auth::user()->can('show hrm dashboard'))
        {
            if($user->type == 'admin')
            {
                return view('admin.dashboard');
            }
            else
            {
                $home_data = [];
//                dd($user->projects());
                $filter_divisi = request()->get('filter-division');

                $user_projects   = Project::when(!empty($filter_divisi), function($query) use ($filter_divisi) {
                    $query->where('department_id', $filter_divisi);
                })
                ->where('type', 'activity')->pluck('id')->toArray();

                $project_tasks   = ProjectTask::whereIn('project_id', $user_projects)->get();
                $project_expense = Expense::whereIn('project_id', $user_projects)->get();
                $seven_days      = Utility::getLastSevenDays();

                // Total Projects
                $complete_project           = Project::where('type', 'activity')->where('status', 'LIKE', 'complete')->count();
                $home_data['total_project'] = [
                    'total' => count($user_projects),
                    'percentage' => Utility::getPercentage($complete_project, count($user_projects)),
                ];

                // Total Tasks
                $complete_task           = ProjectTask::where('is_complete', '=', 1)->whereRaw("find_in_set('" . $user->id . "',assign_to)")->whereIn('project_id', $user_projects)->count();
                $home_data['total_task'] = [
                    'total' => $project_tasks->count(),
                    'percentage' => Utility::getPercentage($complete_task, $project_tasks->count()),
                ];

                // Total Expense
                $total_expense        = 0;
                $total_budget        = 0;
                $total_project_amount = 0;

                $total_quantity = \DB::table('material_used')
                ->join('product_services', 'product_services.id', '=', 'material_used.product_id')
                ->select('material_used.quantity', 'product_services.sale_price')
                ->get();

                $total_budget = \DB::table('projects')->sum('budget');
            
                // Calculate the total price multiplied by the total quantity
                $total_expense = $total_quantity->sum(function ($item) {
                    return $item->quantity * $item->sale_price;
                });

                foreach($user->projects as $pr)
                {
                    $total_project_amount += $pr->budget;
                }
                foreach($project_expense as $expense)
                {
                    $total_expense += $expense->amount;
                }
                $home_data['total_expense'] = [
                    'total' => $total_expense,
                    'percentage' => Utility::getPercentage($total_expense, $total_project_amount),
                ];

                $home_data['total_budget'] = [
                    'total' => $total_budget,
                ];

                // Total Users
                $home_data['total_user'] = Auth::user()->contacts->count();

                $home_data['all_task_overview'] = [];

                $employees = Employee::when(!empty($filter_divisi), function($query) use ($filter_divisi) {
                    $query->where('department_id', $filter_divisi);
                })
                ->get();

                if(request()->get('filter-task') == 'tahunan') {
                    $current_year = date('Y'); // Get the current year
                    $start_year = $current_year - 5; // Start 5 years ago
                    $data=[];

                    foreach($employees as $index => $employee) {
                        // Tasks Overview Chart & Timesheet Log Chart
                        $task_overview    = [];
                        $timesheet_logged = [];
                        $low = 0;
                        $medium = 0;
                        $high = 0;
                        $critical = 0;
                        for ($year = $start_year; $year <= $current_year; $year++) {
                            $task_count = ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereYear('marked_at', $year)
                                ->whereIn('project_id', $user_projects)->count();

                            $low += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereYear('marked_at', $year)
                                ->whereIn('project_id', $user_projects)->where('priority', 'low')->count();

                            $medium += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereYear('marked_at', $year)
                                ->whereIn('project_id', $user_projects)->where('priority', 'medium')->count();

                            $high += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereYear('marked_at', $year)
                                ->whereIn('project_id', $user_projects)->where('priority', 'high')->count();

                            $critical += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereYear('marked_at', $year)
                                ->whereIn('project_id', $user_projects)->where('priority', 'critical')->count();

                            $time = Timesheet::whereIn('project_id', $user_projects)
                                ->whereYear('date', $year)
                                ->pluck('time')
                                ->toArray();
                            $timesheet_logged[$year] = str_replace(':', '.', Utility::calculateTimesheetHours($time));

                            $task_overview[$year] = $task_count;
                        }

                        $home_data['task_overview'][$employee->name]    = $task_overview;
                        $home_data['timesheet_logged'][$employee->name] = $timesheet_logged;
                        $data[$index] = [
                            'name' => $employee->name,
                            'low' => $low,
                            'medium' => $medium,
                            'high' => $high,
                            'critical' => $critical,
                        ];

                    }
                    $home_data['all_task_overview'] = $data;
                }elseif(request()->get('filter-task') == 'bulanan') {
                    $year = date('Y'); // Set the year
                    $data=[];

                    foreach($employees as $index => $employee) {
                        // Tasks Overview Chart & Timesheet Log Chart
                        $task_overview    = [];
                        $timesheet_logged = [];
                        $low = 0;
                        $medium = 0;
                        $high = 0;
                        $critical = 0;
                        for ($month = 1; $month <= 12; $month++) {
                            $first_day_of_month = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                            $last_day_of_month = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    
                            $month_name = date('F', mktime(0, 0, 0, $month, 1, $year));
                    
                            // Task
                            $task_overview[$month_name] = ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$first_day_of_month, $last_day_of_month])
                                ->whereIn('project_id', $user_projects)
                                ->count();

                            $low += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$first_day_of_month, $last_day_of_month])
                                ->whereIn('project_id', $user_projects)->where('priority', 'low')->count();

                            $medium += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$first_day_of_month, $last_day_of_month])
                                ->whereIn('project_id', $user_projects)->where('priority', 'medium')->count();

                            $high += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$first_day_of_month, $last_day_of_month])
                                ->whereIn('project_id', $user_projects)->where('priority', 'high')->count();

                            $critical += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$first_day_of_month, $last_day_of_month])
                                ->whereIn('project_id', $user_projects)->where('priority', 'critical')->count();
                    
                            // Timesheet
                            $time = Timesheet::whereIn('project_id', $user_projects)
                                ->whereBetween('date', [$first_day_of_month, $last_day_of_month])
                                ->pluck('time')
                                ->toArray();
                            $timesheet_logged[$month_name] = str_replace(':', '.', Utility::calculateTimesheetHours($time));
                        }
                    
                        $home_data['task_overview'][$employee->name]    = $task_overview;
                        $home_data['timesheet_logged'][$employee->name] = $timesheet_logged;
                        $data[$index] = [
                            'name' => $employee->name,
                            'low' => $low,
                            'medium' => $medium,
                            'high' => $high,
                            'critical' => $critical,
                        ];
                    }
                    $home_data['all_task_overview'] = $data;
                }elseif(request()->get('filter-task') == 'mingguan'){
                    $current_year = date('Y'); // Get the current year
                    $current_month = date('m'); // Get the current month
                    $data=[];

                    foreach($employees as $index => $employee) {
                        // Tasks Overview Chart & Timesheet Log Chart
                        $task_overview    = [];
                        $timesheet_logged = [];
                        $low = 0;
                        $medium = 0;
                        $high = 0;
                        $critical = 0;

                        $week = 1;
                        while ($week <= 5) { // Assuming a month has at most 5 weeks for simplicity
                            $start_date = date('Y-m-d', strtotime("{$current_year}-{$current_month}-01 +{$week} week"));
                            $end_date = date('Y-m-d', strtotime("{$current_year}-{$current_month}-01 +".($week+1)." week"));

                            // Task
                            $task_count = ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$start_date, $end_date])
                                ->whereIn('project_id', $user_projects)
                                ->count();

                            $low += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$start_date, $end_date])
                                ->whereIn('project_id', $user_projects)->where('priority', 'low')->count();

                            $medium += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$start_date, $end_date])
                                ->whereIn('project_id', $user_projects)->where('priority', 'medium')->count();

                            $high += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$start_date, $end_date])
                                ->whereIn('project_id', $user_projects)->where('priority', 'high')->count();

                            $critical += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->whereBetween('marked_at', [$start_date, $end_date])
                                ->whereIn('project_id', $user_projects)->where('priority', 'critical')->count();

                            // Timesheet
                            $time = Timesheet::whereIn('project_id', $user_projects)
                                ->whereBetween('date', [$start_date, $end_date])
                                ->pluck('time')
                                ->toArray();

                            $timesheet_logged["[$week - $start_date to $end_date]"] = str_replace(':', '.', Utility::calculateTimesheetHours($time));

                            $task_overview[$week] = $task_count;
                            $task_overview["[$week - $start_date to $end_date]"]    = $task_count;

                            $week++;
                        }

                        $home_data['task_overview'][$employee->name]    = $task_overview;
                        $home_data['timesheet_logged'][$employee->name] = $timesheet_logged;
                        $data[$index] = [
                            'name' => $employee->name,
                            'low' => $low,
                            'medium' => $medium,
                            'high' => $high,
                            'critical' => $critical,
                        ];
                    }
                    $home_data['all_task_overview'] = $data;
                }else{
                    $data=[];
                    foreach($employees as $index => $employee) {
                        // Tasks Overview Chart & Timesheet Log Chart
                        $task_overview    = [];
                        $timesheet_logged = [];
                        $low = 0;
                        $medium = 0;
                        $high = 0;
                        $critical = 0;
                        foreach($seven_days as $date => $day)
                        {
                            // Task
                            $task_overview[$day] = ProjectTask::where('is_complete', '=', 1)->where('assign_to', $employee->user_id)->where('marked_at', 'LIKE', $date)->whereIn('project_id', $user_projects)->count();

                            $low += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->where('marked_at', 'LIKE', $date)
                                ->whereIn('project_id', $user_projects)->where('priority', 'low')->count();

                            $medium += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->where('marked_at', 'LIKE', $date)
                                ->whereIn('project_id', $user_projects)->where('priority', 'medium')->count();

                            $high += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->where('marked_at', 'LIKE', $date)
                                ->whereIn('project_id', $user_projects)->where('priority', 'high')->count();

                            $critical += ProjectTask::where('is_complete', '=', 1)
                                ->where('assign_to', $employee->user_id)
                                ->where('marked_at', 'LIKE', $date)
                                ->whereIn('project_id', $user_projects)->where('priority', 'critical')->count();
    
                            // Timesheet
                            $time                   = Timesheet::whereIn('project_id', $user_projects)->where('date', 'LIKE', $date)->pluck('time')->toArray();
                            $timesheet_logged[$day] = str_replace(':', '.', Utility::calculateTimesheetHours($time));
                        }
    
                        $home_data['task_overview'][$employee->name]    = $task_overview;
                        $home_data['timesheet_logged'] = $timesheet_logged;
                        $data[$index] = [
                            'name' => $employee->name,
                            'low' => $low,
                            'medium' => $medium,
                            'high' => $high,
                            'critical' => $critical,
                        ];
                    }
                    $home_data['all_task_overview'] = $data;
                }

                // Project Status
                $total_project  = count($user_projects);

                $project_status = [];
                foreach(Project::$project_status as $k => $v)
                {

                    $project_status[$k]['total']      = $user->projects->where('status', 'LIKE', $k)->count();
//                    dd($project_status[$k]['total']    );
                    $project_status[$k]['percentage'] = Utility::getPercentage($project_status[$k]['total'], $total_project);
                }
                $home_data['project_status'] = $project_status;

                // Top Due Project
                $home_data['due_project'] = Project::where('type', 'activity')->orderBy('end_date', 'DESC')->limit(5)->get();

                // Top Due Tasks
                $home_data['due_tasks'] = ProjectTask::where('is_complete', '=', 0)->whereIn('project_id', $user_projects)->orderBy('end_date', 'asc')->limit(5)->get();

                $home_data['last_tasks'] = ProjectTask::whereIn('project_id', $user_projects)->orderBy('end_date', 'DESC')->limit(5)->get();

                $home_data['all_tasks'] = ProjectTask::whereIn('project_id', $user_projects)->orderBy('end_date', 'DESC')->where('is_complete', '!=', 1)->get();

                $home_data['list_division'] = Department::get();

                return view('dashboard.activity-dashboard', compact('home_data'));
            }
        }
        else
        {

            return $this->account_dashboard_index();
        }
    }

    public function project_dashboard_index()
    {
        $user = Auth::user();

        if(\Auth::user()->can('show project dashboard'))
        {
            if($user->type == 'admin')
            {
                return view('admin.dashboard');
            }
            else
            {
                $home_data = [];
//                dd($user->projects());

                $user_projects   = $user->projects()->pluck('project_id')->toArray();

                $project_tasks   = ProjectTask::whereIn('project_id', $user_projects)->get();
                $project_expense = Expense::whereIn('project_id', $user_projects)->get();
                $seven_days      = Utility::getLastSevenDays();

                // Total Projects
                $complete_project           = $user->projects()->where('status', 'LIKE', 'complete')->count();
                $home_data['total_project'] = [
                    'total' => count($user_projects),
                    'percentage' => Utility::getPercentage($complete_project, count($user_projects)),
                ];

                // Total Pcs
                $complete_invoice           = Invoice::with('items')->where('status', '!=', 0)->get()->pluck('id');
                
                $total_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)->sum('quantity');

                $home_data['total_invoice'] = [
                    'total' => $total_pcs ?? 0
                ];

                if(request()->get('filter-pcs') == 'tahunan') {
                    $currentYear = date('Y');
                    $years = range($currentYear - 5, $currentYear);

                    $pcsByYear = [];
                    foreach ($years as $year) {
                        $pcsByYear[$year] = 0;
                    }

                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('YEAR(created_at) as year, SUM(quantity) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();

                    foreach ($years as $year) {
                        $pcsByYear[$year] = $current_pcs[$year] ?? 0;
                    }

                    $home_data['pcsByMonth'] = $pcsByYear;
                }elseif(request()->get('filter-pcs') == 'mingguan') {
                    $currentYear = date('Y');
                    $currentMonth = date('m');
                    $weeksInMonth = [];
                    $week = 1;

                    $startDate = new \DateTime('first day of this month');
                    $endDate = new \DateTime('last day of this month');
                    $endDate->modify('+1 day'); // To include the last day

                    while ($startDate < $endDate) {
                        $weeksInMonth[$startDate->format('W')] = [
                            'start_date' => clone $startDate,
                            'end_date' => null,
                        ];
                        $startDate->modify('+1 week');
                    }

                    foreach ($weeksInMonth as &$weekData) {
                        $weekData['end_date'] = (clone $weekData['start_date'])->modify('+6 days');
                    }

                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('WEEK(created_at) as week, SUM(quantity) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();

                    $pcsByWeek = [];
                    foreach ($weeksInMonth as $weekNumber => $weekData) {
                        $quantity = $current_pcs[$weekNumber] ?? 0;
                        $pcsByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;
                    }

                    $home_data['pcsByMonth'] = $pcsByWeek;
                }else{
                    $months = [
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ];
                    
                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, SUM(quantity) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                    
                    $pcsByMonth = [];
                    foreach ($months as $month) {
                        $pcsByMonth[$month] = $current_pcs[$month] ?? 0;
                    }
    
                    $home_data['pcsByMonth'] = $pcsByMonth;
                }

                // Total Tasks
                $complete_task           = ProjectTask::where('is_complete', '=', 1)->whereRaw("find_in_set('" . $user->id . "',assign_to)")->whereIn('project_id', $user_projects)->count();
                $home_data['total_task'] = [
                    'total' => $project_tasks->count(),
                    'percentage' => Utility::getPercentage($complete_task, $project_tasks->count()),
                ];

                // Total Expense
                $total_expense        = 0;
                $total_budget        = 0;
                $total_project_amount = 0;

                $total_quantity = \DB::table('material_used')
                ->join('product_services', 'product_services.id', '=', 'material_used.product_id')
                ->select('material_used.quantity', 'product_services.sale_price')
                ->get();

                $total_budget = \DB::table('invoice_payments')->sum('amount');
            
                // Calculate the total price multiplied by the total quantity
                $total_expense = $total_quantity->sum(function ($item) {
                    return $item->quantity * $item->sale_price;
                });

                foreach($user->projects as $pr)
                {
                    $total_project_amount += $pr->budget;
                }
                foreach($project_expense as $expense)
                {
                    $total_expense += $expense->amount;
                }

                $total_overhead = \DB::table('payments')->sum('amount');

                $home_data['total_expense'] = [
                    'total' => $total_expense + $total_overhead,
                    'percentage' => Utility::getPercentage($total_expense, $total_project_amount),
                ];

                $home_data['total_budget'] = [
                    'total' => $total_budget,
                ];

                // Total Users
                $home_data['total_user'] = Auth::user()->contacts->count();

                // Tasks Overview Chart & Timesheet Log Chart
                $task_overview    = [];
                $timesheet_logged = [];
                foreach($seven_days as $date => $day)
                {
                    // Task
                    $task_overview[$day] = ProjectTask::where('is_complete', '=', 1)->where('marked_at', 'LIKE', $date)->whereIn('project_id', $user_projects)->count();

                    // Timesheet
                    $time                   = Timesheet::whereIn('project_id', $user_projects)->where('date', 'LIKE', $date)->pluck('time')->toArray();
                    $timesheet_logged[$day] = str_replace(':', '.', Utility::calculateTimesheetHours($time));
                }

                $home_data['task_overview']    = $task_overview;
                $home_data['timesheet_logged'] = $timesheet_logged;

                // Project Status
                $total_project  = count($user_projects);

                $project_status = [];
                foreach(Project::$project_status as $k => $v)
                {

                    $project_status[$k]['total']      = $user->projects->where('status', 'LIKE', $k)->count();
//                    dd($project_status[$k]['total']    );
                    $project_status[$k]['percentage'] = Utility::getPercentage($project_status[$k]['total'], $total_project);
                }
                $home_data['project_status'] = $project_status;

                // Top Due Project
                $home_data['due_project'] = $user->projects()->orderBy('end_date', 'DESC')->limit(5)->get();

                // Top Due Tasks
                $home_data['due_tasks'] = ProjectTask::where('is_complete', '=', 0)->whereIn('project_id', $user_projects)->orderBy('end_date', 'DESC')->limit(5)->get();

                $home_data['last_tasks'] = ProjectTask::whereIn('project_id', $user_projects)->orderBy('end_date', 'DESC')->limit(5)->get();

                $categories = Category::get();

                $home_data['categories'] = [];

                foreach($categories as $category) {
                    $pcs = InvoiceProduct::where('category_id', $category->id)->sum('quantity');

                    $home_data['categories'][$category->name] = $pcs;
                }

                $genres = Genre::get();

                $home_data['genres'] = [];

                foreach($genres as $genre) {
                    $pcs = InvoiceProduct::where('genre_id', $genre->id)->sum('quantity');

                    $home_data['genres'][$genre->name] = $pcs;
                }

                return view('dashboard.project-dashboard', compact('home_data'));
            }
        }
        else
        {

            return $this->account_dashboard_index();
        }
    }

    public function hrm_dashboard_index()
    {

        if(Auth::check())
        {

            if(\Auth::user()->can('show hrm dashboard'))
            {

                $user = Auth::user();

                if($user->type != 'client' && $user->type != 'company')
                {
                    $emp = Employee::where('user_id', '=', $user->id)->first();

                    $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->leftjoin('announcement_employees', 'announcements.id', '=', 'announcement_employees.announcement_id')->where('announcement_employees.employee_id', '=', $emp->id)->orWhere(function ($q){
                        $q->where('announcements.department_id', '["0"]')->where('announcements.employee_id', '["0"]');
                    })->get();

                    $employees = Employee::get();
                    $meetings  = Meeting::orderBy('meetings.id', 'desc')->take(5)->leftjoin('meeting_employees', 'meetings.id', '=', 'meeting_employees.meeting_id')->where('meeting_employees.employee_id', '=', $emp->id)->orWhere(function ($q){
                        $q->where('meetings.department_id', '["0"]')->where('meetings.employee_id', '["0"]');
                    })->get();
                    $events    = Event::leftjoin('event_employees', 'events.id', '=', 'event_employees.event_id')->where('event_employees.employee_id', '=', $emp->id)->orWhere(function ($q){
                        $q->where('events.department_id', '["0"]')->where('events.employee_id', '["0"]');
                    })->get();

                    $arrEvents = [];
                    foreach($events as $event)
                    {

                        $arr['id']              = $event['id'];
                        $arr['title']           = $event['title'];
                        $arr['start']           = $event['start_date'];
                        $arr['end']             = $event['end_date'];
                        $arr['backgroundColor'] = $event['color'];
                        $arr['borderColor']     = "#fff";
                        $arr['textColor']       = "white";
                        $arrEvents[]            = $arr;
                    }

                    $date               = date("Y-m-d");
                    $time               = date("H:i:s");
                    $employeeAttendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', !empty(\Auth::user()->employee) ? \Auth::user()->employee->id : 0)->where('date', '=', $date)->first();

                    $officeTime['startTime'] = Utility::getValByName('company_start_time');
                    $officeTime['endTime']   = Utility::getValByName('company_end_time');

                    return view('dashboard.dashboard', compact('arrEvents', 'announcements', 'employees', 'meetings', 'employeeAttendance', 'officeTime'));
                }
                else if($user->type == 'super admin')
                {
                    $user                       = \Auth::user();
                    $user['total_user']         = $user->countCompany();
                    $user['total_paid_user']    = $user->countPaidCompany();
                    $user['total_orders']       = Order::total_orders();
                    $user['total_orders_price'] = Order::total_orders_price();
                    $user['total_plan']         = Plan::total_plan();
                    $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->name : '');

                    $chartData = $this->getOrderChart(['duration' => 'week']);

                    return view('dashboard.super_admin', compact('user', 'chartData'));
                }
                else
                {
                    $events    = Event::where('created_by', '=', \Auth::user()->creatorId())->get();
                    $arrEvents = [];

                    foreach($events as $event)
                    {
                        $arr['id']    = $event['id'];
                        $arr['title'] = $event['title'];
                        $arr['start'] = $event['start_date'];
                        $arr['end']   = $event['end_date'];

                        $arr['backgroundColor'] = $event['color'];
                        $arr['borderColor']     = "#fff";
                        $arr['textColor']       = "white";
                        $arr['url']             = route('event.edit', $event['id']);

                        $arrEvents[] = $arr;
                    }


                    $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->where('created_by', '=', \Auth::user()->creatorId())->get();


                    // $emp           = User::where('type', '!=', 'client')->where('type', '!=', 'company')->where('created_by', '=', \Auth::user()->creatorId())->get();
                    // $countEmployee = count($emp);

                    $user      = User::where('type', '!=', 'client')->where('type', '!=', 'company')->where('created_by', '=', \Auth::user()->creatorId())->get();
                    $countUser = count($user);


                    $countTrainer    = Trainer::where('created_by', '=', \Auth::user()->creatorId())->count();
                    $onGoingTraining = Training::where('status', '=', 1)->where('created_by', '=', \Auth::user()->creatorId())->count();
                    $doneTraining    = Training::where('status', '=', 2)->where('created_by', '=', \Auth::user()->creatorId())->count();

                    $currentDate = date('Y-m-d');

                    $employees   = User::where('type', '=', 'client')->where('created_by', '=', \Auth::user()->creatorId())->get();
                    $countClient = count($employees);
                    $notClockIn  = AttendanceEmployee::where('date', '=', $currentDate)->get()->pluck('employee_id');

                    $notClockIns = Employee::where('created_by', '=', \Auth::user()->creatorId())->whereNotIn('id', $notClockIn)->get();
                    $activeJob   = Job::where('status', 'active')->where('created_by', '=', \Auth::user()->creatorId())->count();
                    $inActiveJOb = Job::where('status', 'in_active')->where('created_by', '=', \Auth::user()->creatorId())->count();

                    $meetings = Meeting::where('created_by', '=', \Auth::user()->creatorId())->limit(5)->get();

                    return view('dashboard.dashboard', compact('arrEvents', 'onGoingTraining', 'activeJob', 'inActiveJOb', 'doneTraining', 'announcements', 'employees', 'meetings', 'countTrainer', 'countClient', 'countUser', 'notClockIns'));
                }
            }
            else
            {

                return $this->project_dashboard_index();
            }
        }
        else
        {
            if(!file_exists(storage_path() . "/installed"))
            {
                header('location:install');
                die;
            }
            else
            {
                $settings = Utility::settings();
                if($settings['display_landing_page'] == 'on')
                {
                    $plans = Plan::get();

                    return view('layouts.landing', compact('plans'));
                }
                else
                {
                    return redirect('login');
                }

            }
        }
    }

    public function material_dashboard_index()
    {
        $user = Auth::user();

        if(\Auth::user()->can('show hrm dashboard'))
        {
            if($user->type == 'admin')
            {
                return view('admin.dashboard');
            }
            else
            {
                $home_data = [];

                $user_projects   = $user->projects()->pluck('project_id')->toArray();

                $project_tasks   = ProjectTask::whereIn('project_id', $user_projects)->get();
                $project_expense = Expense::whereIn('project_id', $user_projects)->get();
                $seven_days      = Utility::getLastSevenDays();

                $kains = ProductService::where('name', 'not like', '%Bensin%')
                    ->where('name', 'not like', '%Kertas%')
                    ->where('name', 'not like', '%KERTAS%')
                    ->where('name', 'not like', '%Tinta%')
                    ->get();

                $harga_kains = $kains->pluck('sale_price', 'name')->toArray();
                $home_data['harga_kains'] = $harga_kains;
                    
                $tintas = ProductService::where('name', 'like', '%Tinta%')
                    ->orWhere('name', 'like', '%TINTA%')
                    ->get();

                $harga_tintas = $tintas->pluck('sale_price', 'name')->toArray();
                $home_data['harga_tintas'] = $harga_tintas;

                $kertass = ProductService::where('name', 'like', '%Kertas%')
                    ->orWhere('name', 'like', '%KERTAS%')
                    ->get();

                $harga_kertass = $kertass->pluck('sale_price', 'name')->toArray();
                $home_data['harga_kertass'] = $harga_kertass;
                
                // Total Pcs
                $complete_invoice           = Invoice::with('items')->where('status', '!=', 0)->get()->pluck('id');
                
                $total_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)->sum('quantity');

                $home_data['total_invoice'] = [
                    'total' => $total_pcs ?? 0
                ];

                $months = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];

                if(request()->get('filter-pcs') == 'tahunan') {
                    $currentYear = date('Y');
                    $years = range($currentYear - 5, $currentYear);

                    $pcsByYear = [];
                    $kainsByYear = [];
                    $tintasByYear = [];
                    $kertassByYear = [];
                    foreach ($years as $year) {
                        $pcsByYear[$year] = 0;
                        $kainsByYear[$year] = 0;
                        $tintasByYear[$year] = 0;
                        $kertassByYear[$year] = 0;
                    }

                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();

                    $total_kains = MaterialUsed::whereIn('product_id', $kains->pluck('id'))
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();

                    $total_tintas = MaterialUsed::whereIn('product_id', $tintas->pluck('id'))
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();

                    $total_kertass = MaterialUsed::whereIn('product_id', $kertass->pluck('id'))
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();
                
                    foreach ($years as $year) {
                        $pcsByYear[$year] = $current_pcs[$year] ?? 0;
                        $kainsByYear[$year] = $total_kains[$year] ?? 0;
                        $tintasByYear[$year] = $total_tintas[$year] ?? 0;
                        $kertassByYear[$year] = $total_kertass[$year] ?? 0;
                    }

                    $home_data['pcsByMonth'] = $pcsByYear;
                    $home_data['kainsByMonth'] = $kainsByYear;
                    $home_data['tintasByMonth'] = $tintasByYear;
                    $home_data['kertassByMonth'] = $kertassByYear;

                    $perkainsByYear = [];
                    $pertintasByYear = [];
                    $perkertassByYear = [];
                    foreach ($kains as $key => $kain) {
                        $total_kains = MaterialUsed::where('product_id', $kain->id)
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();
                        
                        foreach ($years as $year) {
                            $perkainsByYear[$year] = $total_kains[$year] ?? 0;
                        }

                        $home_data['perkainsByMonth'][$kain->name] = $perkainsByYear;
                    }
                    foreach ($tintas as $key => $tinta) {
                        $total_tintas = MaterialUsed::where('product_id', $tinta->id)
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();
                        
                        foreach ($years as $year) {
                            $pertintasByYear[$year] = $total_tintas[$year] ?? 0;
                        }

                        $home_data['pertintasByMonth'][$tinta->name] = $pertintasByYear;
                    }
                    foreach ($kertass as $key => $kertas) {
                        $total_kertass = MaterialUsed::where('product_id', $kertas->id)
                        ->selectRaw('YEAR(created_at) as year, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('year')
                        ->get()
                        ->pluck('total_quantity', 'year')
                        ->toArray();
                        
                        foreach ($years as $year) {
                            $perkertassByYear[$year] = $total_kertass[$year] ?? 0;
                        }

                        $home_data['perkertassByMonth'][$kertas->name] = $perkertassByYear;
                    }
                }elseif(request()->get('filter-pcs') == 'mingguan') {
                    $currentYear = date('Y');
                    $currentMonth = date('m');
                    $weeksInMonth = [];
                    $week = 1;

                    $startDate = new \DateTime('first day of this month');
                    $endDate = new \DateTime('last day of this month');
                    $endDate->modify('+1 day'); // To include the last day

                    while ($startDate < $endDate) {
                        $weeksInMonth[$startDate->format('W')] = [
                            'start_date' => clone $startDate,
                            'end_date' => null,
                        ];
                        $startDate->modify('+1 week');
                    }

                    foreach ($weeksInMonth as &$weekData) {
                        $weekData['end_date'] = (clone $weekData['start_date'])->modify('+6 days');
                    }

                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();
                    
                    $total_kertass = MaterialUsed::whereIn('product_id', $kertass->pluck('id'))
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();

                    $total_tintas = MaterialUsed::whereIn('product_id', $tintas->pluck('id'))
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();
                    
                    $total_kains = MaterialUsed::whereIn('product_id', $kains->pluck('id'))
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();

                    $pcsByWeek = [];
                    $kertassByWeek = [];
                    $kainsByWeek = [];
                    $tintasByWeek = [];
                    foreach ($weeksInMonth as $weekNumber => $weekData) {
                        $quantity = $current_pcs[$weekNumber] ?? 0;
                        $pcsByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;

                        $quantity = $total_kertass[$weekNumber] ?? 0;
                        $kertassByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;

                        $quantity = $total_tintas[$weekNumber] ?? 0;
                        $tintasByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;

                        $quantity = $total_kains[$weekNumber] ?? 0;
                        $kainsByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;
                    }

                    $home_data['pcsByMonth'] = $pcsByWeek;
                    $home_data['kainsByMonth'] = $kainsByWeek;
                    $home_data['tintasByMonth'] = $tintasByWeek;
                    $home_data['kertassByMonth'] = $kertassByWeek;

                    $perkertassByWeek = [];
                    $pertintasByWeek = [];
                    $perkainsByWeek = [];
                    foreach ($kertass as $key => $kertas) {
                        $total_kertass = MaterialUsed::where('product_id', $kertas->id)
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();
                            
                        foreach ($weeksInMonth as $weekNumber => $weekData) {
                            $quantity = $total_kertass[$weekNumber] ?? 0;
                            $perkertassByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;
                        }

                        $home_data['perkertassByMonth'][$kertas->name] = $perkertassByWeek;
                    }

                    foreach ($tintas as $key => $tinta) {
                        $total_tintas = MaterialUsed::where('product_id', $tinta->id)
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();
                            
                        foreach ($weeksInMonth as $weekNumber => $weekData) {
                            $quantity = $total_tintas[$weekNumber] ?? 0;
                            $pertintasByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;
                        }

                        $home_data['pertintasByMonth'][$tinta->name] = $pertintasByWeek;
                    }

                    foreach ($kains as $key => $kain) {
                        $total_kains = MaterialUsed::where('product_id', $kain->id)
                        ->selectRaw('WEEK(created_at) as week, ROUND(SUM(quantity)) as total_quantity')
                        ->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->groupBy('week')
                        ->get()
                        ->pluck('total_quantity', 'week')
                        ->toArray();
                            
                        foreach ($weeksInMonth as $weekNumber => $weekData) {
                            $quantity = $total_kains[$weekNumber] ?? 0;
                            $perkainsByWeek["Week $weekNumber (" . $weekData['start_date']->format('Y-m-d') . " to " . $weekData['end_date']->format('Y-m-d') . ")"] = $quantity;
                        }

                        $home_data['perkainsByMonth'][$kain->name] = $perkainsByWeek;
                    }
                }else{
                    
                    $current_pcs = InvoiceProduct::whereIn('invoice_id', $complete_invoice)
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                
                    $total_tintas = MaterialUsed::whereIn('product_id', $tintas->pluck('id'))
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();

                    $total_kertass = MaterialUsed::whereIn('product_id', $kertass->pluck('id'))
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                    
                    $total_kains = MaterialUsed::whereIn('product_id', $kains->pluck('id'))
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                    
                    $pcsByMonth = [];
                    $tintasByMonth = [];
                    $kertassByMonth = [];
                    $kainsByMonth = [];
                    foreach ($months as $month) {
                        $pcsByMonth[$month] = $current_pcs[$month] ?? 0;
                        $kertassByMonth[$month] = $total_kertass[$month] ?? 0;
                        $tintasByMonth[$month] = $total_tintas[$month] ?? 0;
                        $kainsByMonth[$month] = $total_kains[$month] ?? 0;
                    }
    
                    $home_data['pcsByMonth'] = $pcsByMonth;
                    $home_data['kertassByMonth'] = $kertassByMonth;
                    $home_data['kainsByMonth'] = $kainsByMonth;
                    $home_data['tintasByMonth'] = $tintasByMonth;

                    $perkainsByMonth = [];
                    $pertintasByMonth = [];
                    $perkertassByMonth = [];
                    foreach ($kains as $key => $kain) {
                        $total_kains = MaterialUsed::where('product_id', $kain->id)
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                        
                        foreach ($months as $month) {
                            $perkainsByMonth[$month] = $total_kains[$month] ?? 0;
                        }

                        $home_data['perkainsByMonth'][$kain->name] = $perkainsByMonth;
                    }

                    foreach ($tintas as $key => $tinta) {
                        $total_tintas = MaterialUsed::where('product_id', $tinta->id)
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                        
                        foreach ($months as $month) {
                            $pertintasByMonth[$month] = $total_tintas[$month] ?? 0;
                        }

                        $home_data['pertintasByMonth'][$tinta->name] = $pertintasByMonth;
                    }

                    foreach ($kertass as $key => $kertas) {
                        $total_kertass = MaterialUsed::where('product_id', $kertas->id)
                        ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(quantity)) as total_quantity')
                        ->groupBy('month')
                        ->get()
                        ->pluck('total_quantity', 'month')
                        ->toArray();
                        
                        foreach ($months as $month) {
                            $perkertassByMonth[$month] = $total_kertass[$month] ?? 0;
                        }

                        $home_data['perkertassByMonth'][$kertas->name] = $perkertassByMonth;
                    }
                }

                $totalCost = MaterialUsed::with('product')
                ->join('product_services', 'material_used.product_id', '=', 'product_services.id')
                ->select(\DB::raw('ROUND(product_services.sale_price * material_used.quantity) as total_cost'), \DB::raw('DATE_FORMAT(material_used.created_at, "%b") as month'))
                ->groupBy('month')
                ->get()
                ->pluck('total_cost', 'month')
                ->toArray();

                $totalBudget = \DB::table('projects')
                ->selectRaw('DATE_FORMAT(created_at, "%b") as month, ROUND(SUM(budget)) as total_budget')
                ->groupBy('month')
                ->get()
                ->pluck('total_budget', 'month')
                ->toArray();

                $totalCostByMonth = [];
                $totalBudgetByMonth = [];
                $totalEfisiensiByMonth = [];
                foreach ($months as $month) {
                    $totalCostByMonth[$month] = $totalCost[$month] ?? 0;
                    $totalBudgetByMonth[$month] = $totalBudget[$month] ?? 0;
                    $totalEfisiensiByMonth[$month] = ($totalBudget[$month] ?? 0) - ($totalCost[$month] ?? 0);
                }

                $home_data['totalCostByMonth'] = $totalCostByMonth;
                $home_data['totalBudgetByMonth'] = $totalBudgetByMonth;
                $home_data['totalEfisiensiByMonth'] = $totalEfisiensiByMonth;

                return view('dashboard.material-dashboard', compact('home_data'));
            }
        }
        else
        {

            return $this->account_dashboard_index();
        }
    }

    public function crm_dashboard_index()
    {
        $user = Auth::user();
        if(\Auth::user()->can('show crm dashboard'))
        {
            if($user->type == 'admin')
            {
                return view('admin.dashboard');
            }
            else
            {
                $crm_data = [];

                $leads = Lead::where('created_by', \Auth::user()->creatorId())->get();
                $deals = Deal::where('created_by', \Auth::user()->creatorId())->get();

                //count data
                $crm_data['total_leads']= $total_leads     = count($leads);
                $crm_data['total_deals']= $total_deals     = count($deals);
                $crm_data['total_contracts']       = Contract::where('created_by', \Auth::user()->creatorId())->count();

                //lead status
//                $user_leads   = $leads->pluck('lead_id')->toArray();
                $total_leads  = count($leads);
                $lead_status = [];
                $status = LeadStage::select('lead_stages.*', 'pipelines.name as pipeline')
                    ->join('pipelines', 'pipelines.id', '=', 'lead_stages.pipeline_id')
                    ->where('pipelines.created_by', '=', \Auth::user()->creatorId())
                    ->where('lead_stages.created_by', '=', \Auth::user()->creatorId())
                    ->orderBy('lead_stages.pipeline_id')->get();

                    foreach($status as $k=>$v)
                    {
                        $lead_status[$k]['lead_stage'] = $v->name;
                        $lead_status[$k]['lead_total']      = count($v->lead());
                        $lead_status[$k]['lead_percentage'] = Utility::getCrmPercentage($lead_status[$k]['lead_total'], $total_leads);

                    }

                $crm_data['lead_status'] = $lead_status;

                //deal status
//                $user_deal   = $deals->pluck('deal_id')->toArray();
                $total_deals  = count($deals);
                $deal_status = [];
                $dealstatuss = Stage::select('stages.*', 'pipelines.name as pipeline')
                    ->join('pipelines', 'pipelines.id', '=', 'stages.pipeline_id')
                    ->where('pipelines.created_by', '=', \Auth::user()->creatorId())
                    ->where('stages.created_by', '=', \Auth::user()->creatorId())
                    ->orderBy('stages.pipeline_id')->get();
                foreach($dealstatuss as $k => $v)
                {
                    $deal_status[$k]['deal_stage'] = $v->name;
                    $deal_status[$k]['deal_total']      = count($v->deals());
                    $deal_status[$k]['deal_percentage'] = Utility::getCrmPercentage($deal_status[$k]['deal_total'], $total_deals);
                }
                $crm_data['deal_status'] = $deal_status;

                $crm_data['latestContract']  = Contract::where('created_by', '=', \Auth::user()->creatorId())->orderBy('id', 'desc')->limit(5)->with(['clients','projects','types'])->get();


                return view('dashboard.crm-dashboard', compact('crm_data'));
            }
        }
        else
        {
            return $this->account_dashboard_index();
        }
    }

    public function pos_dashboard_index()
    {
        $user = Auth::user();
        if(\Auth::user()->can('show pos dashboard'))
        {
            if($user->type == 'admin')
            {
                return view('admin.dashboard');
            }
            else
            {
                $pos_data=[];
                $pos_data['monthlyPosAmount'] = Pos::totalPosAmount(true);
                $pos_data['totalPosAmount'] = Pos::totalPosAmount();
                $pos_data['monthlyPurchaseAmount'] = Purchase::totalPurchaseAmount(true);
                $pos_data['totalPurchaseAmount'] = Purchase::totalPurchaseAmount();

                $purchasesArray = Purchase::getPurchaseReportChart();
                $posesArray = Pos::getPosReportChart();

                return view('dashboard.pos-dashboard',compact('pos_data','purchasesArray','posesArray'));
            }
        }
        else
        {
            return $this->account_dashboard_index();
        }
    }


    // Load Dashboard user's using ajax
    public function filterView(Request $request)
    {
        $usr   = Auth::user();
        $users = User::where('id', '!=', $usr->id);

        if($request->ajax())
        {
            if(!empty($request->keyword))
            {
                $users->where('name', 'LIKE', $request->keyword . '%')->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",skills)');
            }

            $users      = $users->get();
            $returnHTML = view('dashboard.view', compact('users'))->render();

            return response()->json([
                                        'success' => true,
                                        'html' => $returnHTML,
                                    ]);
        }
    }

    public function clientView()
    {

        if(Auth::check())
        {
            if(Auth::user()->type == 'super admin')
            {
                $user                       = \Auth::user();
                $user['total_user']         = $user->countCompany();
                $user['total_paid_user']    = $user->countPaidCompany();
                $user['total_orders']       = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $user['total_plan']         = Plan::total_plan();
                $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->total : 0);
                // $user['most_purchese_plan'] = Plan::most_purchese_plan()->total;
                $chartData                  = $this->getOrderChart(['duration' => 'week']);

                return view('dashboard.super_admin', compact('user', 'chartData'));

            }
            elseif(Auth::user()->type == 'client')
            {
                $transdate   = date('Y-m-d', time());
                $currentYear = date('Y');

                $calenderTasks = [];
                $chartData     = [];
                $arrCount      = [];
                $arrErr        = [];
                $m             = date("m");
                $de            = date("d");
                $y             = date("Y");
                $format        = 'Y-m-d';
                $user          = \Auth::user();
                if(\Auth::user()->can('View Task'))
                {
                    $company_setting = Utility::settings();
                }
                $arrTemp = [];
                for($i = 0; $i <= 7 - 1; $i++)
                {
                    $date                 = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
                    $arrTemp['date'][]    = __(date('D', strtotime($date)));
                    $arrTemp['invoice'][] = 10;
                    $arrTemp['payment'][] = 20;
                }

                $chartData = $arrTemp;

                foreach($user->clientDeals as $deal)
                {
                    foreach($deal->tasks as $task)
                    {
                        $calenderTasks[] = [
                            'title' => $task->name,
                            'start' => $task->date,
                            'url' => route('deals.tasks.show', [
                                $deal->id,
                                $task->id,
                            ]),
                            'className' => ($task->status) ? 'bg-primary border-primary' : 'bg-warning border-warning',
                        ];
                    }

                    $calenderTasks[] = [
                        'title' => $deal->name,
                        'start' => $deal->created_at->format('Y-m-d'),
                        'url' => route('deals.show', [$deal->id]),
                        'className' => 'deal bg-primary border-primary',
                    ];
                }
                $client_deal = $user->clientDeals->pluck('id');

                $arrCount['deal'] = !empty($user->clientDeals)? $user->clientDeals->count() : 0;


                if(!empty($client_deal->first()))
                {

                    $arrCount['task'] = DealTask::whereIn('deal_id', [$client_deal->first()])->count();


                }
                else
                {
                    $arrCount['task'] = 0;
                }


                $project['projects']             = Project::where('client_id', '=', Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->where('end_date', '>', date('Y-m-d'))->limit(5)->orderBy('end_date')->get();
                $project['projects_count']       = count($project['projects']);
                $user_projects                   = Project::where('client_id', \Auth::user()->id)->pluck('id', 'id')->toArray();
                $tasks                           = ProjectTask::whereIn('project_id', $user_projects)->where('created_by', \Auth::user()->creatorId())->get();
                $project['projects_tasks_count'] = count($tasks);
                $project['project_budget']       = Project::where('client_id', Auth::user()->id)->sum('budget');

                $project_last_stages      = Auth::user()->last_projectstage();
                $project_last_stage       = (!empty($project_last_stages) ? $project_last_stages->id : 0);
                $project['total_project'] = Auth::user()->user_project();
                $total_project_task       = Auth::user()->created_total_project_task();
                $allProject               = Project::where('client_id', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->get();
                $allProjectCount          = count($allProject);

                $bugs                               = Bug::whereIn('project_id', $user_projects)->where('created_by', \Auth::user()->creatorId())->get();
                $project['projects_bugs_count']     = count($bugs);
                $bug_last_stage                     = BugStatus::orderBy('order', 'DESC')->first();
                $completed_bugs                     = Bug::whereIn('project_id', $user_projects)->where('status', $bug_last_stage->id)->where('created_by', \Auth::user()->creatorId())->get();
                $allBugCount                        = count($bugs);
                $completedBugCount                  = count($completed_bugs);
                $project['project_bug_percentage']  = ($allBugCount != 0) ? intval(($completedBugCount / $allBugCount) * 100) : 0;
                $complete_task                      = Auth::user()->project_complete_task($project_last_stage);
                $completed_project                  = Project::where('client_id', \Auth::user()->id)->where('status', 'complete')->where('created_by', \Auth::user()->creatorId())->get();
                $completed_project_count            = count($completed_project);
                $project['project_percentage']      = ($allProjectCount != 0) ? intval(($completed_project_count / $allProjectCount) * 100) : 0;
                $project['project_task_percentage'] = ($total_project_task != 0) ? intval(($complete_task / $total_project_task) * 100) : 0;
                $invoice                            = [];
                $top_due_invoice                    = [];
                $invoice['total_invoice']           = 5;
                $complete_invoice                   = 0;
                $total_due_amount                   = 0;
                $top_due_invoice                    = array();
                $pay_amount                         = 0;

                if(Auth::user()->type == 'client')
                {
                    if(!empty($project['project_budget']))
                    {
                        $project['client_project_budget_due_per'] = intval(($pay_amount / $project['project_budget']) * 100);
                    }
                    else
                    {
                        $project['client_project_budget_due_per'] = 0;
                    }

                }

                $top_tasks       = Auth::user()->created_top_due_task();
                $users['staff']  = User::where('created_by', '=', Auth::user()->creatorId())->count();
                $users['user']   = User::where('created_by', '=', Auth::user()->creatorId())->where('type', '!=', 'client')->count();
                $users['client'] = User::where('created_by', '=', Auth::user()->creatorId())->where('type', '=', 'client')->count();
                $project_status  = array_values(Project::$project_status);
                $projectData     = \App\Models\Project::getProjectStatus();

                $taskData = \App\Models\TaskStage::getChartData();

                return view('dashboard.clientView', compact('calenderTasks', 'arrErr', 'arrCount', 'chartData', 'project', 'invoice', 'top_tasks', 'top_due_invoice', 'users', 'project_status', 'projectData', 'taskData', 'transdate', 'currentYear'));
            }
        }
    }

    public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if($arrParam['duration'])
        {
            if($arrParam['duration'] == 'week')
            {
                $previous_week = strtotime("-2 week +1 day");
                for($i = 0; $i < 14; $i++)
                {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }

        $arrTask          = [];
        $arrTask['label'] = [];
        $arrTask['data']  = [];
        foreach($arrDuration as $date => $label)
        {

            $data               = Order::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][]  = $data->total;
        }

        return $arrTask;
    }

    public function stopTracker(Request $request)
    {
        if(Auth::user()->isClient())
        {
            return Utility::error_res(__('Permission denied.'));
        }
        $validatorArray = [
            'name' => 'required|max:120',
            'project_id' => 'required|integer',
        ];
        $validator      = Validator::make(
            $request->all(), $validatorArray
        );
        if($validator->fails())
        {
            return Utility::error_res($validator->errors()->first());
        }
        $tracker = TimeTracker::where('created_by', '=', Auth::user()->id)->where('is_active', '=', 1)->first();
        if($tracker)
        {
            $tracker->end_time   = $request->has('end_time') ? $request->input('end_time') : date("Y-m-d H:i:s");
            $tracker->is_active  = 0;
            $tracker->total_time = Utility::diffance_to_time($tracker->start_time, $tracker->end_time);
            $tracker->save();

            return Utility::success_res(__('Add Time successfully.'));
        }

        return Utility::error_res('Tracker not found.');
    }



}
