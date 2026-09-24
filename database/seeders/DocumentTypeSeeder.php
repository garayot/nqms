<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Form/Template', 'description' => 'Standardized forms and templates.'],
            ['name' => 'QMS Manual', 'description' => 'Quality Management System manual documents.'],
            ['name' => 'PAWIM', 'description' => 'Process and work instruction manual documents.'],
            ['name' => 'Planning Documents (SWOT, Risk Registry, Opportunity Registry, Relevant Interested Parties, OPCR)', 'description' => 'Planning and strategic support documents.'],
            ['name' => 'Operations Manual (Title Page, Introduction, Terms and Acronyms, Legal Bases, Forms/Templates)', 'description' => 'Operations manual documentation package.'],
            ['name' => 'Quality Control Plan', 'description' => 'Quality control planning documents.'],
        ];

        $typeNames = array_column($types, 'name');

        DocumentType::query()
            ->whereNotIn('name', $typeNames)
            ->whereDoesntHave('drafs')
            ->delete();

        DocumentType::query()
            ->whereNotIn('name', $typeNames)
            ->update(['is_active' => false]);

        foreach ($types as $type) {
            DocumentType::updateOrCreate(['name' => $type['name']], $type + ['is_active' => true]);
        }
    }
}
