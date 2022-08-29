<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use App\Models\User;
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
                    ->required(),
                Forms\Components\TextInput::make('monthly_amount')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('invoice_from')
                    ->required(),
                Forms\Components\DatePicker::make('invoice_to')
                    ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'), 
                Tables\Columns\TextColumn::make('client.name')->label('Client Name'),
                Tables\Columns\TextColumn::make('project_name'),
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
            ->actions([
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
            //
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
