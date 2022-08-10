<?php

namespace App\Http\Controllers;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Item;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use Spatie\LaravelOptions\Options;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {dd(Auth::user()->currentTeam->users());
        return Inertia::render('Items/Index', [
            'projects' => Project::orderBy('projects.created_at')->get()->map->only('number', 'name'),
            'users' => Auth::user()->currentTeam->users()->orderBy('users.name')->get()->map->only('number', 'name'),
            'priorities' => Options::forEnum(Priority::class),
            'statuses' => Options::forEnum(Status::class),
            'items' => Auth::user()->currentTeam->items()
                ->with('project')
                ->orderBy('items.created_at')
                ->fastPaginate(20)
                ->withQueryString()
                ->through(fn ($item) => [
                    'number' => $item->number,
                    'name' => $item->name,
                    'project' => $item->project ? $item->project->only('name', 'number') : null,
                    'account' => $item->project ? $item->project->account->only('name', 'number') : null,
                    'description' => $item->description,
                    'user' => $item->user ? $item->user->only('name', 'number') : null,
                    'status' => $item->status,
                    'priority' => $item->priority,
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
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        dd(Auth::user());
        Auth::user()->currentTeam->items()->create(
            Request::validate([
                'name' => ['required', 'max:50'],
                'description' => ['required', 'max:255'],
                'user_id' => ['required', Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'project_id' => ['required', Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'status_id' => ['required', 'integer'],
                'priority_id' => ['required', 'integer'],
                'start_date' => ['nullable', 'date'],
                'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
                'tracked' => ['nullable', 'numeric'],
                'estimated' => ['nullable', 'numeric'],
                'created_by' => ['required', 'user_id'],
                'created_at' => ['required', 'date'],
            ])
        );

        return Redirect::route('items')->with('success', 'Item created.');
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
