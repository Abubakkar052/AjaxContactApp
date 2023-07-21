<?php

namespace App\Http\Controllers;

use App\Models\network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('networks.networks');
    } 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {     
        $validator = Validator::make($request->all(), [
            'name' =>'required' , 'min:4','max:8',
            'code' => 'required|min:4|max:4',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1000'
        ]);
    if(isset($request->id))
    {  if($validator->passes())
        {   $codeCount = network::where('network_code', $request['code'])->first();
            $MatchCodeIdSame = network::where('network_code', $request['code'])->where('id', $request['id'])->first();
        if (!($codeCount) || $MatchCodeIdSame )
        {   $network = network::where('id',$request->id)->first();
            
            if($request->file('image'))
            {  
                $image_path = public_path('contactImage/' .$network->image);
                if(file_exists($image_path))
                {
                       unlink($image_path);
                }
                 $imageName = time().'.'.$request->file('image')->extension();     
                $request->image->move(public_path('/contactImage'),$imageName);
                $network->image = $imageName;     
            } 
            $network -> network_name  = $request['name'];
            $network -> network_code   = $request['code'];
            $network->save();
        
        return response()->json(['success'=>'Network Updated successfully']);
        }   
        else
        {return response()->json(['success'=>'Network code already exist unable to update']);}
    }
    else
    {   
        return response()->json(['error' => $validator->errors()]); 
    }
         
    }
    
    elseif(!isset($request->id))
    {$validatorCreateNetwork = Validator::make($request->all(), [
        'name' =>'required' , 'min:4','max:8',
        'code' => 'required|min:4|max:4',
        'image' => 'required|mimes:png,jpg,gif|max:1000'
    ]);
    
        if ($validatorCreateNetwork->passes())
 {
        $codeCount = network::where('network_code', $request['code'])->first(); 
        if (!($codeCount))
        {     
            $imageName = time().'.'.$request->file('image')->extension();
            $request->image->move(public_path('/contactImage'),$imageName);           
            $network = new network;
            $network -> network_name  = $request['name'];
            $network -> network_code   = $request['code'];
            $network->image = $imageName;
            $network->save();
            return response()->json(['success'=>'Network created successfully']);        
        }
        
        else
        {
            return response()->json(['success'=>'Network code already exist']);
        }     
    } 
    else
    {   
        return response()->json(['error' => $validator->errors()]); 
    }
}   
    }

    /**
     * Display the specified resource.
     */
    public function display()
    {   
        $networks = network::all();
        return response()->json(['networks'=> $networks]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete($id)
    {
       $network =  network::find($id);
       $image_path = public_path('contactImage/' .$network->image);
       if(file_exists($image_path))
       {
              unlink($image_path);
              $network->delete();
       }
       $network->delete();
        return response()->json(['success'=>'Network record deleted!!!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, network $network)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(network $network)
    {
        //
    }
}