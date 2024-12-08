<?php
namespace App\Http\Controllers;
use App\Models\Intake;
// use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function show()
    {
        $intakes = Intake::where('status','open')->get();

     return view('calendar', compact('intakes'));
    }

    public function show1()
    {
        return view('calendar_1'); // Replace 'calendar' with the actual blade file name.
    }
}
