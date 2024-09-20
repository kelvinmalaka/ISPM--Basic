<?php

return [

    /** Set the default classes for each part of the table. */
    'classes' => [
        'container' => ['table-responsive'],
        'table' => ['table-borderless'],
        'tr' => ['border-bottom'],
        'th' => ['align-middle'],
        'td' => ['align-middle'],
        'results' => ['table-secondary'],
        'disabled' => ['table-danger', 'disabled'],
    ],

    /** Set all the action icons that are used on the table templates. */
    'icon' => [
        'rows_number' => '<i class="bi-list"></i>',
        'sort' => '<i class="bi-sort-alpha-down"></i>',
        'sort_asc' => '<i class="bi-sort-up"></i>',
        'sort_desc' => '<i class="bi-sort-down"></i>',
        'search' => '<i class="bi-search"></i>',
        'validate' => '<i class="bi-arrow-right"></i>',
        'info' => '<i class="bi-plus-circle"></i>',
        'reset' => '<i class="bi-arrow-counterclockwise"></i>',
        'create' => '<i class="bi-plus-circle"></i>',
        'show' => '<i class="bi-eye"></i>',
        'edit' => '<i class="bi-pencil-square"></i>',
        'destroy' => '<i class="bi-trash"></i>',
    ],

    /** Set the table default behavior. */
    'behavior' => [
        'rows_number' => 10,
        'activate_rows_number_definition' => true,
    ],

    /** Set the default view path for each component of the table. */
    'template' => [
        'table' => 'bootstrap.table',
        'thead' => 'bootstrap.thead',
        'rows_searching' => 'bootstrap.rows-searching',
        'rows_number_definition' => 'bootstrap.rows-number-definition',
        'create_action' => 'bootstrap.create-action',
        'column_titles' => 'bootstrap.column-titles',
        'tbody' => 'bootstrap.tbody',
        'show_action' => 'bootstrap.show-action',
        'edit_action' => 'bootstrap.edit-action',
        'destroy_action' => 'bootstrap.destroy-action',
        'results' => 'bootstrap.results',
        'tfoot' => 'bootstrap.tfoot',
        'navigation_status' => 'bootstrap.navigation-status',
        'pagination' => 'bootstrap.pagination',
    ],

];
