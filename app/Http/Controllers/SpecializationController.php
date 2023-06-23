<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Models\Specialization;
use App\Repositories\SpecializationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class SpecializationController extends AppBaseController
{
    /** @var SpecializationRepository */
    private $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepo)
    {
        $this->specializationRepository = $specializationRepo;
    }

    /**
     * Display a listing of the Specialization.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('specializations.index');
    }

    /**
     * Show the form for creating a new Services.
     *
     * @return Application|Factory|View
     */
    public function create()
    {

        return view('specializations.create');
    }

    /**
     * Store a newly created Specialization in storage.
     *
     * @param  CreateSpecializationRequest  $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateSpecializationRequest $request)
    {
        $input = $request->all();

        $this->specializationRepository->store($input);

        //return $this->sendSuccess(__('messages.flash.specialization_create'));
        Flash::success(__('messages.flash.specialization_create'));

        return redirect(route('specializations.index'));
    }

    /**
     * Show the form for editing the specified Specialization.
     *
     * @param  Specialization  $specialization
     * @return JsonResponse
     */
    public function edit(Specialization $specialization): JsonResponse
    {
        return $this->sendResponse($specialization, 'Specialization retrieved successfully.');
    }

    /**
     * Update the specified Specialization in storage.
     *
     * @param  UpdateSpecializationRequest  $request
     * @param  Specialization  $specialization
     * @return JsonResponse
     */
    public function update(UpdateSpecializationRequest $request, Specialization $specialization): JsonResponse
    {
        $this->specializationRepository->update($request->all(), $specialization->id);

        return $this->sendSuccess(__('messages.flash.specialization_update'));
    }

    /**
     * Remove the specified Specialization from storage.
     *
     * @param  Specialization  $specialization
     * @return JsonResponse
     */
    public function destroy(Specialization $specialization): JsonResponse
    {
        if ($specialization->doctors()->count()) {
            return $this->sendError('Specialization used somewhere else.');
        }
        $specialization->delete();

        return $this->sendSuccess(__('messages.flash.specialization_delete'));
    }
}
