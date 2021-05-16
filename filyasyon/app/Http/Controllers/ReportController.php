<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientChecklistRequest;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\PatientVaccinesRequest;
use App\Http\Transformers\PatientsTransformer;
use App\Http\Transformers\ReportTransformer;
use App\Models\DailyCheck;
use App\Models\Patient;
use App\Models\PatientArchive;
use App\Models\Vaccine;
use Carbon\Carbon;
use Garavel\Utils\Ajax;
use Garavel\ViewComposers\FlashMessageViewComposer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:report']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('report.index');
    }

    public function indexDataTable(Request $request)
    {

        $patients = Patient::with(['patientStatus', 'village','neighborhood', 'dailyChecks'])
            ->userPatientsByVillage()
            ->userPatientsByNeighborhood();

        if (request()->has('order') === false) {
            $patients = $patients->orderByRaw("FIELD(patient_status_id,1,2,3,4,5,6,7,8)");
        }

        return datatables()->of($patients->get())
            ->setTransformer(new ReportTransformer())
            ->toJson();
    }
}
