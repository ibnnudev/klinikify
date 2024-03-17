<?php

namespace Database\Seeders;

use App\Models\DoctorCategory;
use Illuminate\Database\Seeder;

class DoctorCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Cardiologist',
            'Dermatologist',
            'Endocrinologist',
            'Gastroenterologist',
            'Hematologist',
            'Infectious Disease Specialist',
            'Nephrologist',
            'Neurologist',
            'Oncologist',
            'Ophthalmologist',
            'Otolaryngologist',
            'Pulmonologist',
            'Rheumatologist',
            'Urologist',
            'Allergist',
            'Anesthesiologist',
            'Colon and Rectal Surgeon',
            'Critical Care Medicine Specialist',
            'Emergency Medicine Specialist',
            'Family Physician',
            'General Surgeon',
            'Gynecologist',
            'Hospice and Palliative Medicine Specialist',
            'Internist',
            'Medical Geneticist',
            'Nuclear Medicine Specialist',
            'Obstetrician',
            'Occupational Medicine Specialist',
            'Ophthalmologist',
            'Orthopedic Surgeon',
            'Osteopathic Physician',
            'Pathologist',
            'Pediatrician',
            'Physiatrist',
            'Plastic Surgeon',
            'Podiatrist',
            'Psychiatrist',
            'Radiation Oncologist',
            'Radiologist',
            'Reproductive Endocrinologist',
            'Rheumatologist',
            'Sleep Medicine Specialist',
            'Spinal Cord Injury Specialist',
            'Sports Medicine Specialist',
            'Thoracic Surgeon',
            'Urologist',
            'Vascular Surgeon',
            'Acupuncturist',
            'Audiologist',
            'Chiropractor',
            'Dentist',
            'Dietitian',
            'Homeopath',
            'Massage Therapist',
            'Medical Doctor',
            'Naturopath',
            'Nurse',
            'Nutritionist',
            'Occupational Therapist',
            'Optometrist',
            'Pharmacist',
            'Physical Therapist',
            'Physician Assistant',
            'Podiatrist',
            'Psychologist',
            'Psychotherapist',
            'Reflexologist',
            'Reiki Master',
            'Social Worker',
            'Speech Therapist',
            'Veterinarian',
            'Yoga Instructor',
        ];

        DoctorCategory::insert(array_map(fn ($category) => ['name' => $category], $categories));
    }
}
