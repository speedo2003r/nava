<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewDatatable;
use App\Http\Controllers\Controller;
use App\Repositories\ReviewRateRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function __construct(protected ReviewRateRepository $review)
    {
        //
    }

    /***************************  get all pages  **************************/
    public function index(ReviewDatatable $datatable)
    {
        return $datatable->render('admin.reviews.index');
    }

}
