<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\Expense;
use App\Models\Department;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Tailwind for pagination styling
        Paginator::useTailwind();

        // Share notification data with all views
        View::composer('*', function ($view) {
            $pendingCount = 0;
            $pendingExpenses = [];
            $dropdownNotifications = collect();
            $unreadCount = 0;

            if (Auth::check()) {
                $user = Auth::user();

                // For head: pending expenses
                if ($user->role === 'head') {
                    $department = Department::where('department_head_id', $user->id)->first();

                    if ($department) {
                        $pendingExpenses = Expense::where('department_id', $department->id)
                            ->where('status', 'pending')
                            ->latest()
                            ->take(5)
                            ->get();

                        $pendingCount = $pendingExpenses->count();
                    }
                }

                // Notifications for all roles
                $dropdownNotifications = Notification::where('user_id', $user->id)
                    ->latest()
                    ->limit(5)
                    ->get();

                $unreadCount = $dropdownNotifications->where('read', false)->count();
            }

            $view->with([
                'pendingExpenseCount' => $pendingCount,
                'recentPendingExpenses' => $pendingExpenses,
                'dropdownNotifications' => $dropdownNotifications,
                'unreadCount' => $unreadCount,
            ]);
        });
    }
}
