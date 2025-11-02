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
            'rizki.user@noldomain.test',
            'citra.user@noldomain.test',
            'mutia.user@noldomain.test',
        ])->get();

        $community = Community::first();

        foreach ($users as $index => $user) {
            $recordDates = [
                Carbon::now()->subDays(7),
                Carbon::now()->subDays(3),
                Carbon::now()->subDay(),
            ];

            foreach ($recordDates as $date) {
                EmissionRecord::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'recorded_for' => $date->toDateString(),
                        'category' => 'transportation',
                    ],
                    [
                        'community_id' => $community?->id,
                        'scope' => 'personal',
                        'emission_kg_co2' => max(5, 45.5 - ($index * 5) - rand(0, 7)),
                        'reduction_kg_co2' => 12.3 + $index + rand(0, 3),
                        'source' => 'daily_commute',
                        'notes' => 'Perjalanan harian dengan sepeda, transportasi umum, dan jalan kaki.',
                        'evidence_path' => 'evidence/emission-' . $user->id . '-' . $date->format('Ymd') . '.jpg',
                        'recorded_by' => $user->id,
                        'metadata' => [
                            'calculation_method' => 'self_reported',
                        ],
                    ]
                );
            }

            $baseEmission = 240 - ($index * 10) - rand(0, 15);
            $baseReduction = 85 + ($index * 4) + rand(0, 6);

            EmissionCard::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'card_number' => 'EM-' . strtoupper(Str::random(6)),
                    'status' => 'active',
                    'total_emission_kg_co2' => max(20, $baseEmission),
                    'total_reduction_kg_co2' => $baseReduction,
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
