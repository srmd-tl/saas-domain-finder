<?php

namespace App\DataTables;

use App\DomainEmail;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DomainEmailDataTable extends DataTable
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
      ->eloquent($query)
      ->addColumn('action', function (DomainEmail $domain) {
        return '<td > <div class="d-flex"> <a target="_blank" href="' . route('generateReport', [$domain->id,"type"=>"email"]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                     <i class="la la-edit"></i>
                     Generate Report
                     </a>

                     </div></td> ';
      })
      ->addColumn('is_present', function ($data) {
        if ($data->is_present == 1) {
          return 'Yes';
        } else {
          return 'No';
        }
      })
      ->editColumn('name', function ($data) {
        return '<a target="_blank" href="http://www.' . $data->name . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                     ' . $data->name . '
                 </a>';
      })
      ->escapeColumns('name');
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\DomainEmail $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(DomainEmail $model)
  {
    return $model->newQuery();
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html()
  {
    return $this->builder()
      ->setTableId('domainemail-table')
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->dom('Bfrtip')
      ->orderBy(2)
      ->parameters([

        'dom' => 'Bfrtip',

        'buttons' => ['excel', 'csv'],

      ]);
  }

  /**
   * Get columns.
   *
   * @return array
   */
  protected function getColumns()
  {
    return [
      Column::computed('action')
        ->exportable(true)
        ->width(60)
        ->addClass('text-center'),
      Column::make('is_present'),
      Column::make('id'),
      Column::computed('name')
        ->exportable(false)
        ->printable(false)
        ->width(60)
        ->addClass('text-center'),
      Column::make('email'),
      Column::make('title'),
      Column::make('description'),
      Column::make('register_date'),
      Column::make('server'),
      Column::make('owner_name'),
      Column::make('other_name'),
      Column::make('address'),
      Column::make('city'),
      Column::make('state')
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename()
  {
    return 'DomainEmail_' . date('YmdHis');
  }
}
