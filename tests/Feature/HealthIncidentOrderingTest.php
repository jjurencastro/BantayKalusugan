<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\HealthIncident;
use App\Models\MedicalAdvice;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthIncidentOrderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_dashboard_lists_requests_without_advice_before_advised_requests(): void
    {
        [$doctorUser, $doctor] = $this->createDoctorUser('Doctor Dashboard');
        $patient = $this->createPatient('Patient Dashboard');

        $criticalPending = $this->createIncident($patient, 'critical', now()->subMinutes(5));
        $lowPending = $this->createIncident($patient, 'low', now()->subMinutes(10));
        $criticalAdvised = $this->createIncident($patient, 'critical', now()->subMinutes(15));
        $lowAdvised = $this->createIncident($patient, 'low', now()->subMinutes(20));

        $this->createAdvice($patient, $doctor, $criticalAdvised);
        $this->createAdvice($patient, $doctor, $lowAdvised);

        $response = $this->actingAs($doctorUser)->get(route('doctor.dashboard'));

        $response->assertOk();
        $this->assertSame(
            [$criticalPending->id, $lowPending->id, $criticalAdvised->id, $lowAdvised->id],
            $response->viewData('recentRequests')->pluck('id')->take(4)->all()
        );
    }

    public function test_nurse_assistance_requests_use_the_same_ordering(): void
    {
        [, $doctor] = $this->createDoctorUser('Doctor Nurse View');
        [$nurseUser] = $this->createNurseUser('Nurse Viewer');
        $patient = $this->createPatient('Patient Nurse View');

        $criticalPending = $this->createIncident($patient, 'critical', now()->subMinutes(5));
        $lowPending = $this->createIncident($patient, 'low', now()->subMinutes(10));
        $criticalAdvised = $this->createIncident($patient, 'critical', now()->subMinutes(15));
        $lowAdvised = $this->createIncident($patient, 'low', now()->subMinutes(20));

        $this->createAdvice($patient, $doctor, $criticalAdvised);
        $this->createAdvice($patient, $doctor, $lowAdvised);

        $response = $this->actingAs($nurseUser)->get(route('nurse.assistance-requests'));

        $response->assertOk();
        $this->assertSame(
            [$criticalPending->id, $lowPending->id, $criticalAdvised->id, $lowAdvised->id],
            $response->viewData('incidents')->getCollection()->pluck('id')->take(4)->all()
        );
    }

    private function createDoctorUser(string $name): array
    {
        $user = $this->createUser($name, User::ROLE_DOCTOR);

        return [
            $user,
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => 'DOC-'.$user->id,
                'specialization' => 'General Medicine',
            ]),
        ];
    }

    private function createNurseUser(string $name): array
    {
        $user = $this->createUser($name, User::ROLE_NURSE);

        return [
            $user,
            Nurse::create([
                'user_id' => $user->id,
                'license_number' => 'NUR-'.$user->id,
                'specialization' => 'Community Health',
            ]),
        ];
    }

    private function createPatient(string $name): Patient
    {
        $user = $this->createUser($name, User::ROLE_PATIENT);

        return Patient::create([
            'user_id' => $user->id,
        ]);
    }

    private function createUser(string $name, string $role): User
    {
        return User::create([
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)).'@example.com',
            'password' => 'password',
            'role' => $role,
            'is_active' => true,
        ]);
    }

    private function createIncident(Patient $patient, string $severity, $reportedAt): HealthIncident
    {
        return HealthIncident::create([
            'patient_id' => $patient->id,
            'incident_type' => 'illness',
            'description' => 'Needs review',
            'symptoms' => 'Fever',
            'status' => 'reported',
            'severity' => $severity,
            'reported_at' => $reportedAt,
        ]);
    }

    private function createAdvice(Patient $patient, Doctor $doctor, HealthIncident $incident): MedicalAdvice
    {
        return MedicalAdvice::create([
            'patient_id' => $patient->id,
            'health_incident_id' => $incident->id,
            'doctor_id' => $doctor->id,
            'advice' => 'Rest and hydrate.',
        ]);
    }
}
