<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyActivity;
use App\Models\DailyActivityReply;
use App\Models\SupportReply;
// use App\Models\Ticket;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class DailyActivityController extends Controller
{
    public function index()
    {
        // if(\Auth::user()->type == 'company')
        // {
        $supports = DailyActivity::with(['createdBy'])->get();
        $countTicket      = DailyActivity::where('created_by', '=', \Auth::user()->creatorId())->count();
        $countOpenTicket  = DailyActivity::where('status', '=', 'open')->where('created_by', '=', \Auth::user()->creatorId())->count();
        $countonholdTicket  = DailyActivity::where('status', '=', 'on hold')->where('created_by', '=', \Auth::user()->creatorId())->count();
        $countCloseTicket = DailyActivity::where('status', '=', 'close')->where('created_by', '=', \Auth::user()->creatorId())->count();
        return view('daily_activity.index', compact('supports','countTicket','countOpenTicket','countonholdTicket','countCloseTicket'));
        // }
        // else {

        //     $supports = DailyActivity::where('user', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->with(['createdBy','assignUser'])->get();
        //     $countTicket      = DailyActivity::where('user', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->count();
        //     $countOpenTicket  = DailyActivity::where('status', '=', 'open')->where('user', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->count();
        //     $countonholdTicket  = DailyActivity::where('status', '=', 'on hold')->where('user', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->count();
        //     $countCloseTicket = DailyActivity::where('status', '=', 'close')->where('user', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->count();
        //     return view('daily_activity.index', compact('supports','countTicket','countOpenTicket','countonholdTicket','countCloseTicket'));
        // }

    }

    public function create()
    {
        $priority = [
            __('Low'),
            __('Medium'),
            __('High'),
            __('Critical'),
        ];
        //$status = DailyActivity::$status;
        $status = DailyActivity::status();
        $users = User::where('created_by', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');

        return view('daily_activity.create', compact('priority', 'users','status'));
    }


    public function store(Request $request)
    {
        $support              = new DailyActivity();
        $support->subject     = $request->subject;
        $support->end_date    = $request->end_date;
        $support->status      = 'open';

        if(!empty($request->attachment))
        {
            //storage limit
            $image_size = $request->file('attachment')->getSize();
            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

            if($result==1)
            {
                if($support->attachment)
                {
                    $path = storage_path('uploads/supports' . $support->attachment);
                    if(file_exists($path))
                    {
                        \File::delete($path);
                    }
                }
                $fileName = time() . "_" . $request->attachment->getClientOriginalName();
                $support->attachment = $fileName;
                $dir        = 'uploads/supports';
                $path = Utility::upload_file($request,'attachment',$fileName,$dir,[]);
                if($path['flag']==0){
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }


        }

        $support->description    = $request->description;
        $support->created_by     = \Auth::user()->id;
        // if(\Auth::user()->type == 'client')
        // {
        $support->user = \Auth::user()->id;;
        // }
        // else
        // {
        //     $request->user= $request->user;
        // }

        $support->save();

        return redirect()->route('daily_activity.index')->with('success', __('Daily Activity successfully added.') .((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : '') );



    }


    public function show(DailyActivity $support)
    {
        //
    }


    public function edit(DailyActivity $daily_activity)
    {
        $priority = [
            __('Low'),
            __('Medium'),
            __('High'),
            __('Critical'),
        ];
        //$status = DailyActivity::$status;
        $status = DailyActivity::status();
        $users = User::where('created_by', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');

        return view('daily_activity.edit', compact('priority', 'users', 'daily_activity','status'));
    }


    public function update(Request $request, DailyActivity $daily_activity)
    {
        $daily_activity->subject  = $request->subject;
        $daily_activity->end_date = $request->end_date;
        if(!empty($request->attachment))
        {
            //storage limit
            $file_path = '/uploads/supports/'.$daily_activity->attachment;
            $image_size = $request->file('attachment')->getSize();
            $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

            if($result==1)
            {
                if($daily_activity->attachment)
                {
                    Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

                    $path = storage_path('uploads/supports' . $daily_activity->attachment);
                    if(file_exists($path))
                    {
                        \File::delete($path);
                    }
                }
                $fileName = time() . "_" . $request->attachment->getClientOriginalName();
                $daily_activity->attachment = $fileName;
                $dir        = 'uploads/supports';
                $path = Utility::upload_file($request,'attachment',$fileName,$dir,[]);
                if($path['flag']==0){
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

        }
        $daily_activity->description = $request->description;

        $daily_activity->save();

        return redirect()->route('daily_activity.index')->with('success', __('DailyActivity successfully updated.'));

    }


    public function destroy(DailyActivity $daily_activity)
    {
        $daily_activity->delete();
        if($daily_activity->attachment)
        {
            //storage limit
            $file_path = '/uploads/supports/'.$daily_activity->attachment;
            $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

            \File::delete(storage_path('uploads/supports/' . $daily_activity->attachment));
        }

        return redirect()->route('daily_activity.index')->with('success', __('DailyActivity successfully deleted.'));

    }

    public function reply($ids)
    {
        try {
            $id              = Crypt::decrypt($ids);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Daily Activity Not Found.'));
        }
        $id      = \Crypt::decrypt($ids);
        $replyes = DailyActivityReply::where('daily_activity_id', $id)->with(['users'])->get();
        $support = DailyActivity::with(['createdBy'])->find($id);

        foreach($replyes as $reply)
        {
            $supportReply          = DailyActivityReply::find($reply->id);
            $supportReply->is_read = 1;
            $supportReply->save();
        }

        return view('daily_activity.reply', compact('support', 'replyes'));
    }

    public function replyAnswer(Request $request, $id)
    {
        $supportReply              = new DailyActivityReply();
        $supportReply->daily_activity_id  = $id;
        $supportReply->user        = \Auth::user()->id;
        $supportReply->description = $request->description;
        $supportReply->created_by  = \Auth::user()->creatorId();
        $supportReply->save();

        return redirect()->back()->with('success', __('DailyActivity reply successfully send.'));
    }

    public function grid()
    {

        if(\Auth::user()->type == 'company')
        {
            $supports = DailyActivity::where('created_by', \Auth::user()->creatorId())->with(['assignUser','createdBy'])->get();

            return view('daily_activity.grid', compact('supports'));
        }
        elseif(\Auth::user()->type == 'client')
        {
            $supports = DailyActivity::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->with(['assignUser','createdBy'])->get();

            return view('daily_activity.grid', compact('supports'));
        }
        elseif(\Auth::user()->type == 'Employee')
        {

            $supports = DailyActivity::where('user', \Auth::user()->id)->orWhere('ticket_created', \Auth::user()->id)->with(['assignUser','createdBy'])->get();

            return view('daily_activity.grid', compact('supports'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
