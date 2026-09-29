<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            'In compliance to DepEd Order 14, s. 2022 (ISO/QMS Standards)',
            'Compliance Requirement (New Laws, Policies or DepEd Issuances)',
            'Compliance Requirement of Audit findings (Internal or External)',
            'New Document Creation (Completely New Policy, guideline, SOP, or form is being introduced)',
            'Revision/Update (Existing Document is being improved, corrected or updated (Process improvement, clarification of instructions, formatting updates)',
            'Correction of Errors (Fixing Typographical errors, inconsistencies, or incorrect data)',
            'Process Improvement / Enhancement (To make procedure more efficient, faster or user-friendly)',
            'Change in Organizational Structure or Roles',
            'Standardization (Aligning document format or process with national/central office standards)',
            'Obsolescence / Replacement (Replacing outdated document with new versions)',
            'Policy Direction/Management Instruction (Changes initiated by top management or directive from higher office)',
        ];

        foreach ($reasons as $reason) {
            Reason::updateOrCreate(['name' => $reason], ['name' => $reason]);
        }
    }
}
