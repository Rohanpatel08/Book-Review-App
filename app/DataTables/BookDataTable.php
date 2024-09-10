<?php

namespace App\DataTables;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BookDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('status', function ($book) {
                return $book->status == 1
                    ? '<span class="text-success">Active</span>'
                    : '<span class="text-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '<a href="books/' . $row->id . '/edit" class="btn btn-warning btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="deleteBook(' . $row->id . ')"><i class="fa-solid fa-trash"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Book $model): QueryBuilder
    {
        return $model->newQuery()->with('reviews');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('book-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>')
            // ->pageLength()
            ->lengthMenu([5, 10, 25, 50, 100])
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'paging' => true,
                'processing' => true,
                'serverSide' => true,
                'searching' => true,
                'info' => true,
                'searchDelay' => 350,
                'select' => true,
                'bSort' => true,
            ])->addTableClass('table table-bordered table-hover')
            ->setTableHeadClass('table-dark');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('Id')->searchable(false)->addClass('text-center'),
            Column::make('title')->title('Title')->addClass('text-center'),
            Column::make('author')->title('Author')->addClass('text-center'),
            Column::make('status')->title('Status')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('action')->addClass('text-center')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Book_' . date('YmdHis');
    }
}
