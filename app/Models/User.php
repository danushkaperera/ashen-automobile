<?php

namespace App\Models;

use App\Support\StaffPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'is_admin',
        'role',
        'is_active',
        'permissions',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'permissions' => 'array',
    ];

    public function isAdmin(): bool
    {
        return ($this->role ?: 'admin') === 'admin';
    }

    public function isStaffMember(): bool
    {
        return $this->role === 'staff';
    }

    public function permissionKeys(): array
    {
        if ($this->isAdmin()) {
            return StaffPermissions::keys();
        }

        if ($this->permissions === null) {
            return StaffPermissions::defaults();
        }

        return array_values(array_intersect(StaffPermissions::keys(), $this->permissions));
    }

    public function hasPermission(string $key): bool
    {
        return $this->isAdmin() || in_array($key, $this->permissionKeys(), true);
    }

    public function canAccessAny(array $keys): bool
    {
        foreach ($keys as $key) {
            if ($this->hasPermission($key)) {
                return true;
            }
        }

        return false;
    }

    public function canAccessRoute(?string $routeName): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (in_array($routeName, ['admin.logout', 'staff.logout', 'staff.dashboard'], true)) {
            return true;
        }

        if (str_starts_with((string) $routeName, 'admin.profile.') && $this->canAccessAny(
            array_filter(StaffPermissions::keys(), fn ($key) => str_starts_with($key, 'admin.'))
        )) {
            return true;
        }

        foreach ($this->permissionKeys() as $key) {
            if (StaffPermissions::matches($key, $routeName)) {
                return true;
            }
        }

        return false;
    }

    public function homePath(): string
    {
        if ($this->isAdmin()) {
            return route('admin.dashboard');
        }

        foreach (['staff.desk', 'staff.services', 'staff.jobs'] as $key) {
            if ($this->hasPermission($key)) {
                return route(StaffPermissions::pages()[$key]['entry']);
            }
        }

        foreach (StaffPermissions::grantedAdminLinks($this) as $link) {
            return route($link['entry']);
        }

        return route('staff.dashboard');
    }

    public function registeredVisits(): HasMany
    {
        return $this->hasMany(CustomerVisit::class, 'registered_by');
    }
}
