<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientChecklistRequest;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Http\Requests\PatientVaccinesRequest;
use App\Http\Transformers\PatientsTransformer;
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

class PatientController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['permission:patient_management']);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('patient.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('patient.create');
    }


    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function edit(int $patientId)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        return view('patient.edit', ['patient' => $patient]);
    }


    public function update(int $patientId, PatientUpdateRequest $request)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        $archive = new PatientArchive();
        $archive->patient_id = $patient->id;
        $archive->user_id = auth()->id();
        $archive->archive = json_encode($patient);
        $archive->save();

        $isHealthPersonnel = $request->is_health_personnel ?? false;
        $request->request->set('is_health_personnel', $isHealthPersonnel);

        $hasMutation = $request->has_mutation ?? false;
        $request->request->set('has_mutation', $hasMutation);

        $pcrStatus = $request->pcr_status ?? false;
        $request->request->set('pcr_status', $pcrStatus);

        $contactedStatus = $request->contacted_status ?? false;
        $request->request->set('contacted_status', $contactedStatus);


        $patient->fill($request->all());
        $patient->save();

        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Hasta ' . $patient->name . ' güncellendi');

        return $ajax->redirect(route('patient.index'));
    }

    public function store(PatientStoreRequest $request)
    {
        $patientModel = new Patient();
        $request->request->set('city_id', 43);
        $request->request->set('town_id', 1132);
        $patientModel->fill($request->all());
        $patientModel->save();

        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yeni kasta kayıt işlemi yapıldı.');

        return $ajax->redirect(route('patient.index'));
    }


    public function indexDataTable(Request $request)
    {

        $patients = Patient::cacheFor(now()->addDays(1))
            ->with([
                    'patientStatus' => function ($query) {
                        return $query
                            ->cacheFor(now()->addDays(1));
                    },
                    'village' => function ($query) {
                        return $query
                            ->cacheFor(now()->addDays(1));
                    },
                    'dailyChecks' => function ($query) {
                        return $query
                            ->cacheFor(now()->addDays(1));
                    }
                ]
            )->userPatientsByVillage();

        if (request()->has('order') === false) {
            $patients = $patients->orderBy('updated_at', 'desc');
        }

        return datatables()->of($patients->get())
            ->setTransformer(new PatientsTransformer())
            ->toJson();

    }


    public function vaccines($patientId)
    {

        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        return view('patient.vaccines', ['patient' => $patient]);
    }

    public function saveVaccines($patientId, PatientVaccinesRequest $request)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        $patient->vaccines()->delete();
        $vaccines = [];
        foreach ($request->get('vaccines') as $vaccinationDate) {

            if (is_null($vaccinationDate)) {
                continue;
            }
            $carbonized = Carbon::createFromFormat('d/m/Y', $vaccinationDate)->format('Y-m-d');
            //dd($carbonized);

            $vaccineRecord = new Vaccine();
            $vaccineRecord->vaccination_date = $vaccinationDate;
            $vaccineRecord->user_id = auth()->user()->id;
            $vaccines[] = $vaccineRecord;
        }

        $patient->vaccines()->saveMany($vaccines);


        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Hasta asi bilgileri güncellendi.');

        return $ajax->redirect(route('patient.index'));

    }

    public function dailyChecks($patientId)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        return view('patient.daily_checks', ['patient' => $patient]);

    }

    public function saveDailyChecks($patientId, PatientChecklistRequest $request)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            abort(404);
        }

        $today = date('Y-m-d');
        $patient->dailyChecks()->where('check_date', 'LIKE', '%' . $today . '%')->delete();
        $checks = [];
        foreach ($request->get('check_hour') as $hour) {

            if (is_null($hour)) {
                continue;
            }
            $dailyCheck = new DailyCheck();
            $dailyCheck->check_date = $today . ' ' . $hour . ':00';
            $dailyCheck->user_id = auth()->user()->id;
            $checks[] = $dailyCheck;
        }
        $patient->dailyChecks()->saveMany($checks);


        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Hasta denetimleri güncellendi.');

        return $ajax->redirect(route('patient.index'));

    }
}
