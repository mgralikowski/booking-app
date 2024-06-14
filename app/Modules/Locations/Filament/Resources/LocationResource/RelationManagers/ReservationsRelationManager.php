<?php

namespace App\Modules\Locations\Filament\Resources\LocationResource\RelationManagers;

use App\Modules\Reservations\Filament\Resources\ReservationResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservations';

    public function form(Form $form): Form
    {
        return ReservationResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ReservationResource::table($table);
    }
}
