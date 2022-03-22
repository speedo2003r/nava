<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class TransController extends Controller
{
    private $arrayLang = array();
    private $path;
    private $value;
    private $lang;
    private $file;

    public function index()
    {
        $langs = [
            'ar' => 'arabic',
            'en' => 'english',
        ];
        $files = [
            'api',
            'auth',
            'validation',
        ];
        return view('admin.translation.index', compact('langs','files'));
    }
    public function getLangDetails(Request $request)
    {
        $lang = $request['lang'];
        $group = $request['group'];
        $data = File::getRequire(base_path()."/resources/lang/{$lang}/{$group}.php");
        unset($data['custom']);
        unset($data['attributes']);
        unset($data['size']);
        unset($data['max']);
        unset($data['min']);
        unset($data['between']);
        return response()->json($data);
    }
    public function transInput(Request $request)
    {
        $this->lang = $request['lang'];
        $this->file = $request['group'];
        $key = $request['id'];
        $this->value = $request['text'];
        $this->read();
        $this->arrayLang[$key] = $this->value;
        $this->save();

    }
    private function read()
    {
        if ($this->lang == '') $this->lang = app()->getLocale();
        $this->path = base_path().'/resources/lang/'.$this->lang.'/'.$this->file.'.php';
        $this->arrayLang = Lang::get($this->file,[],$this->lang);
        if (gettype($this->arrayLang) == 'string') $this->arrayLang = array();
    }
    private function save()
    {
        $content = "<?php\n\nreturn\n[\n";

        foreach ($this->arrayLang as $key => $value)
        {
            $content .= "\t'".$key."' => '".$value."',\n";
        }

        $content .= "];";
        file_put_contents($this->path, $content);

    }
}
