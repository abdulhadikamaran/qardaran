<?php

namespace App\Http\Controllers;

use App\Models\SavingGroup;
use App\Models\SavingGroupParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingGroupController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeGroups = $user->savingGroups()->active()->latest()->get();
        $completedGroups = $user->savingGroups()->completed()->latest()->get();

        return view('saving-groups.index', compact('activeGroups', 'completedGroups'));
    }

    public function create()
    {
        return view('saving-groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'num_participants' => ['required', 'integer', 'min:2', 'max:20'],
            'contribution_amount' => ['required', 'numeric', 'min:10'],
        ]);

        $group = SavingGroup::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'num_participants' => $request->num_participants,
            'contribution_amount' => round($request->contribution_amount, 2),
        ]);

        return redirect()->route('saving-groups.show', $group)->with('success', 'Saving group created! Now add participants.');
    }

    public function show(SavingGroup $savingGroup)
    {
        $this->authorizeGroup($savingGroup);

        $savingGroup->load('participants');
        $participantsAdded = $savingGroup->participants()->count();
        $needsMore = $savingGroup->num_participants - $participantsAdded;
        $canDraw = $needsMore === 0 && $savingGroup->status === 'active';
        $winners = $savingGroup->participants()->where('has_won', true)->orderBy('won_round')->get();
        $nonWinners = $savingGroup->participants()->where('has_won', false)->get();

        return view('saving-groups.show', compact(
            'savingGroup',
            'participantsAdded',
            'needsMore',
            'canDraw',
            'winners',
            'nonWinners'
        ));
    }

    public function addParticipant(Request $request, SavingGroup $savingGroup)
    {
        $this->authorizeGroup($savingGroup);

        $currentCount = $savingGroup->participants()->count();

        if ($currentCount >= $savingGroup->num_participants) {
            return back()->with('error', 'All participant slots are filled.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        SavingGroupParticipant::create([
            'saving_group_id' => $savingGroup->id,
            'name' => $request->name,
        ]);

        return back()->with('success', "Participant \"{$request->name}\" added.");
    }

    public function drawWinner(SavingGroup $savingGroup)
    {
        $this->authorizeGroup($savingGroup);

        if ($savingGroup->status !== 'active') {
            return back()->with('error', 'This group is already completed.');
        }

        $participantsCount = $savingGroup->participants()->count();
        if ($participantsCount < $savingGroup->num_participants) {
            return back()->with('error', 'Not all participants have been added yet.');
        }

        $nonWinners = $savingGroup->participants()->where('has_won', false)->get();

        if ($nonWinners->isEmpty()) {
            $savingGroup->update(['status' => 'completed']);
            return back()->with('info', 'All participants have won. Group completed!');
        }

        $winner = $nonWinners->random();
        $newRound = $savingGroup->current_round + 1;

        $winner->update([
            'has_won' => true,
            'won_round' => $newRound,
        ]);

        $savingGroup->update(['current_round' => $newRound]);

        // Check if all participants have won
        $remainingNonWinners = $savingGroup->participants()->where('has_won', false)->count();
        if ($remainingNonWinners === 0) {
            $savingGroup->update(['status' => 'completed']);
        }

        $pool = $savingGroup->monthly_pool;

        return back()->with('success', "🎉 Round $newRound Winner: {$winner->name}! They receive $$pool.");
    }

    private function authorizeGroup(SavingGroup $savingGroup): void
    {
        if ($savingGroup->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
