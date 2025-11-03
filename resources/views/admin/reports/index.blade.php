@extends('layouts.dashboard')

@section('title', 'Management Reports')
@section('page-title', 'Management Reports')
@section('page-subtitle', 'Eksplorasi data emisi dan partisipasi challenge seluruh komunitas.')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <h2 class="text-xl font-semibold text-blue-900">Explore Emission Insights</h2>
            <p class="mt-1 text-sm text-slate-500">Rangkuman kontribusi reduksi CO₂ per universitas/komunitas.</p>

            <div class="mt-6 overflow-hidden rounded-[32px] border border-blue-100">
                <table class="min-w-full divide-y divide-blue-100 text-sm">
                    <thead class="bg-blue-800 text-left text-xs font-semibold uppercase tracking-[0.3em] text-white">
                    <tr>
                        <th class="px-6 py-3">University</th>
                        <th class="px-6 py-3">Emissions Total</th>
                        <th class="px-6 py-3">Average monthly emissions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50 bg-white">
                    @forelse ($communityEmissions as $row)
                        <tr class="hover:bg-blue-50/70">
                            <td class="px-6 py-4 font-semibold text-blue-900">{{ $row['name'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $row['total_emission'] }}</td>
                            <td class="px-6 py-4 text-blue-700">{{ $row['average_monthly'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-sm text-blue-600">Belum ada data emisi.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-[48px] border border-blue-200 bg-white p-8 shadow-lg">
            <h2 class="text-xl font-semibold text-blue-900">Challenge Participation</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau peserta paling aktif dan status challenge mereka.</p>

            <div class="mt-6 overflow-hidden rounded-[32px] border border-blue-100">
                <table class="min-w-full divide-y divide-blue-100 text-sm">
                    <thead class="bg-blue-800 text-left text-xs font-semibold uppercase tracking-[0.3em] text-white">
                    <tr>
                        <th class="px-6 py-3">Nama Peserta</th>
                        <th class="px-6 py-3">Nama Challenge</th>
                        <th class="px-6 py-3">Point</th>
                        <th class="px-6 py-3 text-right">Status</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50 bg-white">
                    @forelse ($challengeParticipation as $row)
                        <tr class="hover:bg-blue-50/70">
                            <td class="px-6 py-4 font-semibold text-blue-900">{{ $row['user'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $row['challenge'] }}</td>
                            <td class="px-6 py-4 text-blue-700 font-semibold">{{ $row['points'] }} poin</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-1 text-xs font-semibold text-blue-700">
                                    <i class="fa-solid fa-circle-notch"></i> {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-sm text-blue-600">Belum ada peserta yang tercatat.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('admin.reports.activities') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-blue-800">
                    User Activity
                </a>
            </div>
        </section>
    </div>
@endsection
