<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BannerDataTable;
use Validator;


class BannerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BannerDataTable $dataTable) {
        return $dataTable->render('admin/banner/view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if($request->isMethod('GET')) {
            return view('admin/banner/add');
        }

        if($request->submit) {

            $rules = array(
                'name'  => 'required',
                'link'  => 'required',
                'status'=> 'required',
                'image' => 'required',
            );

             $banner_validation=false;

            if (filter_var($request->link, FILTER_VALIDATE_URL)) {
              $banner_validation=true;
            } else {                

            $check_spl_char=preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->link);
            $check_number=preg_match("/^\d+$/", $request->link); 

            if($check_spl_char && $check_number)
                $banner_validation=true;
            }
            if($banner_validation==false)
                $rules['link']='required|integer';
          
            $message=array(
                'link.integer'=>'Please provide a valid link'
            );

            $validator = Validator::make($request->all(), $rules,$message);
            if($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $image_uploader = resolve('App\Contracts\ImageHandlerInterface');
            $target_dir = '/images/banner';

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $file_name = "category-image".time().'.'.$extension;
                $options = compact('target_dir','file_name');
                $upload_result = $image_uploader->upload($image,$options);
                if(!$upload_result['status']) {
                    flashMessage('danger', $upload_result['status_message']);
                    return back();
                }
            }

            $banner        = new Banner;
            $banner->name  = $request->name;
            $banner->link  = $request->link;
            $banner->status= $request->status;
            $banner->image = $file_name;
            $banner->save();
            flashMessage('success', 'Added Successfully');
        }

        return redirect('admin/banner');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        if($request->isMethod('GET')) {
            $data['result'] = Banner::find($request->id);
            if($data['result']) {
                $data['editable'] = ($request->id =='1' || $request->id =='2') ? 'readonly' : '';
                return view('admin/banner/edit', $data);  
            }
            flashMessage('danger', 'Invalid ID');
        }
        if($request->submit) {
            $rules = array(
                'name'  =>'required',
                'link'  => 'required',
                'status'=> 'required',
            );

            $banner_validation=false;

            if (filter_var($request->link, FILTER_VALIDATE_URL)) {
              $banner_validation=true;
            } else {                

            $check_spl_char=preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->link);
            $check_number=preg_match("/^\d+$/", $request->link); 

            if($check_spl_char && $check_number)
                $banner_validation=true;
            }
            if($banner_validation==false)
                $rules['link']='required|integer';
          
            $message=array(
                'link.integer'=>'Please provide a valid link'
            );

            $validator = Validator::make($request->all(), $rules,$message);
            if($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $banner = Banner::find($request->id);
            if($request->hasFile('image')) {
                $image_uploader = resolve('App\Contracts\ImageHandlerInterface');
                $target_dir = '/images/banner';
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $file_name = "category-image".time().'.'.$extension;
                $options = compact('target_dir','file_name');
                $upload_result = $image_uploader->upload($image,$options);
                if(!$upload_result['status']){
                    flashMessage('danger', $upload_result['status_message']);
                    return back();
                }
                $banner->image = $file_name;
            }

            $banner->name  = $request->name;
            $banner->link   = $request->link;
            $banner->status = $request->status;
            $banner->save();
           
            flashMessage('success', 'Updated Successfully');
        }

        return redirect('admin/banner');
    }

    public function delete(Request $request)
    {
        if($request->id =='1' || $request->id =='2'){
            flashMessage('danger', "This is required one. So can't delete this"); 
            return redirect('admin/banner');
        }

        $banner = Banner::find($request->id);
        if($banner->image){
            $delete_image = resolve('App\Contracts\ImageHandlerInterface');
            $delete_image->delete($banner->image,['file_path' => '/images/banner/']);
        }
        $banner->delete();
        flashMessage('success', 'Deleted Successfully'); 
        return redirect('admin/banner');
    }
}
