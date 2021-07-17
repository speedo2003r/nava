<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\Create;
use App\Http\Requests\Admin\Category\Update;
use App\Repositories\CategoryRepository;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $categoryRepo;
    use UploadTrait;

    public function __construct(CategoryRepository $category)
    {
        $this->categoryRepo = $category;
    }

    /***************************  get all subCategories  **************************/
    public function index($id)
    {
        $check = $this->categoryRepo->find($id);
        if(!$check)
            return redirect()->back()->with('danger', 'هذا القسم غير موجود');

        $subCategories = $this->categoryRepo->whereHas('parent',function ($query) use ($id){
            $query->where('parent_id',null);
            $query->where('id',$id);
        })->get();
        return view('admin.subCategories.index', compact('subCategories','check'));
    }


    /***************************  store category **************************/
    public function store(Create $request,$id)
    {
        $check = $this->categoryRepo->find($id);
        if(!$check)
            return redirect()->back()->with('danger', 'this category is undefined');

        $data = array_filter($request->except('image'));
        if($request->has('image')){
            $data['icon'] = $this->uploadFile($request['image'],'categories');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $data['parent_id'] = $check['id'];
        $this->categoryRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update category  **************************/
    public function update(Update $request, $id)
    {
        $subCategory = $this->categoryRepo->find($id);
        $data = array_filter($request->except('image'));
        if($request->has('image')){
            $data['icon'] = $this->uploadFile($request['image'],'categories');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $this->categoryRepo->update($data,$subCategory['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete category  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $role = $this->categoryRepo->find($d);
                    $this->categoryRepo->delete($role['id']);
                }
            }
        }else {
            $role = $this->categoryRepo->find($id);
            $this->categoryRepo->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function getuploadFile(Request $request,$id)
    {
        $subCategory = $this->categoryRepo->find($id);
        return view('admin.subCategories.file',compact('id','subCategory'));
    }
    public function storeUploadFile(Request $request,$id)
    {
        $data = array_filter($request->all());
        $subCategory = $this->categoryRepo->find($id);
        $this->categoryRepo->update($data,$subCategory['id']);
        return back()->with('success', 'تم التحديث بنجاح');
    }
}
