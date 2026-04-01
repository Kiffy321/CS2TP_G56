<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Low Stock & Out of Stock Items')
            ->query(
                Product::query()->whereColumn('stock_quantity', '<=', 'stock_threshold')
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category'),
                TextColumn::make('stock_quantity')
                    ->label('Current Stock')
                    ->badge()
                    ->color(fn ($state) => $state === 0 ? 'danger' : 'warning')
                    ->sortable(),
                TextColumn::make('stock_threshold')
                    ->label('Alert Threshold')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Update Stock')
                    ->modalHeading('Update Stock Quantity')
                    ->form([
                        TextInput::make('stock_quantity')
                            ->label('New Stock Quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                    ]),
            ])
            ->emptyStateHeading('All products are well stocked')
            ->emptyStateDescription('No items are currently at or below their alert threshold.');
    }
}
