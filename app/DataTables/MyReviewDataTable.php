<?php

namespace App\DataTables;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MyReviewDataTable extends DataTable
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
            ->addColumn('books', function ($review) {
                return $review->book->title;
            })
            ->addColumn('reviews', function ($review) {
                return strlen($review->review) > 25 ? substr($review->review, 0, 25) . '...' : $review->review;
            })
            ->addColumn('ratings', function ($review) {
                return number_format($review->ratings, 1, '.', ',');
            })
            ->addColumn('action', function ($row) {
                return '<a href="my-reviews/edit/' . $row->id . '" class="btn btn-warning btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="#" onclick="deleteReview(' . $row->id . ')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Review $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', Auth::user()->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('myreview-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between"lf>rt<"d-flex justify-content-between"ip>')
            ->lengthMenu([5, 10, 25, 50, 100])
            ->orderBy(1)
            ->selectStyleSingle()
            ->setTableHeadClass('table table-bordered table-dark table-hover');;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('Id')->searchable(false),
            Column::make('books')->title('Books')->orderable(false)->searchable(true),
            Column::make('reviews')->title('Reviews')->orderable(false)->searchable(false),
            Column::make('ratings')->title('Ratings')->orderable(true)->searchable(false),
            Column::make('action')->title('Actions')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MyReview_' . date('YmdHis');
    }
}
