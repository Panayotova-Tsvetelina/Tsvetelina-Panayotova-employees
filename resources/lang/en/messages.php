<?php

return [
    // Header and description
    'employee_pair_title' => 'Pair of employees who have worked together',
    'employee_pair_details' => 'Here are the details of the Pair of employees who have worked together',
    'pair_employees' => 'Pair of employees who have worked together',
    'choose_file' => 'Please choose a CSV file to upload',

    // Error messages
    'went_wrong' => 'Whoops! Something went wrong',
    'check_errors' => 'Please check the following errors:',

    // Form label and button
    'choose_csv' => 'Choose a CSV file:',
    'upload' => 'Upload',

    // Alert message
    'no_pair_found' => 'No pair found',

    // Table heading
    'all_employee_pairs' => 'All Employee Pairs',
    'employee_id_1' => 'Employee ID #1',
    'employee_id_2' => 'Employee ID #2',
    'project_id' => 'Project ID',
    'days_worked' => 'Days Worked',

    // Custom validation messages
    'file_required' => 'Please upload a file.',
    'file_mimes' => 'The file must be a CSV or TXT file.',
    'file_max' => 'The file size must not exceed 10MB.',
    'csv_header' => 'CSV must have exactly 4 columns: EmpID, ProjectID, DateFrom, DateTo.',
    'csv_row' => 'Each row must have exactly 4 columns.',
    'csv_numeric' => 'Employee ID and Project ID must be numeric values.',
    'csv_date_format' => 'Invalid date format. Use "Y-m-d".',
];
