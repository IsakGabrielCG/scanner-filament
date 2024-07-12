<?php
namespace App\Filament\Resources;

use App\Filament\Forms\Components\QrCode;
use App\Filament\Resources\TestesResource\Pages;
use App\Models\Teste;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestesResource extends Resource
{
    protected static ?string $model = Teste::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name'),
                Forms\Components\TextInput::make('QrCode')
                    ->label('QrCode')
                    ->disabled()
                    ->suffixIcon('heroicon-o-qr-code')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('QrCode', $state);
                    }),

                QrCode::make('QrCodeButton')
                    ->label('Camera')
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('QrCode')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTestes::route('/'),
            'create' => Pages\CreateTestes::route('/create'),
            'edit' => Pages\EditTestes::route('/{record}/edit'),
        ];
    }
}
