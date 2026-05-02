<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return match ($this->role) {
            'superadmin' => $this->superAdminStats(),
            'owner'      => $this->ownerStats(),
            'agent'      => $this->agentStats(),
            default      => [],
        };
    }

    /* ================= SUPERADMIN ================= */

    protected function superAdminStats(): array
    {
        return [
            'role' => 'superadmin',

            'stats' => [
                'total_revenue' => Property::where('sold', true)->sum('price'),
                'total_properties' => Property::count(),
                'total_users' => User::count(),
            ],

            'recent_users' => User::latest()->take(4)->get(['name','email']),

            'pie_properties' => [
                'sold' => Property::where('sold', true)->count(),
                'available' => Property::where('sold', false)->count(),
            ],

            'weekly_chart' => $this->weeklyRevenue(),

            'last_sales' => $this->lastSales(),
        ];
    }

    /* ================= OWNER ================= */

    protected function ownerStats(): array
    {
        return [
            'role' => 'owner',

            'stats' => [
                'revenue' => Property::where('user_id', $this->id)
                    ->where('sold', true)
                    ->sum('price'),
            ],

            'pie_properties' => [
                'sold' => Property::where('user_id', $this->id)->where('sold', true)->count(),
                'available' => Property::where('user_id', $this->id)->where('sold', false)->count(),
            ],

            'total_sales' => $this->totalSales(),
        ];
    }

    /* ================= AGENT ================= */

    protected function agentStats(): array
    {
        $revenue = Property::where('user_id', $this->id)
            ->where('sold', true)
            ->sum('price');

        return [
            'role' => 'agent',

            'stats' => [
                'revenue' => $revenue,
                'commission' => round($revenue * 0.16, 2),
            ],

            'pie_properties' => [
                'sold' => Property::where('user_id', $this->id)->where('sold', true)->count(),
                'available' => Property::where('user_id', $this->id)->where('sold', false)->count(),
            ],
            'total_sales' => $this->totalSales(),

            'last_sales' => $this->agentLastSales(),
        ];
    }

    /* ================= HISTORIQUE HEBDOMADAIRE ================= */

    protected function weeklyRevenue()
    {
        return Property::selectRaw('DATE(updated_at) as day, SUM(price) as total')
            ->where('sold', true)
            ->whereBetween('updated_at', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    protected function totalSales()
    {
        return Property::selectRaw('DATE(updated_at) as day, SUM(price) as total')
            ->where('sold', true)
            ->where('user_id', $this->id)
            ->whereBetween('updated_at', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    }

    /* ================= DERNIÈRES VENTES ================= */

    protected function lastSales()
    {
        return Property::with('user')
            ->where('sold', true)
            ->latest('updated_at')
            ->take(5)
            ->get();
    }

    protected function agentLastSales()
    {
        return Property::where('user_id', $this->id)
            ->where('sold', true)
            ->latest('updated_at')
            ->take(5)
            ->get();
    }
}