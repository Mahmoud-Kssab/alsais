<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return User::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.user.columns.activated'),
            trans('admin.user.columns.address'),
            trans('admin.user.columns.avatar'),
            trans('admin.user.columns.email'),
            trans('admin.user.columns.email_verified_at'),
            trans('admin.user.columns.id'),
            trans('admin.user.columns.job'),
            trans('admin.user.columns.name'),
            trans('admin.user.columns.phone'),
            trans('admin.user.columns.uuid'),
        ];
    }

    /**
     * @param User $user
     * @return array
     *
     */
    public function map($user): array
    {
        return [
            $user->activated,
            $user->address,
            $user->avatar,
            $user->email,
            $user->email_verified_at,
            $user->id,
            $user->job,
            $user->name,
            $user->phone,
            $user->uuid,
        ];
    }
}
