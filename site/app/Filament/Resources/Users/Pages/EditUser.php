<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /** `role` is not fillable (brg-35 §3.5); only admins reach this page. */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->fill($data)->forceFill(['role' => $data['role']])->save();

        return $record;
    }
}
