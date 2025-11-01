<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\EmissionCard;
use App\Models\EmissionRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('email', [
            'miguel@noldomain.test',
            'dania@noldomain.test',
            'leon@noldomain.test',
        ])->get();

        $community = Community::first();

        foreach ($users as $index => $user) {
            EmissionRecord::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'recorded_for' => Carbon::now()->subDays(7)->toDateString(),
                    'category' => 'transportation',
                ],
                [
                    'community_id' => $community?->id,
                    'scope' => 'personal',
                    'emission_kg_co2' => 45.5 - ($index * 5),
                    'reduction_kg_co2' => 12.3 + $index,
                    'source' => 'daily_commute',
                    'notes' => 'Perjalanan harian dengan sepeda dan transportasi umum.',
                    'evidence_path' => 'evidence/emission-' . $user->id . '.jpg',
                    'recorded_by' => $user->id,
                    'metadata' => [
                        'calculation_method' => 'self_reported',
                    ],
                ]
            );

            EmissionCard::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'card_number' => 'EM-' . strtoupper(Str::random(6)),
                    'status' => 'active',
                    'total_emission_kg_co2' => 250.25 - ($index * 12.5),
                    'total_reduction_kg_co2' => 89.5 + ($index * 3.5),
                    'summary' => 'Ringkasan jejak karbon pribadi selama tahun berjalan.',
                    'qr_code_path' => 'qr/emission-card-' . $user->id . '.png',
                    'issued_at' => Carbon::now()->subMonths(1),
                    'expires_at' => Carbon::now()->addMonths(11),
                    'metadata' => [
                        'badge' => $index === 0 ? 'Platinum' : 'Gold',
                    ],
                ]
            );
        }
    }
}
