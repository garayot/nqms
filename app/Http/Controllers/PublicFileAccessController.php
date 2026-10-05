<?php

namespace App\Http\Controllers;

use App\Models\FormTemplate;
use App\Models\FunctionalDiv;
use App\Models\NqmsManual;
use App\Models\PlanningDoc;
use App\Models\ProcessGroup;
use App\Models\SubProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicFileAccessController extends Controller
{
    public function formTemplate(FormTemplate $formTemplate): RedirectResponse
    {
        $path = $formTemplate->downloadable_attachment_path;

        abort_unless(filled($path), 404);

        $targetUrl = Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::url($path);

        return $this->redirectToTarget($targetUrl);
    }

    public function nqmsManual(NqmsManual $nqmsManual): RedirectResponse
    {
        abort_unless(filled($nqmsManual->downloadable_attachment_url), 404);

        return $this->redirectToTarget($nqmsManual->downloadable_attachment_url);
    }

    public function planningDivision(FunctionalDiv $functionalDiv): RedirectResponse
    {
        abort_unless(filled($functionalDiv->url), 404);

        return $this->redirectToTarget($functionalDiv->url);
    }

    public function planningDoc(PlanningDoc $planningDoc): RedirectResponse
    {
        abort_unless(filled($planningDoc->url), 404);

        return $this->redirectToTarget($planningDoc->url);
    }

    public function processGroup(ProcessGroup $processGroup): RedirectResponse
    {
        abort_unless(filled($processGroup->url), 404);

        return $this->redirectToTarget($processGroup->url);
    }

    public function subProcess(SubProcess $subProcess): RedirectResponse
    {
        abort_unless(filled($subProcess->url), 404);

        return $this->redirectToTarget($subProcess->url);
    }

    private function redirectToTarget(string $targetUrl): RedirectResponse
    {
        if (auth()->guest()) {
            return redirect()
                ->guest(route('login.google'))
                ->with('error', 'Please log in to view or download this file.');
        }

        if (Str::startsWith($targetUrl, ['http://', 'https://'])) {
            return redirect()->away($targetUrl);
        }

        return redirect($targetUrl);
    }
}
