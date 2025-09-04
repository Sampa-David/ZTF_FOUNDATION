<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departement;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatistiqueController extends Controller
{
    public function index()
    {
        $stats = $this->getDefaultStats();
        return view('staff.statistique', $stats);
    }

    public function apiStats(Request $request)
    {
        $startDate = $request->input('start', Carbon::now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end', Carbon::now()->format('Y-m-d'));

        // Récupérer l'utilisateur connecté et son département
        $user = Auth::user();
        $departmentId = $user->department_id;

        // Filtrer les données en fonction des autorisations de l'utilisateur
        $usersQuery = User::query();
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $usersQuery->where('department_id', $departmentId);
        }

        $statsData = [
            'activeUsers' => $this->getActiveUsers($usersQuery),
            'todayLogins' => $this->getTodayLogins($usersQuery),
            'avgSessionTime' => $this->getAverageSessionTime(),
            'totalRegistrations' => $usersQuery->count(),
        ];

        // Statistiques détaillées
        $detailedStats = [
            'departmentData' => $this->getDepartmentStats($user),
            'roleData' => $this->getRoleStats($user),
            'serviceData' => $this->getServiceStats($user),
            'userActivity' => $this->getUserActivityStats($usersQuery, $startDate, $endDate)
        ];

        return response()->json(array_merge($statsData, $detailedStats));
    }

    private function getDefaultStats()
    {
        $user = Auth::user();
        $usersQuery = User::query();
        
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $usersQuery->where('department_id', $user->department_id);
        }

        return [
            'activeUsers' => $this->getActiveUsers($usersQuery),
            'todayLogins' => $this->getTodayLogins($usersQuery),
            'avgSessionTime' => $this->getAverageSessionTime(),
            'totalRegistrations' => $usersQuery->count(),
            'userRoles' => $this->getCurrentUserRoles(),
            'departmentName' => $user->Departement ? $user->Departement->name : 'Non assigné'
        ];
    }

    private function getActiveUsers($usersQuery)
    {
        return $usersQuery->whereNotNull('last_login_at')
            ->where('last_login_at', '>=', Carbon::now()->subDay())
            ->count();
    }

    private function getTodayLogins($usersQuery)
    {
        return $usersQuery->whereDate('last_login_at', Carbon::today())->count();
    }

    private function getAverageSessionTime()
    {
        $avgMinutes = DB::table('users')
            ->whereNotNull('last_login_at')
            ->whereNotNull('last_activity_at')
            ->whereDate('last_login_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, last_login_at, last_activity_at)) as avg_time')
            ->value('avg_time') ?? 0;

        return sprintf("%d:%02d", floor($avgMinutes/60), $avgMinutes%60);
    }

    private function getDepartmentStats($user)
    {
        $query = Departement::withCount('users');
        
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $query->where('id', $user->department_id);
        }

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getRoleStats($user)
    {
        $query = Role::withCount(['users' => function($query) use ($user) {
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                $query->where('department_id', $user->department_id);
            }
        }]);

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getServiceStats($user)
    {
        $query = Service::withCount(['users' => function($query) use ($user) {
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                $query->where('department_id', $user->department_id);
            }
        }]);

        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            $query->whereHas('departement', function($q) use ($user) {
                $q->where('id', $user->department_id);
            });
        }

        $stats = $query->get();

        return [
            'names' => $stats->pluck('name')->toArray(),
            'counts' => $stats->pluck('users_count')->toArray()
        ];
    }

    private function getUserActivityStats($usersQuery, $startDate, $endDate)
    {
        return $usersQuery
            ->selectRaw('DATE(last_login_at) as date, COUNT(*) as count')
            ->whereBetween('last_login_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->reduce(function ($carry, $item) {
                $carry['dates'][] = $item->date;
                $carry['counts'][] = $item->count;
                return $carry;
            }, ['dates' => [], 'counts' => []]);

        // Remplir les heures manquantes avec 0
        $completeHourlyStats = array_fill(0, 24, 0);
        foreach ($hourlyStats as $hour => $count) {
            $completeHourlyStats[$hour] = $count;
        }

        return $completeHourlyStats;
    }
}
