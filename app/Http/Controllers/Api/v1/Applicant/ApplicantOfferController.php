<?php

namespace App\Http\Controllers\Api\v1\Applicant;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Applicant;
use App\Models\Offer;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;

class ApplicantOfferController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-offers');

        $this->middleware('can:acting-as-applicant,applicant')->only(['index']);
        $this->middleware('can:manage-offer,applicant,offer')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Applicant $applicant
     * @return JsonResponse
     */
    public function index(Applicant $applicant)
    {
        if(!$applicant->offers()->count()){
            return $this->errorResponse('The $applicant does not have any offers', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $applicant->offers()->paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     *
     * @param Applicant $applicant
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Applicant $applicant, Offer $offer)
    {
        $applicant->offers()->findOrFail($offer->recipient->id);

        return $this->showOne($offer);
    }

    /**
     * @param Applicant $applicant
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function accept(Applicant $applicant, Offer $offer)
    {
        $applicant->offers()->findOrFail($offer->recipient->id);

        $data = $this->getAcceptedInstanceData($offer->sender, $offer);

        $worker = Worker::find($applicant->id);
        $worker->jobs()->syncWithoutDetaching($data);

        $offer->delete();

        return $this->showMessage("The job has been accepted!");
    }

    /**
     * @param Applicant $applicant
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function refuse(Applicant $applicant, Offer $offer)
    {
        $applicant->offers()->findOrFail($offer->recipient->id);

        $offer->delete();

        return $this->showMessage('An Offer has been refused');
    }
}
