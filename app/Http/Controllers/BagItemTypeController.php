<?php

namespace App\Http\Controllers;

use App\DataTables\BagItemTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateBagItemTypeRequest;
use App\Http\Requests\UpdateBagItemTypeRequest;
use App\Models\BagItemType;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class BagItemTypeController extends AppBaseController
{
    /**
     * Display a listing of the BagItemType.
     *
     * @param BagItemTypeDataTable $bagItemTypeDataTable
     * @return Response
     */
    public function index(BagItemTypeDataTable $bagItemTypeDataTable)
    {
        return $bagItemTypeDataTable->render('bag_item_types.index');
    }

    /**
     * Show the form for creating a new BagItemType.
     *
     * @return Response
     */
    public function create()
    {
        return view('bag_item_types.create');
    }

    /**
     * Store a newly created BagItemType in storage.
     *
     * @param CreateBagItemTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateBagItemTypeRequest $request)
    {
        $input = $request->all();

        /** @var BagItemType $bagItemType */
        $input['game_id'] = null;
        $bagItemType = BagItemType::create($input);

        Flash::success('Bag Item Type saved successfully.');

        return redirect(route('bagItemTypes.index'));
    }

    /**
     * Display the specified BagItemType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var BagItemType $bagItemType */
        $bagItemType = BagItemType::find($id);

        if (empty($bagItemType)) {
            Flash::error('Bag Item Type not found');

            return redirect(route('bagItemTypes.index'));
        }

        return view('bag_item_types.show')->with('bagItemType', $bagItemType);
    }

    /**
     * Show the form for editing the specified BagItemType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var BagItemType $bagItemType */
        $bagItemType = BagItemType::find($id);

        if (empty($bagItemType)) {
            Flash::error('Bag Item Type not found');

            return redirect(route('bagItemTypes.index'));
        }

        return view('bag_item_types.edit')->with('bagItemType', $bagItemType);
    }

    /**
     * Update the specified BagItemType in storage.
     *
     * @param  int              $id
     * @param UpdateBagItemTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBagItemTypeRequest $request)
    {
        /** @var BagItemType $bagItemType */
        $bagItemType = BagItemType::find($id);

        if (empty($bagItemType)) {
            Flash::error('Bag Item Type not found');

            return redirect(route('bagItemTypes.index'));
        }

        $bagItemType->fill($request->all());
        $bagItemType->save();

        Flash::success('Bag Item Type updated successfully.');

        return redirect(route('bagItemTypes.index'));
    }

    /**
     * Remove the specified BagItemType from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var BagItemType $bagItemType */
        $bagItemType = BagItemType::find($id);

        if (empty($bagItemType)) {
            Flash::error('Bag Item Type not found');

            return redirect(route('bagItemTypes.index'));
        }

        $bagItemType->delete();

        Flash::success('Bag Item Type deleted successfully.');

        return redirect(route('bagItemTypes.index'));
    }
}
