<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [    ['name' => 'Dentist'],
        ['name' => 'Registered Nurse'],
        ['name' => 'Pharmacist'],
        ['name' => 'Computer Systems Analyst'],
        ['name' => 'Physician'],
        ['name' => 'Database Administrator'],
        ['name' => 'Software Developer'],
        ['name' => 'Physical Therapist'],
        ['name' => 'Web Developer'],
        ['name' => 'Dental Hygienist'],
        ['name' => 'Occupational Therapist'],
        ['name' => 'Veterinarian'],
        ['name' => 'Computer Programmer'],
        ['name' => 'School Psychologist'],
        ['name' => 'Physical Therapist Assistant'],
        ['name' => 'Interpreter & Translator'],
        ['name' => 'Mechanical Engineer'],
        ['name' => 'Veterinary Technologist & Technician'],
        ['name' => 'Epidemiologist'],
        ['name' => 'IT Manager'],
        ['name' => 'Market Research Analyst'],
        ['name' => 'Diagnostic Medical Sonographer'],
        ['name' => 'Computer Systems Administrator'],
        ['name' => 'Respiratory Therapist'],
        ['name' => 'Medical Secretary'],
        ['name' => 'Civil Engineer'],
        ['name' => 'Substance Abuse Counselor'],
        ['name' => 'Speech-Language Pathologist'],
        ['name' => 'Landscaper & Groundskeeper'],
        ['name' => 'Radiologic Technologist'],
        ['name' => 'Cost Estimator'],
        ['name' => 'Financial Advisor'],
        ['name' => 'Marriage & Family Therapist'],
        ['name' => 'Medical Assistant'],
        ['name' => 'Lawyer'],
        ['name' => 'Accountant'],
        ['name' => 'Compliance Officer'],
        ['name' => 'High School Teacher'],
        ['name' => 'Clinical Laboratory Technician'],
        ['name' => 'Maintenance & Repair Worker'],
        ['name' => 'Bookkeeping, Accounting, & Audit Clerk'],
        ['name' => 'Financial Manager'],
        ['name' => 'Recreation & Fitness Worker'],
        ['name' => 'Insurance Agent'],
        ['name' => 'Elementary School Teacher'],
        ['name' => 'Dental Assistant'],
        ['name' => 'Management Analyst'],
        ['name' => 'Home Health Aide'],
        ['name' => 'Pharmacy Technician'],
        ['name' => 'Construction Manager'],
        ['name' => 'Public Relations Specialist'],
        ['name' => 'Middle School Teacher'],
        ['name' => 'Massage Therapist'],
        ['name' => 'Paramedic'],
        ['name' => 'Preschool Teacher'],
        ['name' => 'Hairdresser'],
        ['name' => 'Marketing Manager'],
        ['name' => 'Patrol Officer'],
        ['name' => 'School Counselor'],
        ['name' => 'Executive Assistant'],
        ['name' => 'Financial Analyst'],
        ['name' => 'Personal Care Aide'],
        ['name' => 'Clinical Social Worker'],
        ['name' => 'Business Operations Manager'],
        ['name' => 'Loan Officer'],
        ['name' => 'Meeting, Convention & Event Planner'],
        ['name' => 'Mental Health Counselor'],
        ['name' => 'Nursing Aide'],
        ['name' => 'Sales Representative'],
        ['name' => 'Architect'],
        ['name' => 'Sales Manager'],
        ['name' => 'HR Specialist'],
        ['name' => 'Plumber'],
    ];
    Job::insert($data);
    }
}
