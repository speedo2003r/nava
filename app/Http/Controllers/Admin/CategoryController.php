<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\Create;
use App\Http\Requests\Admin\Category\Update;
use App\Repositories\CategoryRepository;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use UploadTrait;
    use ResponseTrait;
    protected $categoryRepo,$banner;

    public function __construct(CategoryRepository $category)
    {
        $this->categoryRepo = $category;
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

    /***************************  store category **************************/
    public function store(Create $request)
    {
        $data = array_filter($request->all());
        if($request->has('image')){
            $data['icon'] = $this->uploadFile($request['image'],'categories');
        }
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $data['title'] = $translations;
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
        $translations = [];
        foreach(\App\Entities\Lang::all() as $key => $locale){
            $translations[$locale['lang']] = $request['title_'.$locale['lang']];
        }
        $data['title'] = $translations;
        $this->categoryRepo->update($data,$category['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete category  **************************/
    public function destroy(Request $request,$id)
    {
        $user = auth()->user();
        if($user['user_type'] == 'operation'){
            return back()->with('danger','ليس لديك الصلاحيه للحذف');
        }
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

    public function changeCategoryAppear(Request $request)
    {
        if($request->ajax()){
            $category = $this->categoryRepo->find($request['id']);
            $category['status'] = !$category['status'];
            $category->save();
            return $this->ApiResponse('success','',$category['status']);
        }
    }
}
