<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionSummaryResource\Pages;
use App\Filament\Resources\TransactionSummaryResource\RelationManagers;
use App\Models\TransactionSummary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionSummaryResource extends Resource
{
    protected static ?string $model = TransactionSummary::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Rekap Transaksi';
    protected static ?string $pluralModelLabel = 'Rekap Transaksi';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->numeric(),
                Forms\Components\TextInput::make('transaction')
                    ->label('Jumlah Transaksi')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->orderBy('created_at', 'DESC');
            })
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->label('Tanggal')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->label('Total')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction')
                    ->numeric()
                    ->label('Jumlah Transaksi')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTransactionSummaries::route('/'),
            // 'create' => Pages\CreateTransactionSummary::route('/create'),
            // 'edit' => Pages\EditTransactionSummary::route('/{record}/edit'),
        ];
    }
}
