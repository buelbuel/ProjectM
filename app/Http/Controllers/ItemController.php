<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        /*
         * TODO: paginate, auth, filter
         * https://stackoverflow.com/questions/66846136/laravel-inertia-vuejs-pagination
         * 
         *
        $queriedItems = Item::select([
            'items.*',
            'projects.number as project_number',
            'projects.name as project_name',
            'accounts.name as account_name',
            'accounts.number as account_number', // TODO: number
            'users.name as user_name',
            'users.profile_photo_path as user_profile_photo_path'
        ])
        ->where('items.deleted_at', '=', null)
        ->join('projects', 'items.project_id', '=', 'projects.id')
        ->join('accounts', 'projects.account_id', '=', 'accounts.id') // TODO: number
        ->join('users', 'items.user_id', '=', 'users.id')
        ->orderBy('items.created_at')
        ->get();

        $allProjects = Project::select([
            'projects.name',
            'projects.id'
        ])
        ->where('projects.status_id', '<>', '6')
        ->where('projects.deleted_at', '=', null)
        ->orderBy('projects.created_at')
        ->take(20)
        ->get();

        $allUsers = User::select([
            'users.name',
            'users.id',
        ])
        ->where('users.deleted_at', '=', null)
        // ->orderBy('users.id') TODO: Order by current users ID as first
        ->orderBy('users.created_at')
        ->get();

        $allStatuses = Status::select([
            'statuses.name',
            'statuses.id',
        ])
        ->orderBy('statuses.id')
        ->get();

        $allPriorities = Priority::select([
            'priorities.name',
            'priorities.id',
        ])
        ->orderBy('priorities.id')
        ->get();

        return Jetstream::inertia()->render($request, 'Items/Index', [
            'items' => $queriedItems,
            'projects' => $allProjects,
            'users' => $allUsers,
            'statuses' => $allStatuses,
            'priorities' => $allPriorities,
        ]);*/
        return Inertia::render('Items/Index', [
            'filters' => Request::all('search', 'trashed'),
            'items' => Auth::user()->items()
                ->with('project')
                ->orderBy('items.created_at')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($item) => [
                    'number' => $item->number,
                    'name' => $item->name,
                    'project_id' => $item->organization ? $item->project_id->only('name') : null,
                    'description' => $item->description,
                    'user_id' => $item->user_id,
                    'status_id' => $item->status_id,
                    'priority_id' => $item->priority_id,
                    'start_date' => $item->start_date,
                    'due_date' => $item->due_date,
                    'tracked' => $item->tracked,
                    'estimated' => $item->estimated,
                    'created_by' => $item->created_by,
                    'created_at' => $item->created_at,
                    'deleted_at' => $item->deleted_at,
                ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $newItem = new Item;
        $newItem->name = $request->name;
        $newItem->description = $request->description;
        $newItem->user_id = $request->user_id;
        $newItem->project_id = $request->project_id;
        $newItem->status_id = $request->status_id;
        $newItem->priority_id = $request->priority_id;
        $newItem->start_date = $request->start_date;
        $newItem->due_date = $request->due_date;
        $newItem->tracked = $request->tracked;
        $newItem->estimated = $request->estimated;
        $newItem->created_by = $request->created_by;
        $newItem->created_at = $request->created_at;

        $newItem->save();

        return back(303);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function show(Request $request): \Inertia\Response
    {
        $queriedItem = Item::select([
            'items.*',
            'projects.name as project_name',
            'projects.account_id as account_id',
            'accounts.name as account_name',
            'accounts.id as account_id',
            'users.name as user_name'
        ])
        ->join('projects', 'items.project_id', '=', 'projects.id')
        ->join('accounts', 'projects.account_id', '=', 'accounts.id')
        ->join('users', 'items.user_id', '=', 'users.id')
        ->where('items.number', '=', $request->number)
        ->firstOrFail();

        $allProjects = Project::select([
            'projects.name',
            'projects.id'
        ])
        ->where('projects.status_id', '<>', '6')
        ->where('projects.deleted_at', '=', null)
        ->orderBy('projects.created_at')
        ->take(20)
        ->get();

        $allUsers = User::select([
            'users.name',
            'users.id',
        ])
        ->where('users.deleted_at', '=', null)
        // ->orderBy('users.id') TODO: Order by current users ID as first
        ->orderBy('users.created_at')
        ->get();

        $allStatuses = Status::select([
            'statuses.name',
            'statuses.id',
        ])
        ->orderBy('statuses.id')
        ->get();

        $allPriorities = Priority::select([
            'priorities.name',
            'priorities.id',
        ])
        ->orderBy('priorities.id')
        ->get();

        return Jetstream::inertia()->render($request, 'Items/Show', [
            'item' => $queriedItem,
            'projects' => $allProjects,
            'users' => $allUsers,
            'statuses' => $allStatuses,
            'priorities' => $allPriorities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function edit(Request $request): \Inertia\Response
    {
        return Jetstream::inertia()->render($request, 'Items/Edit', [
            //
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response|string
     */
    public function update(Request $request, int $id): Response|string
    {
        $existingItem = Item::FindOrFail($id);

        if ($existingItem) {
            $existingItem->updated_at = Carbon::now();
            $existingItem->save();

            return back(303);
        }
        return "Item not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $itemId
     * @return Response
     */
    public function destroy($itemId): Response
    {
        $existingItem = Item::FindOrFail($itemId);
        $existingItem->deleted_at = Carbon::now();
        $existingItem->save();

        return Inertia::location(url('/items/index'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param $itemId
     * @return Response
     */
    public function restore($itemId): Response
    {
        $existingItem = Item::FindOrFail($itemId);
        $existingItem->deleted_at = null;
        $existingItem->save();

        return Inertia::location(url('/item/show/' & $itemId));
    }
}
