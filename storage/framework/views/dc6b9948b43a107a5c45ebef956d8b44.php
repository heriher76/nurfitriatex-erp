<?php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();
    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_small_logo = $setting['company_small_logo'] ?? '';

    $emailTemplate = \App\Models\EmailTemplate::emailTemplateData();
    $lang = Auth::user()->lang;

    $userPlan = \App\Models\Plan::getPlan(\Auth::user()->show_dashboard());
?>

<?php if(isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on'): ?>
    <nav class="dash-sidebar light-sidebar transprent-bg">
    <?php else: ?>
        <nav class="dash-sidebar light-sidebar ">
<?php endif; ?>
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">
            

            <?php if($setting['cust_darklayout'] && $setting['cust_darklayout'] == 'on'): ?>
                <img src="<?php echo e($logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png')); ?>"
                    alt="<?php echo e(config('app.name', 'ERP')); ?>" class="logo logo-lg">
            <?php else: ?>
                <img src="<?php echo e($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png')); ?>"
                    alt="<?php echo e(config('app.name', 'ERP')); ?>" class="logo logo-lg">
            <?php endif; ?>

        </a>
    </div>
    <div class="navbar-content">
        <?php if(\Auth::user()->type != 'client'): ?>
            <ul class="dash-navbar">
                <!--------------------- Start Dashboard ----------------------------------->
                <?php if(Gate::check('show hrm dashboard') ||
                        Gate::check('show project dashboard') ||
                        Gate::check('show account dashboard') ||
                        Gate::check('show crm dashboard') ||
                        Gate::check('show pos dashboard')): ?>
                    <li
                        class="dash-item dash-hasmenu
                                <?php echo e(Request::segment(1) == null ||
                                Request::segment(1) == 'account-dashboard' ||
                                Request::segment(1) == 'income report' ||
                                Request::segment(1) == 'report' ||
                                Request::segment(1) == 'reports-monthly-cashflow' ||
                                Request::segment(1) == 'reports-quarterly-cashflow' ||
                                Request::segment(1) == 'reports-payroll' ||
                                Request::segment(1) == 'reports-leave' ||
                                Request::segment(1) == 'reports-monthly-attendance' ||
                                Request::segment(1) == 'reports-lead' ||
                                Request::segment(1) == 'reports-deal' ||
                                Request::segment(1) == 'pos-dashboard' ||
                                Request::segment(1) == 'reports-warehouse' ||
                                Request::segment(1) == 'reports-daily-purchase' ||
                                Request::segment(1) == 'reports-monthly-purchase' ||
                                Request::segment(1) == 'reports-daily-pos' ||
                                Request::segment(1) == 'reports-monthly-pos' ||
                                Request::segment(1) == 'reports-pos-vs-purchase'
                                    ? 'active dash-trigger'
                                    : ''); ?>">
                        <a href="#!" class="dash-link ">
                            <span class="dash-micon">
                                <i class="ti ti-home"></i>
                            </span>
                            <span class="dash-mtext"><?php echo e(__('Dashboard')); ?></span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if($userPlan->account == 1 && Gate::check('show account dashboard')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == null || Request::segment(1) == 'account-dashboard' || Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? ' active dash-trigger' : ''); ?>">
                                    <a class="dash-link" href="#"><?php echo e(__('Accounting ')); ?><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show account dashboard')): ?>
                                            <li
                                                class="dash-item <?php echo e(Request::segment(1) == null || Request::segment(1) == 'account-dashboard' ? ' active' : ''); ?>">
                                                <a class="dash-link"
                                                    href="<?php echo e(route('dashboard')); ?>"><?php echo e(__(' Overview')); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(Gate::check('income report') ||
                                                Gate::check('expense report') ||
                                                Gate::check('income vs expense report') ||
                                                Gate::check('tax report') ||
                                                Gate::check('loss & profit report') ||
                                                Gate::check('invoice report') ||
                                                Gate::check('bill report') ||
                                                Gate::check('stock report') ||
                                                Gate::check('invoice report') ||
                                                Gate::check('manage transaction') ||
                                                Gate::check('statement report')): ?>
                                            <li
                                                class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? 'active dash-trigger ' : ''); ?>">
                                                <a class="dash-link" href="#"><?php echo e(__('Reports')); ?><span
                                                        class="dash-arrow"><i
                                                            data-feather="chevron-right"></i></span></a>
                                                <ul class="dash-submenu">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('statement report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.account.statement' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.account.statement')); ?>"><?php echo e(__('Account Statement')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.invoice.summary' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.invoice.summary')); ?>"><?php echo e(__('Invoice Summary')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li
                                                        class="dash-item <?php echo e(Request::route()->getName() == 'report.sales' ? ' active' : ''); ?>">
                                                        <a class="dash-link"
                                                            href="<?php echo e(route('report.sales')); ?>"><?php echo e(__('Sales Report')); ?></a>
                                                    </li>
                                                    
                                                    
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill report')): ?>
                                                        
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.product.stock.report' ? ' active' : ''); ?>">
                                                            <a href="<?php echo e(route('report.product.stock.report')); ?>"
                                                                class="dash-link"><?php echo e(__('Product Stock')); ?></a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('loss & profit report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(request()->is('reports-monthly-cashflow') || request()->is('reports-quarterly-cashflow') ? 'active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.monthly.cashflow')); ?>"><?php echo e(__('Cash Flow')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage transaction')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('transaction.index')); ?>"><?php echo e(__('Transaction')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.income.summary' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.income.summary')); ?>"><?php echo e(__('Income Summary')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expense report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.expense.summary' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.expense.summary')); ?>"><?php echo e(__('Expense Summary')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income vs expense report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.income.vs.expense.summary' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.income.vs.expense.summary')); ?>"><?php echo e(__('Income VS Expense')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tax report')): ?>
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'report.tax.summary' ? ' active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.tax.summary')); ?>"><?php echo e(__('Tax Summary')); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <?php if($userPlan->hrm == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show hrm dashboard')): ?>
                                    <li
                                        class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'hrm-dashboard' || Request::segment(1) == 'reports-payroll' ? ' active dash-trigger' : ''); ?>">
                                        <a class="dash-link" href="#"><?php echo e(__('HRM ')); ?><span class="dash-arrow"><i
                                                    data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            <li
                                                class="dash-item <?php echo e(\Request::route()->getName() == 'hrm.dashboard' ? ' active' : ''); ?>">
                                                <a class="dash-link"
                                                    href="<?php echo e(route('hrm.dashboard')); ?>"><?php echo e(__(' Overview')); ?></a>
                                            </li>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage report')): ?>
                                                <li class="dash-item dash-hasmenu
                                                                    <?php echo e(Request::segment(1) == 'reports-monthly-attendance' ||
                                                                    Request::segment(1) == 'reports-leave' ||
                                                                    Request::segment(1) == 'reports-payroll'
                                                                        ? 'active dash-trigger'
                                                                        : ''); ?>"
                                                    href="#hr-report" data-toggle="collapse" role="button"
                                                    aria-expanded="<?php echo e(Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll' ? 'true' : 'false'); ?>">
                                                    <a class="dash-link" href="#"><?php echo e(__('Reports')); ?><span
                                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                                    <ul class="dash-submenu">
                                                        <li
                                                            class="dash-item <?php echo e(request()->is('reports-payroll') ? 'active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.payroll')); ?>"><?php echo e(__('Payroll')); ?></a>
                                                        </li>
                                                        <li
                                                            class="dash-item <?php echo e(request()->is('reports-leave') ? 'active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.leave')); ?>"><?php echo e(__('Leave')); ?></a>
                                                        </li>
                                                        <li
                                                            class="dash-item <?php echo e(request()->is('reports-monthly-attendance') ? 'active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('report.monthly.attendance')); ?>"><?php echo e(__('Monthly Attendance')); ?></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($userPlan->crm == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show crm dashboard')): ?>
                                    
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($userPlan->project == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show project dashboard')): ?>
                                    <li
                                        class="dash-item <?php echo e(Request::route()->getName() == 'project.dashboard' ? ' active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('project.dashboard')); ?>"><?php echo e(__('Project ')); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show hrm dashboard')): ?>
                                    <li
                                        class="dash-item <?php echo e(Request::route()->getName() == 'manage_activity.dashboard' ? ' active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('manage_activity.dashboard')); ?>"><?php echo e(__('Activity ')); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show hrm dashboard')): ?>
                                    <li
                                        class="dash-item <?php echo e(Request::route()->getName() == 'material.dashboard' ? ' active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('material.dashboard')); ?>"><?php echo e(__('Material ')); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($userPlan->pos == 1): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show pos dashboard')): ?>
                                    
                                <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
                <!--------------------- End Dashboard ----------------------------------->


                <!--------------------- Start HRM ----------------------------------->

                <?php if(!empty($userPlan) && $userPlan->hrm == 1): ?>
                    <?php if(Gate::check('manage employee') || Gate::check('manage setsalary')): ?>
                        <li
                            class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'holiday-calender' ||
                            Request::segment(1) == 'leavetype' ||
                            Request::segment(1) == 'leave' ||
                            Request::segment(1) == 'attendanceemployee' ||
                            Request::segment(1) == 'document-upload' ||
                            Request::segment(1) == 'document' ||
                            Request::segment(1) == 'performanceType' ||
                            Request::segment(1) == 'branch' ||
                            Request::segment(1) == 'department' ||
                            Request::segment(1) == 'designation' ||
                            Request::segment(1) == 'employee' ||
                            Request::segment(1) == 'leave_requests' ||
                            Request::segment(1) == 'holidays' ||
                            Request::segment(1) == 'policies' ||
                            Request::segment(1) == 'leave_calender' ||
                            Request::segment(1) == 'award' ||
                            Request::segment(1) == 'transfer' ||
                            Request::segment(1) == 'resignation' ||
                            Request::segment(1) == 'training' ||
                            Request::segment(1) == 'travel' ||
                            Request::segment(1) == 'promotion' ||
                            Request::segment(1) == 'complaint' ||
                            Request::segment(1) == 'warning' ||
                            Request::segment(1) == 'termination' ||
                            Request::segment(1) == 'announcement' ||
                            Request::segment(1) == 'job' ||
                            Request::segment(1) == 'job-application' ||
                            Request::segment(1) == 'candidates-job-applications' ||
                            Request::segment(1) == 'job-onboard' ||
                            Request::segment(1) == 'custom-question' ||
                            Request::segment(1) == 'interview-schedule' ||
                            Request::segment(1) == 'career' ||
                            Request::segment(1) == 'holiday' ||
                            Request::segment(1) == 'setsalary' ||
                            Request::segment(1) == 'payslip' ||
                            Request::segment(1) == 'paysliptype' ||
                            Request::segment(1) == 'company-policy' ||
                            Request::segment(1) == 'job-stage' ||
                            Request::segment(1) == 'job-category' ||
                            Request::segment(1) == 'terminationtype' ||
                            Request::segment(1) == 'awardtype' ||
                            Request::segment(1) == 'trainingtype' ||
                            Request::segment(1) == 'goaltype' ||
                            Request::segment(1) == 'paysliptype' ||
                            Request::segment(1) == 'allowanceoption' ||
                            Request::segment(1) == 'competencies' ||
                            Request::segment(1) == 'loanoption' ||
                            Request::segment(1) == 'deductionoption'
                                ? 'active dash-trigger'
                                : ''); ?>">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="dash-mtext">
                                    <?php echo e(__('HRM System')); ?>

                                </span>
                                <span class="dash-arrow">
                                    <i data-feather="chevron-right"></i>
                                </span>
                            </a>
                            <ul class="dash-submenu">
                                <li
                                    class="dash-item  <?php echo e(Request::segment(1) == 'employee' ? 'active dash-trigger' : ''); ?>   ">
                                    <?php if(\Auth::user()->type == 'Employee'): ?>
                                        <?php
                                            $employee = App\Models\Employee::where(
                                                'user_id',
                                                \Auth::user()->id,
                                            )->first();
                                        ?>
                                        <a class="dash-link"
                                            href="<?php echo e(route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"><?php echo e(__('Employee')); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('employee.index')); ?>" class="dash-link">
                                            <?php echo e(__('Employee Setup')); ?>

                                        </a>
                                    <?php endif; ?>
                                </li>

                                <?php if(Gate::check('manage set salary') || Gate::check('manage pay slip')): ?>
                                    <li
                                        class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip' ? 'active dash-trigger' : ''); ?>">
                                        <a class="dash-link" href="#"><?php echo e(__('Payroll Setup')); ?><span
                                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage set salary')): ?>
                                                <li class="dash-item <?php echo e(request()->is('setsalary*') ? 'active' : ''); ?>">
                                                    <a class="dash-link"
                                                        href="<?php echo e(route('setsalary.index')); ?>"><?php echo e(__('Set salary')); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage pay slip')): ?>
                                                <li class="dash-item <?php echo e(request()->is('payslip*') ? 'active' : ''); ?>">
                                                    <a class="dash-link"
                                                        href="<?php echo e(route('payslip.index')); ?>"><?php echo e(__('Payslip')); ?></a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <?php if(Gate::check('manage leave') || Gate::check('manage attendance')): ?>
                                    <li
                                        class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee' ? 'active dash-trigger' : ''); ?>">
                                        <a class="dash-link" href="#"><?php echo e(__('Leave Management Setup')); ?><span
                                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage leave')): ?>
                                                <li
                                                    class="dash-item <?php echo e(Request::route()->getName() == 'leave.index' ? 'active' : ''); ?>">
                                                    <a class="dash-link"
                                                        href="<?php echo e(route('leave.index')); ?>"><?php echo e(__('Manage Leave')); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage attendance')): ?>
                                                <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'attendanceemployee' ? 'active dash-trigger' : ''); ?>"
                                                    href="#navbar-attendance" data-toggle="collapse" role="button"
                                                    aria-expanded="<?php echo e(Request::segment(1) == 'attendanceemployee' ? 'true' : 'false'); ?>">
                                                    <a class="dash-link" href="#"><?php echo e(__('Attendance')); ?><span
                                                            class="dash-arrow"><i
                                                                data-feather="chevron-right"></i></span></a>
                                                    <ul class="dash-submenu">
                                                        <li
                                                            class="dash-item <?php echo e(Request::route()->getName() == 'attendanceemployee.index' ? 'active' : ''); ?>">
                                                            <a class="dash-link"
                                                                href="<?php echo e(route('attendanceemployee.index')); ?>"><?php echo e(__('Mark Attendance')); ?></a>
                                                        </li>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create attendance')): ?>
                                                            <li
                                                                class="dash-item <?php echo e(Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'active' : ''); ?>">
                                                                <a class="dash-link"
                                                                    href="<?php echo e(route('attendanceemployee.bulkattendance')); ?>"><?php echo e(__('Bulk Attendance')); ?></a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>

                                <?php if(Gate::check('manage indicator') || Gate::check('manage appraisal') || Gate::check('manage goal tracking')): ?>
                                    
                                <?php endif; ?>

                                <?php if(Gate::check('manage training') || Gate::check('manage trainer') || Gate::check('show training')): ?>
                                    
                                <?php endif; ?>

                                <?php if(Gate::check('manage job') ||
                                        Gate::check('create job') ||
                                        Gate::check('manage job application') ||
                                        Gate::check('manage custom question') ||
                                        Gate::check('show interview schedule') ||
                                        Gate::check('show career')): ?>
                                    
                                <?php endif; ?>

                                <?php if(Gate::check('manage award') ||
                                        Gate::check('manage transfer') ||
                                        Gate::check('manage resignation') ||
                                        Gate::check('manage travel') ||
                                        Gate::check('manage promotion') ||
                                        Gate::check('manage complaint') ||
                                        Gate::check('manage warning') ||
                                        Gate::check('manage termination') ||
                                        Gate::check('manage announcement') ||
                                        Gate::check('manage holiday')): ?>
                                    
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage event')): ?>
                                    <li class="dash-item <?php echo e(request()->is('event*') ? 'active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('event.index')); ?>"><?php echo e(__('Event Setup')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage meeting')): ?>
                                    <li class="dash-item <?php echo e(request()->is('meeting*') ? 'active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('meeting.index')); ?>"><?php echo e(__('Meeting')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage assets')): ?>
                                    <li class="dash-item <?php echo e(request()->is('account-assets*') ? 'active' : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('account-assets.index')); ?>"><?php echo e(__('Employees Asset Setup ')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage document')): ?>
                                    
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage company policy')): ?>
                                    
                                <?php endif; ?>

                                <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'HR'): ?>
                                    <li
                                        class="dash-item <?php echo e(Request::segment(1) == 'leavetype' ||
                                        Request::segment(1) == 'document' ||
                                        Request::segment(1) == 'performanceType' ||
                                        Request::segment(1) == 'branch' ||
                                        Request::segment(1) == 'department' ||
                                        Request::segment(1) == 'designation' ||
                                        Request::segment(1) == 'job-stage' ||
                                        Request::segment(1) == 'performanceType' ||
                                        Request::segment(1) == 'job-category' ||
                                        Request::segment(1) == 'terminationtype' ||
                                        Request::segment(1) == 'awardtype' ||
                                        Request::segment(1) == 'trainingtype' ||
                                        Request::segment(1) == 'goaltype' ||
                                        Request::segment(1) == 'paysliptype' ||
                                        Request::segment(1) == 'allowanceoption' ||
                                        Request::segment(1) == 'loanoption' ||
                                        Request::segment(1) == 'deductionoption'
                                            ? 'active dash-trigger'
                                            : ''); ?>">
                                        <a class="dash-link"
                                            href="<?php echo e(route('branch.index')); ?>"><?php echo e(__('HRM System Setup')); ?></a>
                                    </li>
                                <?php endif; ?>


                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!--------------------- End HRM ----------------------------------->

            <!--------------------- Start Account ----------------------------------->

            <?php if(!empty($userPlan) && $userPlan->account == 1): ?>
                <?php if(Gate::check('manage customer') ||
                        Gate::check('manage vender') ||
                        Gate::check('manage customer') ||
                        Gate::check('manage vender') ||
                        Gate::check('manage proposal') ||
                        Gate::check('manage bank account') ||
                        Gate::check('manage bank transfer') ||
                        Gate::check('manage invoice') ||
                        Gate::check('manage revenue') ||
                        Gate::check('manage credit note') ||
                        Gate::check('manage bill') ||
                        Gate::check('manage payment') ||
                        Gate::check('manage debit note') ||
                        Gate::check('manage chart of account') ||
                        Gate::check('manage journal entry') ||
                        Gate::check('balance sheet report') ||
                        Gate::check('ledger report') ||
                        Gate::check('trial balance report')): ?>
                    <li
                        class="dash-item dash-hasmenu
                                     <?php echo e(Request::route()->getName() == 'print-setting' ||
                                     Request::segment(1) == 'customer' ||
                                     Request::segment(1) == 'vender' ||
                                     Request::segment(1) == 'proposal' ||
                                     Request::segment(1) == 'bank-account' ||
                                     Request::segment(1) == 'bank-transfer' ||
                                     Request::segment(1) == 'invoice' ||
                                     Request::segment(1) == 'revenue' ||
                                     Request::segment(1) == 'credit-note' ||
                                     Request::segment(1) == 'taxes' ||
                                     Request::segment(1) == 'product-category' ||
                                     Request::segment(1) == 'product-unit' ||
                                     Request::segment(1) == 'payment-method' ||
                                     Request::segment(1) == 'custom-field' ||
                                     Request::segment(1) == 'chart-of-account-type' ||
                                     (Request::segment(1) == 'transaction' &&
                                         Request::segment(2) != 'ledger' &&
                                         Request::segment(2) != 'balance-sheet' &&
                                         Request::segment(2) != 'trial-balance') ||
                                     Request::segment(1) == 'goal' ||
                                     Request::segment(1) == 'budget' ||
                                     Request::segment(1) == 'chart-of-account' ||
                                     Request::segment(1) == 'journal-entry' ||
                                     Request::segment(2) == 'ledger' ||
                                     Request::segment(2) == 'balance-sheet' ||
                                     Request::segment(2) == 'trial-balance' ||
                                     Request::segment(2) == 'profit-loss' ||
                                     Request::segment(1) == 'bill' ||
                                     Request::segment(1) == 'expense' ||
                                     Request::segment(1) == 'payment' ||
                                     Request::segment(1) == 'debit-note'
                                         ? ' active dash-trigger'
                                         : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-box"></i></span><span
                                class="dash-mtext"><?php echo e(__('Accounting System ')); ?>

                            </span><span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">

                            <?php if(Gate::check('manage bank account') || Gate::check('manage bank transfer')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer' ? 'active dash-trigger' : ''); ?>">
                                    <a class="dash-link" href="#"><?php echo e(__('Banking')); ?><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <li
                                            class="dash-item <?php echo e(Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit' ? ' active' : ''); ?>">
                                            <a class="dash-link"
                                                href="<?php echo e(route('bank-account.index')); ?>"><?php echo e(__('Account')); ?></a>
                                        </li>
                                        <li
                                            class="dash-item <?php echo e(Request::route()->getName() == 'bank-transfer.index' || Request::route()->getName() == 'bank-transfer.create' || Request::route()->getName() == 'bank-transfer.edit' ? ' active' : ''); ?>">
                                            <a class="dash-link"
                                                href="<?php echo e(route('bank-transfer.index')); ?>"><?php echo e(__('Transfer')); ?></a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage customer') ||
                                    Gate::check('manage proposal') ||
                                    Gate::check('manage invoice') ||
                                    Gate::check('manage revenue') ||
                                    Gate::check('manage credit note')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'customer' || Request::segment(1) == 'proposal' || Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note' ? 'active dash-trigger' : ''); ?>">
                                    <a class="dash-link" href="#"><?php echo e(__('Sales')); ?><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <?php if(Gate::check('manage customer')): ?>
                                            <li
                                                class="dash-item <?php echo e(Request::segment(1) == 'customer' ? 'active' : ''); ?>">
                                                <a class="dash-link"
                                                    href="<?php echo e(route('customer.index')); ?>"><?php echo e(__('Customer')); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(Gate::check('manage proposal')): ?>
                                            
                                        <?php endif; ?>
                                        <li
                                            class="dash-item <?php echo e(Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show' ? ' active' : ''); ?>">
                                            <a class="dash-link"
                                                href="<?php echo e(route('invoice.index')); ?>"><?php echo e(__('Invoice')); ?></a>
                                        </li>
                                        <li
                                            class="dash-item <?php echo e(Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit' ? ' active' : ''); ?>">
                                            <a class="dash-link"
                                                href="<?php echo e(route('revenue.index')); ?>"><?php echo e(__('Revenue')); ?></a>
                                        </li>
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage vender') ||
                                    Gate::check('manage bill') ||
                                    Gate::check('manage payment') ||
                                    Gate::check('manage debit note')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'bill' || Request::segment(1) == 'vender' || Request::segment(1) == 'expense' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note' ? 'active dash-trigger' : ''); ?>">
                                    <a class="dash-link" href="#"><?php echo e(__('Purchases')); ?><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <?php if(Gate::check('manage vender')): ?>
                                            
                                        <?php endif; ?>
                                        
                                        
                                        <li
                                            class="dash-item <?php echo e(Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit' ? ' active' : ''); ?>">
                                            <a class="dash-link"
                                                href="<?php echo e(route('payment.index')); ?>"><?php echo e(__('Payment')); ?></a>
                                        </li>
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage chart of account') ||
                                    Gate::check('manage journal entry') ||
                                    Gate::check('balance sheet report') ||
                                    Gate::check('ledger report') ||
                                    Gate::check('trial balance report')): ?>
                                
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'company'): ?>
                                
                            <?php endif; ?>
                            <?php if(Gate::check('manage goal')): ?>
                                
                            <?php endif; ?>
                            <?php if(Gate::check('manage constant tax') ||
                                    Gate::check('manage constant category') ||
                                    Gate::check('manage constant unit') ||
                                    Gate::check('manage constant payment method') ||
                                    Gate::check('manage constant custom field')): ?>
                                <li
                                    class="dash-item <?php echo e(Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ? 'active dash-trigger' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('taxes.index')); ?>"><?php echo e(__('Accounting Setup')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Gate::check('manage print settings')): ?>
                                <li
                                    class="dash-item <?php echo e(Request::route()->getName() == 'print-setting' ? ' active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('print.setting')); ?>"><?php echo e(__('Print Settings')); ?></a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!--------------------- End Account ----------------------------------->

            <!--------------------- Start CRM ----------------------------------->

            <?php if(!empty($userPlan) && $userPlan->crm == 1): ?>
                <?php if(Gate::check('manage lead') ||
                        Gate::check('manage deal') ||
                        Gate::check('manage form builder') ||
                        Gate::check('manage contract')): ?>
                    
                <?php endif; ?>
            <?php endif; ?>

            <!--------------------- End CRM ----------------------------------->

            <!--------------------- Start Project ----------------------------------->

            <?php if(!empty($userPlan) && $userPlan->project == 1): ?>
                <?php if(Gate::check('manage project')): ?>
                    
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-check"></i></span><span
                                class="dash-mtext"><?php echo e(__('Manage Activity')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('projects.index')); ?>?channel=activity"><?php echo e(__('Projects')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('taskBoard.view', 'list')); ?>?channel=activity"><?php echo e(__('Tasks')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage timesheet')): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bug report')): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('task.calendar', ['all'])); ?>?channel=activity"><?php echo e(__('Task Calendar')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type != 'super admin'): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('project_report.index')); ?>?channel=activity"><?php echo e(__('Project Report')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(\Auth::user()->type == 'company' && Gate::check('manage project task stage')): ?>
                                
                                
                                
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-share"></i></span><span
                                class="dash-mtext"><?php echo e(__('Project System')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('projects.index')); ?>#"><?php echo e(__('Projects')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li class="dash-item <?php echo e(request()->is('taskboard*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('taskBoard.view', 'list')); ?>#"><?php echo e(__('Tasks')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage timesheet')): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bug report')): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li class="dash-item <?php echo e(request()->is('calendar*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('task.calendar', ['all'])); ?>#"><?php echo e(__('Task Calendar')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type != 'super admin'): ?>
                                
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task')): ?>
                                <li
                                    class="dash-item  <?php echo e(Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('project_report.index')); ?>#"><?php echo e(__('Project Report')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(\Auth::user()->type == 'company' && Gate::check('manage project task stage')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages' ? 'active dash-trigger' : ''); ?>">
                                    <a class="dash-link" href="#"><?php echo e(__('Project System Setup')); ?><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project task stage')): ?>
                                            <li
                                                class="dash-item  <?php echo e(Request::route()->getName() == 'project-task-stages.index' ? 'active' : ''); ?>">
                                                <a class="dash-link"
                                                    href="<?php echo e(route('project-task-stages.index')); ?>"><?php echo e(__('Project Task Stages')); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage bug status')): ?>
                                            
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <!--------------------- End Project ----------------------------------->



            <!--------------------- Start User Managaement System ----------------------------------->

            <?php if(
                \Auth::user()->type != 'super admin' &&
                    (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client'))): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'users' ||
                    Request::segment(1) == 'roles' ||
                    Request::segment(1) == 'clients' ||
                    Request::segment(1) == 'userlogs'
                        ? ' active dash-trigger'
                        : ''); ?>">

                    <a href="#!" class="dash-link "><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span
                            class="dash-mtext"><?php echo e(__('User Management')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage user')): ?>
                            <li
                                class="dash-item <?php echo e(Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : ''); ?>">
                                <a class="dash-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('User')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage role')): ?>
                            <li
                                class="dash-item <?php echo e(Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit' ? ' active' : ''); ?> ">
                                <a class="dash-link" href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Role')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage client')): ?>
                            <li
                                class="dash-item <?php echo e(Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : ''); ?>">
                                <a class="dash-link" href="<?php echo e(route('clients.index')); ?>"><?php echo e(__('Client')); ?></a>
                            </li>
                        <?php endif; ?>
                        
                        
                        
                        
                        
                    </ul>
                </li>
            <?php endif; ?>

            <!--------------------- End User Managaement System----------------------------------->


            <!--------------------- Start Products System ----------------------------------->

            <?php if(Gate::check('manage product & service')): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link ">
                        <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span><span
                            class="dash-mtext"><?php echo e(__('Products System')); ?></span><span class="dash-arrow">
                            <i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        <?php if(Gate::check('manage product & service')): ?>
                            <li class="dash-item <?php echo e(Request::segment(1) == 'productservice' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('productservice.index')); ?>"
                                    class="dash-link"><?php echo e(__('Product & Services')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Gate::check('manage product & service')): ?>
                            <li class="dash-item <?php echo e(Request::segment(1) == 'productstock' ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('productstock.index')); ?>"
                                    class="dash-link"><?php echo e(__('Product Stock')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <!--------------------- End Products System ----------------------------------->


            <!--------------------- Start POs System ----------------------------------->
            <?php if(!empty($userPlan) && $userPlan->pos == 1): ?>
                <?php if(Gate::check('manage warehouse') ||
                        Gate::check('manage purchase') ||
                        Gate::check('manage pos') ||
                        Gate::check('manage print settings')): ?>
                    
                <?php endif; ?>
            <?php endif; ?>
            <!--------------------- End POs System ----------------------------------->

            <?php if(\Auth::user()->type != 'super admin'): ?>
                <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'support' ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('support.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-headphones"></i></span><span
                            class="dash-mtext"><?php echo e(__('Support System')); ?></span>
                    </a>
                </li>
                
                
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company'): ?>
                
            <?php endif; ?>

            <!--------------------- Start System Setup ----------------------------------->

            <?php if(\Auth::user()->type != 'super admin'): ?>
                <?php if(Gate::check('manage company plan') || Gate::check('manage order') || Gate::check('manage company settings')): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'settings' ||
                        Request::segment(1) == 'plans' ||
                        Request::segment(1) == 'stripe' ||
                        Request::segment(1) == 'order'
                            ? ' active dash-trigger'
                            : ''); ?>">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-settings"></i></span><span
                                class="dash-mtext"><?php echo e(__('Settings')); ?></span>
                            <span class="dash-arrow">
                                <i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            <?php if(Gate::check('manage company settings')): ?>
                                <li
                                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'settings' ? ' active' : ''); ?>">
                                    <a href="<?php echo e(route('settings')); ?>"
                                        class="dash-link"><?php echo e(__('System Settings')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage company plan')): ?>
                                
                            <?php endif; ?>

                            <?php if(Gate::check('manage order') && Auth::user()->type == 'company'): ?>
                                
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>




            <!--------------------- End System Setup ----------------------------------->
        </ul>
    <?php endif; ?>
    <?php if(\Auth::user()->type == 'client'): ?>
        <ul class="dash-navbar">
            <?php if(Gate::check('manage client dashboard')): ?>
                <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'dashboard' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('client.dashboard.view')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext"><?php echo e(__('Dashboard')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage deal')): ?>
                
            <?php endif; ?>
            <?php if(Gate::check('manage contract')): ?>
                
            <?php endif; ?>
            <?php if(Gate::check('manage project')): ?>
                <li class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'projects' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('projects.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-share"></i></span><span
                            class="dash-mtext"><?php echo e(__('Project')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(Gate::check('manage project')): ?>
                <li
                    class="dash-item  <?php echo e(Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : ''); ?>">
                    <a class="dash-link" href="<?php echo e(route('project_report.index')); ?>">
                        <span class="dash-micon"><i class="ti ti-chart-line"></i></span><span
                            class="dash-mtext"><?php echo e(__('Project Report')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(Gate::check('manage project task')): ?>
                <li class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'taskboard' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('taskBoard.view', 'list')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-list-check"></i></span><span
                            class="dash-mtext"><?php echo e(__('Tasks')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(Gate::check('manage bug report')): ?>
                
            <?php endif; ?>

            <?php if(Gate::check('manage timesheet')): ?>
                
            <?php endif; ?>

            <?php if(Gate::check('manage project task')): ?>
                <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'calendar' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('task.calendar', ['all'])); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-calendar"></i></span><span
                            class="dash-mtext"><?php echo e(__('Task Calender')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="dash-item dash-hasmenu">
                <a href="<?php echo e(route('support.index')); ?>"
                    class="dash-link <?php echo e(Request::segment(1) == 'support' ? 'active' : ''); ?>">
                    <span class="dash-micon"><i class="ti ti-headphones"></i></span><span
                        class="dash-mtext"><?php echo e(__('Support')); ?></span>
                </a>
            </li>
        </ul>
    <?php endif; ?>
    <?php if(\Auth::user()->type == 'super admin'): ?>
        <ul class="dash-navbar">
            <?php if(Gate::check('manage super admin dashboard')): ?>
                <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'dashboard' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('client.dashboard.view')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext"><?php echo e(__('Dashboard')); ?></span>
                    </a>
                </li>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage user')): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('users.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-users"></i></span><span
                            class="dash-mtext"><?php echo e(__('User')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(Gate::check('manage plan')): ?>
                
            <?php endif; ?>
            <?php if(\Auth::user()->type == 'super admin'): ?>
                
            <?php endif; ?>
            <?php if(Gate::check('manage coupon')): ?>
                
            <?php endif; ?>
            <?php if(Gate::check('manage order')): ?>
                
            <?php endif; ?>
            <li
                class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed'); ?>">
                <a href="<?php echo e(route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang])); ?>"
                    class="dash-link">
                    <span class="dash-micon"><i class="ti ti-template"></i></span>
                    <span class="dash-mtext"><?php echo e(__('Email Template')); ?></span>
                </a>
            </li>

            <?php if(\Auth::user()->type == 'super admin'): ?>
                <?php echo $__env->make('landingpage::menu.landingpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(Gate::check('manage system settings')): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::route()->getName() == 'systems.index' ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('systems.index')); ?>" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-settings"></i></span><span
                            class="dash-mtext"><?php echo e(__('Settings')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    <?php endif; ?>


    
</div>
</div>
</nav>
<?php /**PATH /Applications/MAMP/htdocs/erp-sakka/resources/views/partials/admin/menu.blade.php ENDPATH**/ ?>