<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Models\User;


class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $recordTitleAttribute = 'project_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label('Client Name')
                    ->options(User::all()->pluck('name','id')->toArray()),
                Forms\Components\TextInput::make('project_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('project_desc')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('payment_type')
                    ->options([
                        'one_time' => 'One Time',
                        'recurring' => 'Recurring',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('total_amount')
                     ->visible(fn ($get) => $get('payment_type') === 'one_time')
                     ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('monthly_amount')
                     ->visible(fn ($get) => $get('payment_type') === 'recurring')
                     ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('invoice_from')
                    ->visible(fn ($get) => $get('payment_type') === 'recurring')
                    ->required(),
                Forms\Components\DatePicker::make('invoice_to')
                    ->visible(fn ($get) => $get('payment_type') === 'recurring')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                          ->sortable()
                          ->searchable(), 
                Tables\Columns\TextColumn::make('client.name')->label('Client Name')
                          ->sortable()
                          ->searchable(),
                Tables\Columns\TextColumn::make('project_name')
                          ->sortable()
                          ->searchable(),
                Tables\Columns\TextColumn::make('project_desc'),
                Tables\Columns\TextColumn::make('payment_type'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\TextColumn::make('monthly_amount'),
                Tables\Columns\TextColumn::make('invoice_from')
                    ->date(),
                Tables\Columns\TextColumn::make('invoice_to')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
