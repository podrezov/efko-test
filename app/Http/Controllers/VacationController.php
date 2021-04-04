<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vactions\FixedRequest;
use App\Http\Requests\Vactions\SearchRequest;
use App\Http\Requests\Vactions\StoreRequest;
use App\Models\Vacation;
use Carbon\Carbon;

class VacationController extends Controller
{
    private const PER_PAGE = 10;

    public function index()
    {
        $vacations = Vacation::with('user')
            ->orderBy('id', 'desc')
            ->paginate(self::PER_PAGE);

        return view('vacation.index', compact('vacations'));
    }

    public function store(StoreRequest $storeRequest): \Illuminate\Http\RedirectResponse
    {
        if (auth()->user()->vacations()->firstWhere('fixed', true)) {
            return redirect()
                ->back()
                ->with('error_store', 'You already have a scheduled date');
        }

        auth()->user()->vacations()->create([
            'start_date' => $storeRequest->input('start_date'),
            'end_date' => $storeRequest->input('end_date')
        ]);

        return redirect()
            ->route('vacations.index')
            ->with('success_created', 'Vacation successfully created');
    }

    public function search(SearchRequest $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        if (!!$startDate->diff($endDate)->invert) {
            session()->flash('error_search', 'End date cannot be less than start date');

            return redirect()->route('vacations.index');
        }

        $isFixed = !!auth()->user()->vacations()->firstWhere('fixed', true);
        $vacations = Vacation::searchByDate($startDate, $endDate)
            ->with('user')
            ->paginate(self::PER_PAGE);

        return view('vacation.index', compact('vacations', 'isFixed'));
    }

    public function fixed(Vacation $vacation, FixedRequest $fixedRequest): \Illuminate\Http\RedirectResponse
    {
        $vacation->fixed = $fixedRequest->input('fixed');
        $vacation->save();

        return redirect()->back();
    }
}
