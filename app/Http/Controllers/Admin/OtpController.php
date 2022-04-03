<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDatatable;
use App\DataTables\OtpDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Create;
use App\Http\Requests\Admin\Client\Update;
use App\Jobs\NotifyFcm;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use App\Traits\NotifyTrait;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class OtpController extends Controller
{
    use NotifyTrait;
    use ResponseTrait;
    use UploadTrait;

    public function __construct(protected UserRepository $user)
    {
    }

    /***************************  get all providers  **************************/
    public function index(OtpDatatable $datatable)
    {
        return $datatable->render('admin.otp.index');
    }

}
