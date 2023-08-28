<?php

namespace App\Filament;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;

class CanDeleteBulk
{
    public static function check(DeleteBulkAction|ForceDeleteBulkAction $action, Collection $records) {
        if ($records->contains(fn ($record) => ! $record->canBeDeleted())) {
            $ids = $records
                ->filter(fn ($record) => ! $record->canBeDeleted())
                ->take(3)
                ->pluck('id')
                ->join(', ', trans('candil/notifications.@final_separator'));

            Notification::make()
                ->warning()
                ->title(trans('candil/notifications.cant_send_to_trash.title'))
                ->body(
                    trans('candil/notifications.cant_send_to_trash.body', [
                        'records' => $ids,
                    ])
                )
                ->persistent()
                ->send();

            $action->cancel();
        }
    }
}