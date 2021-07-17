<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\Create;
use App\Http\Requests\Admin\Page\Update;
use App\Repositories\Interfaces\IPage;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    /***************************  get all pages  **************************/
    public function index()
    {
        $pages = $this->page->all();
        return view('admin.pages.index', compact('pages'));
    }


    /***************************  store page **************************/
//    public function store(Create $request)
//    {
//        $data = array_filter($request->all());
//        $this->pageRepo->store($data);
//        return redirect()->back()->with('success', 'added successfully');
//    }


    /***************************  update page  **************************/
    public function update(Update $request, $id)
    {
        $page = $this->page->find($id);

        $translations = [
            'ar' => $request['title_ar'],
            'en' => $request['title_en']
        ];
        $translations_desc = [
            'ar' => $request['desc_ar'],
            'en' => $request['desc_en']
        ];
        $this->page->update(['title'=>$translations,'desc'=>$translations_desc],$page['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete page  **************************/
//    public function destroy($id)
//    {
//        $role = $this->pageRepo->findOrFail($id);
//        $this->pageRepo->softDelete($role);
//        return redirect()->back()->with('success', 'Deleted successfully');
//    }

}
