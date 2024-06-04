<?php

namespace App\Http\Controllers;

use App\Models\LoanDetail;
use Illuminate\Http\Request;

class LoanDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /*
    |           ____
    |          |  _ \
    |          | |_) |
    |          |  _ <
    |          | |_) |
    |          |____/
    |
    |    Browse Emi Data: (B)READ
    */

    /*
    *    Display a listing of the resource
    *   return view  with data if table exist in data base.
    *  @author: Naman Mehta
    */

    public function index()
    {
        $loanDetails = LoanDetail::all();
        return view('loan-details.index', ['loanDetails' => $loanDetails]);
    }
}
