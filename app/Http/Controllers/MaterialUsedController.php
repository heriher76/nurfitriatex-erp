<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\MaterialUsed;
use App\Models\ProjectUser;
use App\Models\ProductService;
use App\Models\ActivityLog;
use App\Models\User;
use Auth;

class MaterialUsedController extends Controller
{
    public function material_used($project_id)
    {
        $user = Auth::user();
        // if($user->can('manage bug report'))
        // {
        $project = Project::find($project_id);

        if(!empty($project))
        {

            if($user->type != 'company')
            {
                if(\Auth::user()->type == 'client'){
                    $materials = MaterialUsed::where('project_id',$project->id)->get();
                }else{
                    $materials = MaterialUsed::where('project_id',$project->id)->get();
                }
            }

            if($user->type == 'company')
            {
                $materials = MaterialUsed::where('project_id', '=', $project_id)->get();
            }

            return view('material_used.index', compact('project', 'materials'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function create($project_id)
    {
        $project_user = ProjectUser::where('project_id', $project_id)->get();

        $products = ProductService::where('type', 'product')->get()->pluck('name', 'id');
        
        return view('material_used.create', compact('project_id', 'products'));
    }

    public function store(Request $request, $project_id)
    {
        // if(\Auth::user()->can('create bug report'))
        // {
        $validator = \Validator::make(
            $request->all(), [

                                'product_id' => 'required',
                                'date' => 'required',
                                'quantity' => 'required',
                            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->route('task.material_used', $project_id)->with('error', $messages->first());
        }

        $product = ProductService::find($request->product_id);

        $material_used              = new MaterialUsed();
        $material_used->project_id  = $project_id;
        $material_used->product_id       = $product->id;
        $material_used->date    = $request->date;
        $material_used->quantity  = $request->quantity;
        $material_used->description = $request->description;
        $material_used->created_by  = Auth::user()->creatorId();
        $material_used->save();

        $product->quantity = $product->quantity - $request->quantity;
        $product->save();

        ActivityLog::create(
            [
                'user_id' => Auth::user()->creatorId(),
                'project_id' => $project_id,
                'log_type' => 'Mateiral Used : '.$product->name.', Qty:'.$request->quantity,
                'remark' => json_encode(['title' => $material_used->description]),
            ]
        );

        return redirect()->route('task.material_used', $project_id)->with('success', __('Material Used successfully created.'));
    
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function destroy($project_id, $mid)
    {
        // if(\Auth::user()->can('delete bug report'))
        // {
        $material_used = MaterialUsed::find($mid);

        $product = ProductService::find($material_used->product_id);
        $product->quantity = $product->quantity + $material_used->quantity;
        $product->save();

        $material_used->delete();

        return redirect()->route('task.material_used', $project_id)->with('success', __('Material Used successfully deleted.'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }
}
