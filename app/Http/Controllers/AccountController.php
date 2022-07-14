<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Laravel\Jetstream\Jetstream;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $queriedAccounts = Account::where('accounts.deleted_at', '=', null)
            ->orderBy('accounts.created_at', 'asc')
            ->get();

        return Jetstream::inertia()->render($request, 'Accounts/Index', [
            'accounts' => $queriedAccounts,
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
        $newAccount = new Account;
        $newAccount->name = $request->name;
        $newAccount->email = $request->email;
        $newAccount->phone = $request->phone;
        $newAccount->fax = $request->fax;
        $newAccount->shipping_street = $request->shipping_street;
        $newAccount->shipping_city = $request->shipping_city;
        $newAccount->shipping_zip = $request->shipping_zip;
        $newAccount->shipping_state = $request->shipping_state;
        $newAccount->shipping_country = $request->shipping_country;
        $newAccount->billing_street = $request->billing_street;
        $newAccount->billing_city = $request->billing_city;
        $newAccount->billing_zip = $request->billing_zip;
        $newAccount->billing_state = $request->billing_state;
        $newAccount->billing_country = $request->billing_country;
        $newAccount->created_by = $request->created_by;
        $newAccount->created_at = $request->created_at;

        $newAccount->save();

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
        $queriedAccount = Account::where('accounts.number', '=', $request->number)
            ->FirstOrFail();

        return Jetstream::inertia()->render($request, 'Accounts/Show', [
            'account' => $queriedAccount
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
        $existingAccount = Account::find($id);

        if($existingAccount){
            $existingAccount->completed = (bool)$request->account['completed'];
            $existingAccount->updated_at = Carbon::now();
            $existingAccount->save();
            return $existingAccount;
        }
        return "Account not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy(int $id): string
    {
        $existingAccount = Account::find($id);
        if($existingAccount){
            $existingAccount->delete();
            return "Account deleted";
        }
        return "Account not found";
    }
}
