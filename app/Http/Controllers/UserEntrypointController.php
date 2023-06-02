<?php

namespace App\Http\Controllers;

use App\DataTables\UserEntrypointDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserEntrypointRequest;
use App\Http\Requests\UpdateUserEntrypointRequest;
use App\Models\UserEntrypoint;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserEntrypointController extends AppBaseController
{
    /**
     * Display a listing of the UserEntrypoint.
     *
     * @param UserEntrypointDataTable $userEntrypointDataTable
     * @return Response
     */
    public function index(UserEntrypointDataTable $userEntrypointDataTable)
    {
        return $userEntrypointDataTable->render('user_entrypoints.index');
    }

    /**
     * Show the form for creating a new UserEntrypoint.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_entrypoints.create');
    }

    /**
     * Store a newly created UserEntrypoint in storage.
     *
     * @param CreateUserEntrypointRequest $request
     *
     * @return Response
     */
    public function store(CreateUserEntrypointRequest $request)
    {
        $input = $request->all();

        /** @var UserEntrypoint $userEntrypoint */
        $userEntrypoint = UserEntrypoint::create($input);

        Flash::success('User Entrypoint saved successfully.');

        return redirect(route('userEntrypoints.index'));
    }

    /**
     * Display the specified UserEntrypoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserEntrypoint $userEntrypoint */
        $userEntrypoint = UserEntrypoint::find($id);

        if (empty($userEntrypoint)) {
            Flash::error('User Entrypoint not found');

            return redirect(route('userEntrypoints.index'));
        }

        return view('user_entrypoints.show')->with('userEntrypoint', $userEntrypoint);
    }

    /**
     * Show the form for editing the specified UserEntrypoint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var UserEntrypoint $userEntrypoint */
        $userEntrypoint = UserEntrypoint::find($id);

        if (empty($userEntrypoint)) {
            Flash::error('User Entrypoint not found');

            return redirect(route('userEntrypoints.index'));
        }

        return view('user_entrypoints.edit')->with('userEntrypoint', $userEntrypoint);
    }

    /**
     * Update the specified UserEntrypoint in storage.
     *
     * @param  int              $id
     * @param UpdateUserEntrypointRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserEntrypointRequest $request)
    {
        /** @var UserEntrypoint $userEntrypoint */
        $userEntrypoint = UserEntrypoint::find($id);

        if (empty($userEntrypoint)) {
            Flash::error('User Entrypoint not found');

            return redirect(route('userEntrypoints.index'));
        }

        $userEntrypoint->fill($request->all());
        $userEntrypoint->save();

        Flash::success('User Entrypoint updated successfully.');

        return redirect(route('userEntrypoints.index'));
    }

    /**
     * Remove the specified UserEntrypoint from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserEntrypoint $userEntrypoint */
        $userEntrypoint = UserEntrypoint::find($id);

        if (empty($userEntrypoint)) {
            Flash::error('User Entrypoint not found');

            return redirect(route('userEntrypoints.index'));
        }

        $userEntrypoint->delete();

        Flash::success('User Entrypoint deleted successfully.');

        return redirect(route('userEntrypoints.index'));
    }
}
