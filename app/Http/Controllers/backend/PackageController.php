<?php

namespace App\Http\Controllers\backend;

use App\Models\Package;
use App\Models\ChildProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class PackageController extends Controller
{
    Protected $packageKey;
    public function __construct()
    {
       $this->packageKey = [
            ['level'=>"Max. Member No",'key'=>"maxMemberNo"],
       ]; 
    }

    public function index()
    {
        $packageKey = $this->packageKey;
        $packages = Package::all();
        return view('package.index',compact('packages','packageKey'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'packageName' => 'required',
            ]);

            $packConfigs = [];
            foreach ($request->keyName as $key => $value) {
                if ($request->keyValue[$key] != null) {   
                    $packConfigs[$value] = $request->keyValue[$key];
                }
            }
            
            Package::create([
                'name' => $request->packageName,
                'config' => $packConfigs,
            ]);

            ToastMagic::success("Success!", "Package created successfully");
            return redirect()->route('package.index');
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $packageId)
    {
        try {
            $request->validate([
                'packageName' => 'required',
            ]);

            $packConfigs = [];
            foreach ($request->keyName as $key => $value) {
                if ($request->keyValue[$key] != null) {   
                    $packConfigs[$value] = $request->keyValue[$key];
                }
            }
            
            Package::where('id', $packageId)->update([
                'name' => $request->packageName,
                'config' => $packConfigs,
            ]);

            
            Artisan::call('update:packageConfig', [
                'packageId' => $packageId,
            ]);

            ToastMagic::success("Success!", "Package updated successfully");
            return redirect()->route('package.index');
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($packageId)
    {
        try {
            $projectUnderPackage = ChildProject::where('package_id',$packageId)->count();
            if($projectUnderPackage > 0)
            {
                ToastMagic::error("Error!", "Package can't be deleted. There are projects under this package");
                return redirect()->back();
            }
            
            Package::where('id', $packageId)->delete();
            ToastMagic::success("Success!", "Package deleted successfully");
            return redirect()->route('package.index');
        } catch (\Throwable $th) {
            ToastMagic::error("Error!", $th->getMessage());
            return redirect()->back();
        }
    }
}
