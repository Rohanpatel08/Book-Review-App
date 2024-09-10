<?php

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReviewDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('book', function ($review) {
                return strlen($review->book->title) > 25 ? substr($review->book->title, 0, 25) . '...' : $review->book->title;
            })
            ->addColumn('user', function ($review) {
                return $review->user->name;
            })
            ->addColumn('review', function ($review) {
                return strlen($review->review) > 25 ? substr($review->review, 0, 23) . '...' : $review->review;
            })
            ->addColumn('ratings', function ($review) {
                return number_format($review->ratings, 1, '.', ',');
            })
            ->addColumn('status', function ($book) {
                return $book->status == 1
                    ? '<span class="text-success">Active</span>'
                    : '<span class="text-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '<a href="reviews/edit/' . $row->id . '" class="btn btn-warning btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="" onclick="deleteReview(' . $row->id . ')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Review $model): QueryBuilder
    {
        return $model->newQuery()->with(['user', 'book']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('review-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between my-2"ip>')
            ->lengthMenu([5, 10, 25, 50, 100])
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'processing' => true
            ])
            ->setTableHeadClass('table table-bordered table-dark table-hover');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('book')->title('Books')->searchable(true),
            Column::make('user')->title('Users')->orderable(false)->searchable(true),
            Column::make('review')->title('Reviews')->orderable(false)->searchable(false),
            Column::make('ratings')->title('Ratings')->orderable(true)->searchable(false),
            Column::make('status')->title('Status')->searchable(true)->orderable(false),
            Column::make('action')->title('Actions')->searchable(false)->orderable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Review_' . date('YmdHis');
    }
}
