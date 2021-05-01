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

        $extendQuarantinaPeriodDays = $request->get('extended_qurantine_end_days');
        $archive = new PatientArchive();
        $archive->patient_id = $patient->id;
        $archive->user_id = auth()->id();
        $archive->archive = json_encode($patient);
        $archive->save();

        $detectionDateRequest = $request->get('detection_date');
        $pcrStatus = $request->pcr_status ?? false;
        $contactedStatus = $request->contacted_status ?? false;
        $hasMutation = $request->has_mutation ?? false;
        $isHealthPersonnel = $request->is_health_personnel ?? false;

        $detectionDate = Carbon::createFromFormat('d/m/Y', $detectionDateRequest);
        $quarantineEndDate = $detectionDate->copy()->addDays($patient->quarantinePeriod);

        if (!is_null($extendQuarantinaPeriodDays) && $extendQuarantinaPeriodDays > 0) {
            $quarantineEndDate->addDays($extendQuarantinaPeriodDays);
        }


        $request->request->set('quarantine_start_date', $detectionDate->format('Y-m-d'));
        $request->request->set('quarantine_end_date', $quarantineEndDate->format('Y-m-d'));

        $request->request->set('is_health_personnel', $isHealthPersonnel);
        $request->request->set('has_mutation', $hasMutation);
        $request->request->set('pcr_status', $pcrStatus);
        $request->request->set('contacted_status', $contactedStatus);

        $requestData = $request->except(['extended_qurantine_end_days']);
        $patient->fill($requestData);
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
        $detectionDate = $request->get('detection_date');
        $pcrStatus = $request->request->get('pcr_status');
        $contactedStatus = $request->request->get('contacted_status');


        /*
        PCR 7 Gun Karantina Suresi
        Temasli 10 Gun Karantina
        */
        $now = Carbon::now();
        $quarantinePeriod = $pcrStatus ? 10 : 10;
        $quarantineStartDate = $now;
        if ($detectionDate) {
            $quarantineStartDate = Carbon::createFromFormat('d/m/Y', $detectionDate);
        }
        $quarantineEndDate = $quarantineStartDate->copy()->addDays($quarantinePeriod);
        $request->request->set('quarantine_start_date', $quarantineStartDate->format('Y-m-d H:i:s'));
        $request->request->set('quarantine_end_date', $quarantineEndDate->format('Y-m-d H:i:s'));

        $patientModel->fill($request->all());
        $patientModel->save();

        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yeni kasta kayıt işlemi yapıldı.');

        return $ajax->redirect(route('patient.index'));
    }


    public function indexDataTable(Request $request)
    {

        $patients = Patient::with(['patientStatus', 'village', 'dailyChecks'])->userPatientsByVillage();

        if (request()->has('order') === false) {
            $patients = $patients->orderByRaw("FIELD(patient_status_id,1,2,3,4,5,6,7,8)");
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


    public function batchDailyChecks($patientIds)
    {

        //@todo id ler icin bolge yetki kontrolu
        $patientIds = explode(',',$patientIds);
        $patients = Patient::whereIn('id',$patientIds)->get();

        return view('patient.daily_checks_batch', ['patients' => $patients]);

    }


    public function saveBatchDailyChecks($patientIds, PatientChecklistRequest $request){
        //@todo id ler icin bolge yetki kontrolu
        $patientIds = explode(',',$patientIds);
        $patients = Patient::whereIn('id',$patientIds)->get();
        $today = date('Y-m-d');
        foreach ($patients as $patient){
            if($patient->isDailyCheckable()){
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
            }
        }

        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Hastalarin denetimleri güncellendi.');

        return $ajax->redirect(route('patient.index'));
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

        //@todo isDailyCheckable()
        $patient->dailyChecks()->saveMany($checks);


        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Hasta denetimleri güncellendi.');

        return $ajax->redirect(route('patient.index'));

    }
}
