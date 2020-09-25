<?php

namespace App\DataTables;

// use App\ExportDataTable;
use App\Price;
use App\Purchase_order;
use App\Purchase_order_item;
use App\Masteritem;
use DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class ExportDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\ExportDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ExportDataTable $model)
    {
        // return $model->newQuery();
        $data = DB::select("SELECT master_items.supplier, prices.item_code, prices.`description`, prices.price_buying, MAX(creation), 
                    SUM(prices.`price_buying`) - prices.`price_buying` AS deviation
                            FROM master_items
                            INNER JOIN prices ON master_items.`id` = prices.`master_item_id`
                            GROUP BY prices.`item_code`
                            ORDER BY prices.`creation` DESC;
                    ");
        // $data = DB::table('master_items')
        // ->join('prices','mater_items.id','=','prices.master_item_id')
        // ->select()
        // dd(json_encode($data));
        return $this->applyScopes(json_encode($data));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            // ->setTableId('exportdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('csv'),
                Button::make('excel')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {

        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('item_code'),
            Column::make('description'),
            Column::make('supplier'),
            Column::make('price_buying'),
            Column::make('deviation'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        dd(11);

        return 'Export_' . date('YmdHis');
    }
}
