<?php

namespace App\Exports;

use App\Models\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Request::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.request.columns.activated'),
            trans('admin.request.columns.id'),
            trans('admin.request.columns.message'),
            trans('admin.request.columns.sender_id'),
            trans('admin.request.columns.user_id'),
        ];
    }

    /**
     * @param Request $request
     * @return array
     *
     */
    public function map($request): array
    {
        return [
            $request->activated,
            $request->id,
            $request->message,
            $request->sender_id,
            $request->user_id,
        ];
    }
}
