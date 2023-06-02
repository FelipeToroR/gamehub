<?php

namespace App\Http\Controllers;

use App\DataTables\RewardDayItemDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRewardDayItemRequest;
use App\Http\Requests\UpdateRewardDayItemRequest;
use App\Models\Reward;
use App\Models\RewardDay;
use App\Models\RewardDayItem;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RewardDayItemController extends AppBaseController
{
    /**
     * Display a listing of the RewardDayItem.
     *
     * @param RewardDayItemDataTable $rewardDayItemDataTable
     * @return Response
     */
    public function index($reward_id, $reward_day_id, RewardDayItemDataTable $rewardDayItemDataTable)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        $rewardDay = RewardDay::find($reward_day_id);
        if (empty($rewardDay)) {
            Flash::error('Día de recompensa no encontrada');
            return redirect(route('rewards.days.index', $reward_id));
        }

        return $rewardDayItemDataTable
                ->with('reward', $reward)
                ->with('rewardDay', $rewardDay)
                ->render('reward_days.index',['reward'=> $reward, 'rewardDay'=> $rewardDay]);
    }

    /**
     * Show the form for creating a new RewardDayItem.
     *
     * @return Response
     */
    public function create($reward_id, $reward_day_id)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        $rewardDay = RewardDay::find($reward_day_id);
        if (empty($rewardDay)) {
            Flash::error('Día de recompensa no encontrada');
            return redirect(route('rewards.days.index', $reward_id));
        }



        return view('reward_day_items.create')
            ->with('reward', $reward)
            ->with('rewardDay', $rewardDay);
        
    }

    /**
     * Store a newly created RewardDayItem in storage.
     *
     * @param CreateRewardDayItemRequest $request
     *
     * @return Response
     */
    public function store($reward_id, $reward_day_id, CreateRewardDayItemRequest $request)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        $rewardDay = RewardDay::find($reward_day_id);
        if (empty($rewardDay)) {
            Flash::error('Día de recompensa no encontrada');
            return redirect(route('rewards.days.index', $reward_id));
        }

        $input = $request->all();

        $input['reward_day_id'] = $reward_day_id;
        $rewardDayItem = RewardDayItem::create($input);

        Flash::success('Item de recompensa para el día ' . $rewardDay->day . ' ha sido almacenado exitosamente');

        return redirect(route('rewards.days.items.index',[$reward_id, $reward_day_id]));
    }

    /**
     * Display the specified RewardDayItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RewardDayItem $rewardDayItem */
        $rewardDayItem = RewardDayItem::find($id);

        if (empty($rewardDayItem)) {
            Flash::error('Reward Day Item not found');

            return redirect(route('rewardDayItems.index'));
        }

        return view('reward_day_items.show')->with('rewardDayItem', $rewardDayItem);
    }

    /**
     * Show the form for editing the specified RewardDayItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var RewardDayItem $rewardDayItem */
        $rewardDayItem = RewardDayItem::find($id);

        if (empty($rewardDayItem)) {
            Flash::error('Reward Day Item not found');

            return redirect(route('rewardDayItems.index'));
        }

        return view('reward_day_items.edit')->with('rewardDayItem', $rewardDayItem);
    }

    /**
     * Update the specified RewardDayItem in storage.
     *
     * @param  int              $id
     * @param UpdateRewardDayItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRewardDayItemRequest $request)
    {
        /** @var RewardDayItem $rewardDayItem */
        $rewardDayItem = RewardDayItem::find($id);

        if (empty($rewardDayItem)) {
            Flash::error('Reward Day Item not found');

            return redirect(route('rewardDayItems.index'));
        }

        $rewardDayItem->fill($request->all());
        $rewardDayItem->save();

        Flash::success('Reward Day Item updated successfully.');

        return redirect(route('rewardDayItems.index'));
    }

    /**
     * Remove the specified RewardDayItem from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RewardDayItem $rewardDayItem */
        $rewardDayItem = RewardDayItem::find($id);

        if (empty($rewardDayItem)) {
            Flash::error('Reward Day Item not found');

            return redirect(route('rewardDayItems.index'));
        }

        $rewardDayItem->delete();

        Flash::success('Reward Day Item deleted successfully.');

        return redirect(route('rewardDayItems.index'));
    }
}
