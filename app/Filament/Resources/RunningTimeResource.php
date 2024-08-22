<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RunningTimeResource\Pages;
use App\Filament\Resources\RunningTimeResource\Pages\ViewRunningTime;
use App\Filament\Resources\RunningTimeResource\RelationManagers\TransaksiProdukRelationManager;
use App\Models\Config;
use App\Models\Meja;
use App\Models\RunningTime;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RunningTimeResource extends Resource
{
    protected static ?string $model = RunningTime::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';


    protected static ?string $navigationLabel = 'Pesan meja';

    protected static ?string $pluralModelLabel = 'Pesanan Meja';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('paket')
                    ->label('Tipe Paket')
                    ->required()
                    ->reactive()
                    ->placeholder('Pilih paket atau personal')
                    // ->afterStateUpdated(
                    //     fn ($state, callable $set) => dd($state)
                    // )
                    ->options([
                        'personal' => 'Personal',
                        '1' => 'Paket 1 Jam',
                        '2' => 'Paket 2 Jam',
                        '3' => 'Paket 3 Jam',
                        '4' => 'Paket 4 Jam',
                    ]),
                Select::make('shift')
                    ->label('Shift')
                    ->required()
                    ->reactive()
                    ->placeholder('Pilih Shift Harga')
                    ->options(Config::get()->pluck('name', 'name'))
                    ->afterStateUpdated(
                        fn ($state, callable $set) => $state == 'Shift Siang' ? $set('harga_per_jam', 25000) : $set('harga_per_jam', 35000)
                    ),
                Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 2,
                    'lg' => 4
                ])
                    ->schema([
                        Fieldset::make('Waktu Mulai')
                            ->schema([
                                Checkbox::make('waktu_mulai')
                                    ->label('Waktu Mulai Sekarang')
                                    ->helperText('Di isi ketika waktu mulai dari sekarang'),
                                DateTimePicker::make('waktu_mulai_picker')
                                    ->label('Waktu Mulai Tentukan')
                                    ->nullable()
                                    ->string()
                                    ->helperText('Di isi ketika waktu mulai sudah di tentukan'),
                            ])
                            ->reactive()
                            ->hidden(
                                fn (Get $get): bool => ($get('paket') == 'personal' || $get('paket') == null) ? false : true
                            )
                            ->columnSpan(2),
                        Fieldset::make('Waktu Selesai')
                            ->schema([
                                Checkbox::make('waktu_selesai')
                                    ->label('Waktu Selesai Sekarang')
                                    ->helperText('Di isi ketika waktu selesai sekarang'),
                                DateTimePicker::make('waktu_selesai_picker')
                                    ->label('Waktu Selesai Tentukan')
                                    ->nullable()
                                    ->string()
                                    ->helperText("Di isi ketika waktu selesai sudah ditentukan !")
                            ])
                            ->hidden(
                                fn (Get $get): bool => ($get('paket') == 'personal' || $get('paket') == null) ? false : true
                            )
                            ->columnSpan(2)
                    ]),
                Fieldset::make('Penyewa')
                    ->schema([
                        TextInput::make('nama_penyewa')
                            ->maxLength(255)
                            ->helperText("Di isi ketika bukan member")
                            ->placeholder('Nama Penyewa')
                            ->label('Nama Penyewa'),
                        Select::make('id_member')
                            ->relationship('member', 'nama')
                            ->preload()
                            ->searchable()
                            ->label('Member')
                            ->helperText("Boleh di kosongkan jika bukan member"),
                    ]),
                Select::make('nomor_meja')
                    ->required()
                    ->searchable()
                    ->options(Meja::get()->pluck('name', 'name'))
                    ->placeholder('Pilih meja'),
                TextInput::make('harga_per_jam')
                    ->label('Harga Per Jam')
                    ->required()
                    ->numeric()
                    ->placeholder('Harga Per Jam')
                    ->default(config('app.harga_per_jam')),
                // Textarea::make('deskripsi')
                //     ->placeholder('Deskripsi')
                //     ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->orderBy('created_at', 'DESC');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('No. Order')
                    ->numeric()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return '#' . $state;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_meja')
                    ->label('Meja')
                    ->alignCenter()
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_pembayaran')
                    ->label('Pembayaran')
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Lunas';
                        } else {
                            return 'Belum';
                        }
                    })
                    ->color(function ($record) {
                        if ($record->status_pembayaran == 1) {
                            return 'success';
                        } else {
                            return 'danger';
                        }
                    })
                    ->badge(),
                TextColumn::make('nama_penyewa')
                    ->label('Pelanggan')
                    ->searchable(),
                TextColumn::make('member.nama')
                    ->label('Member')
                    ->sortable(),
                TextColumn::make('waktu_mulai')
                    ->dateTime()
                    ->label('Mulai')
                    ->sortable(),
                TextColumn::make('waktu_selesai')
                    ->dateTime()
                    ->label('Selesai')
                    ->sortable(),
                TextColumn::make('waktu_running')
                    ->label('Lama')
                    ->formatStateUsing(function ($state) {
                        return $state . ' Menit';
                    })
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('harga_per_jam')
                    ->label('Harga/Jam')
                    ->alignEnd()
                    ->formatStateUsing(function ($state) {
                        return 'Rp.' . number_format($state, 0, ',', '.');
                    })
                    ->sortable(),
                TextColumn::make('transaksiProduk')
                    ->label('Qty Tambahan')
                    ->alignCenter()
                    ->formatStateUsing(function ($record) {
                        return $record->transaksiProduk->sum('jumlah') ?? 0;
                    }),
                TextColumn::make('updated_at')
                    ->label('Total')
                    ->formatStateUsing(function ($record) {
                        return 'Rp.' . number_format($record->total(), 0, ',', '.');
                    }),
                // TextColumn::make('deskripsi')
                //     ->label('Keterangan')
                //     ->toggleable(isToggledHiddenByDefault: false)
                //     ->searchable(),
                TextColumn::make('user.name')
                    ->label('Kasir')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->color('primary'),
                    ViewAction::make(),
                    DeleteAction::make(),
                    Action::make('mulai')
                        ->icon('heroicon-o-clock')
                        ->color('success')
                        ->label('Mulai')
                        ->action(function ($record) {
                            $record->update([
                                'waktu_mulai' => now()
                            ]);
                        })
                        ->hidden(function ($record) {
                            if ($record->waktu_mulai == null) {
                                return false;
                            } else {
                                return true;
                            }
                        }),
                    Action::make('Lakukan_Pembayaran')
                        ->label(function ($record) {
                            if ($record->status_pembayaran == 1) {
                                return 'Detail Pesanan';
                            }
                            return 'Lakukan Pembayaran';
                        })
                        ->action(function ($record, $livewire) {
                            return redirect()->route('print_order', ['id' => $record->id]);
                        })
                        ->icon(function ($record) {
                            if ($record->status_pembayaran == 1) {
                                return 'heroicon-o-document-text';
                            }
                            return 'heroicon-o-banknotes';
                        })
                        ->color(function ($record) {
                            if ($record->status_pembayaran == 1) {
                                return 'info';
                            }
                            return 'success';
                        }),
                ])
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            TransaksiProdukRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRunningTimes::route('/'),
            'create' => Pages\CreateRunningTime::route('/create'),
            'view' => ViewRunningTime::route('{record}'),
            'edit' => Pages\EditRunningTime::route('/{record}/edit'),
        ];
    }
}
