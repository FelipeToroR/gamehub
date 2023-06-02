<?php

namespace App\Http\Controllers;

use App\DataTables\RewardDayDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRewardDayRequest;
use App\Http\Requests\UpdateRewardDayRequest;
use App\Models\RewardDay;
use App\Models\Reward;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RewardDayController extends AppBaseController
{
    /**
     * Display a listing of the RewardDay.
     *
     * @param RewardDayDataTable $rewardDayDataTable
     * @return Response
     */
    public function index($reward_id, RewardDayDataTable $rewardDayDataTable)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        return $rewardDayDataTable
            ->with('reward', $reward)
            ->render('reward_days.index', ['reward' => $reward]);
    }

    /**
     * Show the form for creating a new RewardDay.
     *
     * @return Response
     */
    public function create($reward_id)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        return view('reward_days.create')
            ->with('reward', $reward);
    }

    /**
     * Store a newly created RewardDay in storage.
     *
     * @param CreateRewardDayRequest $request
     *
     * @return Response
     */
    public function store($reward_id, CreateRewardDayRequest $request)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        $input = $request->all();

        $input['reward_id'] = $reward->id;
        $rewardDay = RewardDay::create($input);

        Flash::success('Reward Day saved successfully.');

        return redirect(route('rewards.days.index', $reward->id));
    }

    /**
     * Display the specified RewardDay.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RewardDay $rewardDay */
        $rewardDay = RewardDay::find($id);

        if (empty($rewardDay)) {
            Flash::error('Reward Day not found');

            return redirect(route('rewardDays.index'));
        }

        return view('reward_days.show')->with('rewardDay', $rewardDay);
    }

    /**
     * Show the form for editing the specified RewardDay.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($reward_id, $reward_day_id)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        $rewardDay = RewardDay::find($reward_day_id);
        if (empty($rewardDay)) {
            Flash::error('Día de recompensa no encontrado');
            return redirect(route('rewards.days.index', $reward_id));
        }

        return view('reward_days.edit')
            ->with('reward', $reward)
            ->with('rewardDay', $rewardDay);
    }

    /**
     * Update the specified RewardDay in storage.
     *
     * @param  int              $id
     * @param UpdateRewardDayRequest $request
     *
     * @return Response
     */
    public function update($reward_id, $reward_day_id, UpdateRewardDayRequest $request)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }
        
        $rewardDay = RewardDay::find($reward_day_id);

        if (empty($rewardDay)) {
            Flash::error('Día de recompensa no encontrado');
            return redirect(route('rewards.days.index'));
        }

        $rewardDay->fill($request->all());
        $rewardDay->save();

        Flash::success('Día de recompensa actualizado exitosamente.');

        return redirect(route('rewards.days.index', $reward_id));
    }

    /**
     * Remove the specified RewardDay from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RewardDay $rewardDay */
        $rewardDay = RewardDay::find($id);

        if (empty($rewardDay)) {
            Flash::error('Reward Day not found');

            return redirect(route('rewardDays.index'));
        }

        $rewardDay->delete();

        Flash::success('Reward Day deleted successfully.');

        return redirect(route('rewardDays.index'));
    }
}
