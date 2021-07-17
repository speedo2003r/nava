<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\Create;
use App\Http\Requests\Admin\Category\Update;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use UploadTrait;
    use ResponseTrait;
    protected $categoryRepo,$banner;

    public function __construct(BannerRepository $banner,CategoryRepository $category)
    {
        $this->categoryRepo = $category;
        $this->banner = $banner;
    }

    /***************************  get all categories  **************************/
    public function index()
    {
        $categories = $this->categoryRepo->findWhere(['parent_id'=>null]);
        return view('admin.categories.index', compact('categories'));
    }
    /***************************  get view tree categories  **************************/
    public function view()
    {
        $categories = $this->categoryRepo->findWhere(['parent_id'=>null]);
        return view('admin.categories.tree', compact('categories'));
    }

    public function specifications(Request $request)
    {
        $category = $this->categoryRepo->find($request['category_id']);
        $category->specifications()->sync($request['tags']);
        return redirect()->back()->with('success', 'تم اضافه سمات بنجاح');
    }
    /***************************  store category **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        if($request->has('image')){
            $data['icon'] = $this->uploadFile($request['image'],'categories');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $this->categoryRepo->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update category  **************************/
    public function update(Update $request, $id)
    {
        $category = $this->categoryRepo->find($id);
        if($request->has('image')){
            $data['icon'] = $this->uploadFile($request['image'],'categories');
        }
        $data['title'] = [
            'ar' =>$request['title_ar'],
            'en' =>$request['title_en'],
        ];
        $this->categoryRepo->update($data,$category['id']);
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
    public function banners(BannerDatatable $datatable,$id)
    {
        $category = $this->categoryRepo->find($id);
        session()->put('category_id',$category['id']);
        if($category['parent_id'] == null){
            return back();
        }
        $banners = $category->banner;
        return $datatable->render('admin.categories.banners',compact('banners','category'));
    }


    public function bannerStore($id,Request $request)
    {
        $data = array_filter($request->all());
        if($request->has('image')){
            $data['image'] = $this->uploadFile($request['image'],'banners');
        }
        $data['category_id'] = $id;
        $this->banner->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }
    public function bannerUpdate($id,Request $request)
    {
        $banner = $this->banner->find($id);
        $data = array_filter($request->all());
        if($request->has('image')){
            if($banner['image'] != null){
                $this->deleteFile($banner['image'],'banners');
                $data['image'] = $this->uploadFile($request['image'],'banners');
            }
        }
        $this->banner->update(array_filter($data),$banner['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    public function bannerDestroy($id,Request $request)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->banner->delete($d);
                }
            }
        }else {
            $role = $this->banner->find($id);
            $this->banner->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function changeActive(Request $request)
    {
        if($request->ajax()){
            $banner = $this->banner->find($request['id']);
            $banner['active'] = !$banner['active'];
            $banner->save();
            return $this->successResponse($banner['active']);
        }
    }
    public function changeCategoryAppear(Request $request)
    {
        if($request->ajax()){
            $category = $this->categoryRepo->find($request['id']);
            $category['status'] = !$category['status'];
            $category->save();
            return $this->ApiResponse('success','',$category['status']);
        }
    }

    public function changeCategoryPladge(Request $request)
    {
        if($request->ajax()){
            $category = $this->categoryRepo->find($request['id']);
            $category['pledge'] = !$category['pledge'];
            $category->save();
            return $this->ApiResponse('success','',$category['pledge']);
        }
    }

}
