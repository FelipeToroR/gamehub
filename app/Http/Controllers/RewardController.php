<?php

namespace App\Http\Controllers;

use App\DataTables\RewardDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Reward;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RewardController extends AppBaseController
{
    /**
     * Display a listing of the Reward.
     *
     * @param RewardDataTable $rewardDataTable
     * @return Response
     */
    public function index(RewardDataTable $rewardDataTable)
    {
        return $rewardDataTable->render('rewards.index');
    }

    /**
     * Show the form for creating a new Reward.
     *
     * @return Response
     */
    public function create()
    {
        return view('rewards.create');
    }

    /**
     * Store a newly created Reward in storage.
     *
     * @param CreateRewardRequest $request
     *
     * @return Response
     */
    public function store(CreateRewardRequest $request)
    {
        $input = $request->all();

        /** @var Reward $reward */
        $reward = Reward::create($input);

        Flash::success('Reward saved successfully.');

        return redirect(route('rewards.index'));
    }

    /**
     * Display the specified Reward.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Reward $reward */
        $reward = Reward::find($id);

        if (empty($reward)) {
            Flash::error('Reward not found');

            return redirect(route('rewards.index'));
        }

        return view('rewards.show')->with('reward', $reward);
    }

    /**
     * Show the form for editing the specified Reward.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Reward $reward */
        $reward = Reward::find($id);

        if (empty($reward)) {
            Flash::error('Reward not found');

            return redirect(route('rewards.index'));
        }

        return view('rewards.edit')->with('reward', $reward);
    }

    /**
     * Update the specified Reward in storage.
     *
     * @param  int              $id
     * @param UpdateRewardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRewardRequest $request)
    {
        /** @var Reward $reward */
        $reward = Reward::find($id);

        if (empty($reward)) {
            Flash::error('Reward not found');

            return redirect(route('rewards.index'));
        }

        $reward->fill($request->all());
        $reward->save();

        Flash::success('Reward updated successfully.');

        return redirect(route('rewards.index'));
    }

    /**
     * Remove the specified Reward from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Reward $reward */
        $reward = Reward::find($id);

        if (empty($reward)) {
            Flash::error('Reward not found');

            return redirect(route('rewards.index'));
        }

        $reward->delete();

        Flash::success('Reward deleted successfully.');

        return redirect(route('rewards.index'));
    }
}
