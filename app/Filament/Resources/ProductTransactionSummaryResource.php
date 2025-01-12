<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionSummaryResource\Pages;
use App\Filament\Resources\ProductTransactionSummaryResource\RelationManagers;
use App\Models\ProductTransactionSummary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductTransactionSummaryResource extends Resource
{
    protected static ?string $model = ProductTransactionSummary::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Rekap Transaksi Produk';
    protected static ?string $pluralModelLabel = 'Rekap Transaksi Produk';

    protected static ?int $navigationSort = 6;

    public static function shouldRegisterNavigation(): bool
    {
        if(Auth::user()->email == 'admin@admin.com'){
            return true;
        }else{
            return false;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->numeric(),
                Forms\Components\TextInput::make('transaction')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ExportBulkAction::make()
                        ->label('Export Excel')
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
            'index' => Pages\ListProductTransactionSummaries::route('/'),
            // 'create' => Pages\CreateProductTransactionSummary::route('/create'),
            // 'edit' => Pages\EditProductTransactionSummary::route('/{record}/edit'),
        ];
    }
}
