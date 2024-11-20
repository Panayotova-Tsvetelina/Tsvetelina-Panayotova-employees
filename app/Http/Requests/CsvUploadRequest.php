<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Exception;

class CsvUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Validate file type and size
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:csv,txt|max:10240',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'file.required' => __('validation.file_required'),
            'file.mimes' => __('validation.file_mimes'),
            'file.max' => __('validation.file_max'),
        ];
    }

    /**
     * CSV format validation
     *
     * @param $filePath
     * @return void
     * @throws ValidationException
     */
    public function validateCsvFormat($filePath)
    {
        $csvData = array_map('str_getcsv', file($filePath));
        $header = array_shift($csvData);

        // Header validation
        if (count($header) !== 4) {
            throw ValidationException::withMessages(['file' => __('validation.csv_header')]);
        }

        foreach ($csvData as $row) {
            // Columns validation
            if (count($row) !== 4) {
                throw ValidationException::withMessages(['file' => __('validation.csv_row')]);
            }

            list($empId, $projectId, $dateFrom, $dateTo) = $row;

            // Employee ID and Project ID validation
            if (!is_numeric($empId) || !is_numeric($projectId)) {
                throw ValidationException::withMessages(['file' => __('validation.csv_numeric')]);
            }

            // Date format validation
            if (!$this->isValidDate($dateFrom) || ($dateTo !== "NULL" && !$this->isValidDate($dateTo))) {
                throw ValidationException::withMessages(['file' => __('validation.csv_date_format')]);
            }
        }
    }

    /**
     * Check valid date for multiple formats
     *
     * @param string $date
     * @return bool
     */
    private function isValidDate($date)
    {
        if ($date === "NULL") {
            return true;
        }

        // parse the date
        try {
            $parsedDate = Carbon::parse($date);

            return $parsedDate instanceof Carbon && $parsedDate->isValid();
        } catch (Exception $e) {
            return false;
        }
    }
}
