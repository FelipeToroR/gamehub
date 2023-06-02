<?php

namespace App\Http\Controllers;

use App\DataTables\UserBagItemDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserBagItemRequest;
use App\Http\Requests\UpdateUserBagItemRequest;
use App\Models\UserBagItem;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserBagItemController extends AppBaseController
{
    /**
     * Display a listing of the UserBagItem.
     *
     * @param UserBagItemDataTable $userBagItemDataTable
     * @return Response
     */
    public function index(UserBagItemDataTable $userBagItemDataTable)
    {
        return $userBagItemDataTable->render('user_bag_items.index');
    }

    /**
     * Show the form for creating a new UserBagItem.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_bag_items.create');
    }

    /**
     * Store a newly created UserBagItem in storage.
     *
     * @param CreateUserBagItemRequest $request
     *
     * @return Response
     */
    public function store(CreateUserBagItemRequest $request)
    {
        $input = $request->all();

        /** @var UserBagItem $userBagItem */
        $userBagItem = UserBagItem::create($input);

        Flash::success('User Bag Item saved successfully.');

        return redirect(route('userBagItems.index'));
    }

    /**
     * Display the specified UserBagItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserBagItem $userBagItem */
        $userBagItem = UserBagItem::find($id);

        if (empty($userBagItem)) {
            Flash::error('User Bag Item not found');

            return redirect(route('userBagItems.index'));
        }

        return view('user_bag_items.show')->with('userBagItem', $userBagItem);
    }

    /**
     * Show the form for editing the specified UserBagItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var UserBagItem $userBagItem */
        $userBagItem = UserBagItem::find($id);

        if (empty($userBagItem)) {
            Flash::error('User Bag Item not found');

            return redirect(route('userBagItems.index'));
        }

        return view('user_bag_items.edit')->with('userBagItem', $userBagItem);
    }

    /**
     * Update the specified UserBagItem in storage.
     *
     * @param  int              $id
     * @param UpdateUserBagItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserBagItemRequest $request)
    {
        /** @var UserBagItem $userBagItem */
        $userBagItem = UserBagItem::find($id);

        if (empty($userBagItem)) {
            Flash::error('User Bag Item not found');

            return redirect(route('userBagItems.index'));
        }

        $userBagItem->fill($request->all());
        $userBagItem->save();

        Flash::success('User Bag Item updated successfully.');

        return redirect(route('userBagItems.index'));
    }

    /**
     * Remove the specified UserBagItem from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserBagItem $userBagItem */
        $userBagItem = UserBagItem::find($id);

        if (empty($userBagItem)) {
            Flash::error('User Bag Item not found');

            return redirect(route('userBagItems.index'));
        }

        $userBagItem->delete();

        Flash::success('User Bag Item deleted successfully.');

        return redirect(route('userBagItems.index'));
    }
}
