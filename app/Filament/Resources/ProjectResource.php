<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use App\Models\User;
use App\Models\Transaction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Closure;
use Filament\Forms\Components\Hidden;



class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
       
        return $form
            ->schema([
                Card::make()
                   ->schema([
                Forms\Components\Select::make('user_id')
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
                    ->reactive()   
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
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                          ->sortable()
                          ->searchable(), 
                Tables\Columns\TextColumn::make('user.name')
                          ->label('Client Name')
                          ->sortable()
                          ->searchable(),
                Tables\Columns\TextColumn::make('project_name')
                           ->sortable() 
                           ->searchable(),
                Tables\Columns\TextColumn::make('payment_type'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\TextColumn::make('Pending Amount')
                           ->getStateUsing(fn ($record) => $record->total_amount - $record->transactions->sum('amount_paid')),
                Tables\Columns\TextColumn::make('monthly_amount'),
                Tables\Columns\TextColumn::make('invoice_from')
                           ->date(),
                Tables\Columns\TextColumn::make('invoice_to')
                           ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\TransactionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }    
}