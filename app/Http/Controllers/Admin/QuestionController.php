<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Question\Create;
use App\Http\Requests\Admin\Question\Update;
use App\Repositories\CountryRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $question;

    public function __construct(QuestionRepository $question)
    {
        $this->question = $question;
    }

    /***************************  get all providers  **************************/
    public function index()
    {
        $questions = $this->question->orderBy('id','desc')->get();
        return view('admin.questions.index', compact('questions'));
    }


    /***************************  store provider **************************/
    public function store(Create $request)
    {
        $data['key'] = [
            'ar' => $request['key_ar'],
            'en' => $request['key_en']
        ];
        $data['value'] = [
            'ar' => $request['value_ar'],
            'en' => $request['value_en']
        ];
        $this->question->create($data);
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }


    /***************************  update provider  **************************/
    public function update(Update $request, $id)
    {
        $question = $this->question->find($id);
        $data['key'] = [
            'ar' => $request['key_ar'],
            'en' => $request['key_en']
        ];
        $data['value'] = [
            'ar' => $request['value_ar'],
            'en' => $request['value_en']
        ];
        $this->question->update($data,$question['id']);
        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /***************************  delete provider  **************************/
    public function destroy(Request $request,$id)
    {
        if(isset($request['data_ids'])){
            $data = explode(',', $request['data_ids']);
            foreach ($data as $d){
                if($d != ""){
                    $this->question->delete($d);
                }
            }
        }else {
            $role = $this->question->find($id);
            $this->question->delete($role['id']);
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
