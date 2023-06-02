<?php

namespace App\Http\Controllers;

use App\DataTables\RewardItemDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRewardItemRequest;
use App\Http\Requests\UpdateRewardItemRequest;
use App\Models\RewardItem;
use App\Models\Reward;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RewardItemController extends AppBaseController
{
    /**
     * Display a listing of the RewardItem.
     *
     * @param RewardItemDataTable $rewardItemDataTable
     * @return Response
     */
    public function index($reward_id, RewardItemDataTable $rewardItemDataTable)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index'));
        }

        return $rewardItemDataTable
                ->with('reward', $reward)
                ->render('reward_items.index',['reward'=> $reward]);
    }

    /**
     * Show the form for creating a new RewardItem.
     *
     * @return Response
     */
    public function create($reward_id)
    {
        $reward = Reward::find($reward_id);
        if (empty($reward)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.index', $reward_id));
        }

        return view('reward_items.create')
                ->with('reward', $reward);
    }

    /**
     * Store a newly created RewardItem in storage.
     *
     * @param CreateRewardItemRequest $request
     *
     * @return Response
     */
    public function store($reward_id,CreateRewardItemRequest $request)
    {
        $input = $request->all();

        $rewardItem = RewardItem::create($input);

        Flash::success('Reward Item saved successfully.');

        return redirect(route('rewards.items.index', $reward_id));
    }

    /**
     * Display the specified RewardItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($reward_id, $reward_item_id)
    {
        /** @var RewardItem $rewardItem */
        $rewardItem = RewardItem::find($reward_item_id);

        if (empty($rewardItem)) {
            Flash::error('Reward Item not found');

            return redirect(route('rewardItems.index'));
        }

        return view('reward_items.show')->with('rewardItem', $rewardItem);
    }

    /**
     * Show the form for editing the specified RewardItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($reward_id, $reward_item_id)
    {

        $reward = Reward::find($reward_id);
        if (empty($rewardItem)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.items.index', $reward_id));
        }

        $rewardItem = RewardItem::find($reward_item_id);
        if (empty($rewardItem)) {
            Flash::error('Ítem de recompensa no encontrada');
            return redirect(route('rewards.items.index'));
        }

        return view('reward_items.edit')
                ->with('rewardItem', $rewardItem)
                ->with('reward', $reward);
    }

    /**
     * Update the specified RewardItem in storage.
     *
     * @param  int              $id
     * @param UpdateRewardItemRequest $request
     *
     * @return Response
     */
    public function update($reward_id, $reward_item_id, UpdateRewardItemRequest $request)
    {
        $reward = Reward::find($reward_id);
        if (empty($rewardItem)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.items.index', $reward_id));
        }        
        
        $rewardItem = RewardItem::where('reward_id', $reward_id)
                            ->where('id', $reward_item_id)
                            ->first();
        if (empty($rewardItem)) {
            Flash::error('Ítem de recompensa no encontrada');
            return redirect(route('rewards.items.index'));
        }

        $rewardItem->fill($request->all());
        $rewardItem->save();

        Flash::success('Ítem de recompensa actualizado exitosamente.');
        return redirect(route('rewards.items.index', $reward_id));
    }

    /**
     * Remove the specified RewardItem from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($reward_id, $reward_item_id)
    {
        $reward = Reward::find($reward_id);
        if (empty($rewardItem)) {
            Flash::error('Recompensa no encontrada');
            return redirect(route('rewards.items.index', $reward_id));
        }        
        
        $rewardItem = RewardItem::where('reward_id', $reward_id)
                            ->where('id', $reward_item_id)
                            ->first();
        if (empty($rewardItem)) {
            Flash::error('Ítem de recompensa no encontrado');
            return redirect(route('rewards.items.index'));
        }

        $rewardItem->delete();

        Flash::success('Ítem de recompensa no encontrado');
        return redirect(route('rewardItems.index'));
    }
}
