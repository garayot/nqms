<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Policy', 'description' => 'DepEd policy and administrative issuances.'],
            ['name' => 'Procedure', 'description' => 'Operational procedures and guidelines.'],
            ['name' => 'Form', 'description' => 'Standardized forms and templates.'],
            ['name' => 'Memo', 'description' => 'Internal memorandum and circulars.'],
        ];

        foreach ($types as $type) {
            DocumentType::updateOrCreate(['name' => $type['name']], $type + ['is_active' => true]);
        }
    }
}
