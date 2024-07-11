<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Quote;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\QuoteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuoteResource\RelationManagers;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel="Ordine";
    protected static ?string $pluralModelLabel="Ordini";
    protected static ?int $navigationSort = 9;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')->label('Cliente')
                    ->searchable()
                    ->relationship('customer')
                    ->getOptionLabelFromRecordUsing(function (Customer $record){
                        if($record->is_azienda){
                            $r = $record->nome_az;
                        } else $r = $record->first_name . ' ' . $record->last_name;
                        return $r;
                    })
                    ->preload()
                    ->searchable(['first_name', 'last_name','nome_az'])
                    ->default(request()->has('customer_id') ? request()->get('customer_id') : null)
                    ->required(),



                Section::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('quoteProducts')->label('Prodotti')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')->label('Prodotto')
                                    ->relationship('product', 'name')
                                    ->disableOptionWhen(function ($value, $state, Get $get) {
                                        return collect($get('../*.product_id'))
                                            ->reject(fn ($id) => $id == $state)
                                            ->filter()
                                            ->contains($value);
                                    })
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire) {
                                        $set('price', Product::find($get('product_id'))->price);
                                        self::updateTotals($get, $livewire);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('price')->label('Prezzo')
                                    ->required()
                                    ->numeric()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, $livewire) {
                                        self::updateTotals($get, $livewire);
                                    })
                                    ->prefix('€'),
                                Forms\Components\TextInput::make('quantity')->label('Quantità')
                                    ->integer()
                                    ->default(1)
                                    ->required()
                                    ->live()
                                //textinput sconto prodotto
                            ])
                            ->live()
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            })
                            ->afterStateHydrated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            })
                            ->deleteAction(
                                fn (Action $action) => $action->after(fn (Get $get, $livewire) => self::updateTotals($get, $livewire)),
                            )
                            ->reorderable(false)
                            ->columns(3)
                    ]),
                Section::make()
                    ->columns(1)
                    ->maxWidth('1/2')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')->label('Subtotale')
                            ->numeric()
                            ->readOnly()
                            ->prefix('€')
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            }),
                        //textinput sconto su subtotale
                        Forms\Components\TextInput::make('taxes')->label('Tasse')
                            ->suffix('%')
                            ->required()
                            ->numeric()
                            ->default(20)
                            ->live(true)
                            ->afterStateUpdated(function (Get $get, $livewire) {
                                self::updateTotals($get, $livewire);
                            }),
                        Forms\Components\TextInput::make('total')->label('Totale')
                            ->numeric()
                            ->readOnly()
                            ->prefix('€')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->formatStateUsing(function ($record) {
                        if($record->customer->is_azienda){
                            $r = $record->customer->nome_az;
                        } else $r = $record->customer->first_name . ' ' . $record->customer->last_name;
                        return $r;
                    })
                    ->searchable(['first_name', 'last_name','nome_az'])
                    ->sortable()
                    ->label('Cliente'),
                Tables\Columns\TextColumn::make('taxes')->label('Tasse')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')->label('Subtotale')
                    ->numeric()
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')->label('Totale')
                    ->numeric()
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Modificato')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(25)
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
            ])
            ->recordUrl(function ($record) {
                return Pages\ViewQuote::getUrl([$record]);
            });
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
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'view' => Pages\ViewQuote::route('/{record}'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }

    public static function updateTotals(Get $get, $livewire): void
    {
        // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
        $statePath = $livewire->getFormStatePath();

        $products = data_get($livewire, $statePath . '.quoteProducts');
        if (collect($products)->isEmpty()) {
            return;
        }
        $selectedProducts = collect($products)->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = collect($products)->pluck('price', 'product_id');

        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        data_set($livewire, $statePath . '.subtotal', number_format($subtotal, 2, '.', ''));
        data_set($livewire, $statePath . '.total', number_format($subtotal + ($subtotal * (data_get($livewire, $statePath . '.taxes') / 100)), 2, '.', ''));
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ViewEntry::make('invoice')
                    ->columnSpanFull()
                    ->viewData([
                        'record' => $infolist->record
                    ])
                    ->view('infolists.components.quote-invoice-view')
            ]);
    }
}
