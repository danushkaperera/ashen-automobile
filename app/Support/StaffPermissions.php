<?php

namespace App\Support;

use App\Models\User;

class StaffPermissions
{
    public static function pages(): array
    {
        return [
            'staff.desk' => [
                'label' => 'Workshop desk',
                'group' => 'Staff portal',
                'entry' => 'staff.dashboard',
                'routes' => ['staff.dashboard'],
            ],
            'staff.services' => [
                'label' => 'Services & registrations',
                'group' => 'Staff portal',
                'entry' => 'staff.services.index',
                'routes' => ['staff.services.*', 'staff.visits.*', 'staff.customers.lookup'],
            ],
            'staff.jobs' => [
                'label' => 'Jobs & invoices',
                'group' => 'Staff portal',
                'entry' => 'staff.jobs.index',
                'routes' => ['staff.jobs.*'],
            ],
            'admin.dashboard' => [
                'label' => 'Admin dashboard',
                'group' => 'Admin',
                'entry' => 'admin.dashboard',
                'routes' => ['admin.dashboard'],
            ],
            'admin.settings' => [
                'label' => 'Site settings',
                'group' => 'Website',
                'entry' => 'admin.settings.index',
                'routes' => ['admin.settings.*'],
            ],
            'admin.sections' => [
                'label' => 'Homepage sections',
                'group' => 'Website',
                'entry' => 'admin.sections.index',
                'routes' => ['admin.sections.*'],
            ],
            'admin.heroes' => [
                'label' => 'Hero slides',
                'group' => 'Website',
                'entry' => 'admin.heroes.index',
                'routes' => ['admin.heroes.*'],
            ],
            'admin.menus' => [
                'label' => 'Menus',
                'group' => 'Website',
                'entry' => 'admin.menus.index',
                'routes' => ['admin.menus.*'],
            ],
            'admin.pages' => [
                'label' => 'Pages',
                'group' => 'Website',
                'entry' => 'admin.pages.index',
                'routes' => ['admin.pages.*'],
            ],
            'admin.services' => [
                'label' => 'Services',
                'group' => 'Content',
                'entry' => 'admin.services.index',
                'routes' => ['admin.services.*'],
            ],
            'admin.features' => [
                'label' => 'Why choose us',
                'group' => 'Content',
                'entry' => 'admin.features.index',
                'routes' => ['admin.features.*'],
            ],
            'admin.stats' => [
                'label' => 'Stats',
                'group' => 'Content',
                'entry' => 'admin.stats.index',
                'routes' => ['admin.stats.*'],
            ],
            'admin.team' => [
                'label' => 'Team',
                'group' => 'Content',
                'entry' => 'admin.team.index',
                'routes' => ['admin.team.*'],
            ],
            'admin.testimonials' => [
                'label' => 'Testimonials',
                'group' => 'Content',
                'entry' => 'admin.testimonials.index',
                'routes' => ['admin.testimonials.*'],
            ],
            'admin.gallery' => [
                'label' => 'Gallery',
                'group' => 'Content',
                'entry' => 'admin.gallery.index',
                'routes' => ['admin.gallery.*'],
            ],
            'admin.faqs' => [
                'label' => 'FAQs',
                'group' => 'Content',
                'entry' => 'admin.faqs.index',
                'routes' => ['admin.faqs.*'],
            ],
            'admin.hours' => [
                'label' => 'Working hours',
                'group' => 'Content',
                'entry' => 'admin.hours.index',
                'routes' => ['admin.hours.*'],
            ],
            'admin.bookings' => [
                'label' => 'Bookings',
                'group' => 'Inbox',
                'entry' => 'admin.bookings.index',
                'routes' => ['admin.bookings.*'],
            ],
            'admin.messages' => [
                'label' => 'Messages',
                'group' => 'Inbox',
                'entry' => 'admin.messages.index',
                'routes' => ['admin.messages.*'],
            ],
            'admin.staff' => [
                'label' => 'Staff users & access',
                'group' => 'Workshop',
                'entry' => 'admin.staff.index',
                'routes' => ['admin.staff.*'],
            ],
            'admin.customers' => [
                'label' => 'Customers',
                'group' => 'Workshop',
                'entry' => 'admin.customers.index',
                'routes' => ['admin.customers.*'],
            ],
            'admin.jobs' => [
                'label' => 'Jobs & invoices',
                'group' => 'Workshop',
                'entry' => 'admin.jobs.index',
                'routes' => ['admin.jobs.*'],
            ],
        ];
    }

    public static function keys(): array
    {
        return array_keys(self::pages());
    }

    public static function defaults(): array
    {
        return ['staff.desk', 'staff.services', 'staff.jobs'];
    }

    public static function grouped(): array
    {
        $groups = [];

        foreach (self::pages() as $key => $page) {
            $groups[$page['group']][$key] = $page;
        }

        return $groups;
    }

    public static function matches(string $permission, ?string $routeName): bool
    {
        if (! $routeName || ! isset(self::pages()[$permission])) {
            return false;
        }

        foreach (self::pages()[$permission]['routes'] as $pattern) {
            if ($routeName === $pattern) {
                return true;
            }

            if (str_ends_with($pattern, '.*') && str_starts_with((string) $routeName, substr($pattern, 0, -1))) {
                return true;
            }
        }

        return false;
    }

    public static function grantedAdminLinks(User $user): array
    {
        $links = [];

        foreach (self::pages() as $key => $page) {
            if (! str_starts_with($key, 'admin.') || ! $user->hasPermission($key)) {
                continue;
            }

            $links[] = $page + ['key' => $key];
        }

        return $links;
    }
}
