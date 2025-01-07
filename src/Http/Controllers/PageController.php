<?php
namespace Sabith\StackcueZat2Laravel\Http\Controllers;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function standardinvoice()
    {
        return view('stackcue-zat2::standardinvoice');
    }
    public function standarddebitnote()
    {
        return view('stackcue-zat2::standarddebitnote');
    }
    public function standardcreditnote()
    {
        return view('stackcue-zat2::standardcreditnote');
    }
    public function simplifiedinvoice()
    {
        return view('stackcue-zat2::simplifiedinvoice');
    }
    public function simplifiedcreditnote()
    {
        return view('stackcue-zat2::simplifiedcreditnote');
    }
    public function simplifieddebitnote()
    {
        return view('stackcue-zat2::simplifieddebitnote');
    }
    public function prodictioncsid()
    {
        return view('stackcue-zat2::prodictioncsid');
    }
    public function compliancecsid()
    {
        return view('stackcue-zat2::compliancecsid');
    }
}
