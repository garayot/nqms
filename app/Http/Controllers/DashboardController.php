<?php

namespace App\Http\Controllers;

use App\Enums\DrafStatus;
use App\Models\Document;
use App\Models\Draf;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isApprover()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    protected function userDashboard()
    {
        $user = Auth::user();

        $stats = [
            'draft' => Draf::where('requested_by', $user->id)->where('status', DrafStatus::DRAFT->value)->count(),
            'submitted' => Draf::where('requested_by', $user->id)->where('status', DrafStatus::SUBMITTED->value)->count(),
            'under_review' => Draf::where('requested_by', $user->id)->where('status', DrafStatus::UNDER_REVIEW->value)->count(),
            'approved' => Draf::where('requested_by', $user->id)->where('status', DrafStatus::APPROVED->value)->count(),
            'disapproved' => Draf::where('requested_by', $user->id)->whereIn('status', [
                DrafStatus::REVIEW_DISAPPROVED->value,
                DrafStatus::APPROVAL_DISAPPROVED->value,
            ])->count(),
        ];

        $drafs = Draf::where('requested_by', $user->id)->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'drafs'));
    }

    protected function adminDashboard()
    {
        $stats = [
            'total_drafs' => Draf::count(),
            'draft' => Draf::where('status', DrafStatus::DRAFT->value)->count(),
            'submitted' => Draf::where('status', DrafStatus::SUBMITTED->value)->count(),
            'under_review' => Draf::where('status', DrafStatus::UNDER_REVIEW->value)->count(),
            'recommended_for_approval' => Draf::where('status', DrafStatus::RECOMMENDED_FOR_APPROVAL->value)->count(),
            'approved' => Draf::where('status', DrafStatus::APPROVED->value)->count(),
            'disapproved' => Draf::whereIn('status', [
                DrafStatus::REVIEW_DISAPPROVED->value,
                DrafStatus::APPROVAL_DISAPPROVED->value,
            ])->count(),
            'active_documents' => Document::where('status', 'active')->count(),
            'obsolete_documents' => Document::where('status', 'obsolete')->count(),
        ];

        $drafs = Draf::latest()->take(8)->get();

        return view('dashboard', compact('stats', 'drafs'));
    }
}
