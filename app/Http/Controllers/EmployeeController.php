<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function handleFileUpload(CsvUploadRequest $request)
    {
        try {
            $filePath = $this->storeUploadedFile($request->file('file'));

            // CSV structure validation
            $request->validateCsvFormat(storage_path('app/' . $filePath));

            // Employee pairs and total working days
            $employeePairs = $this->extractEmployeePairsFromCsv(storage_path('app/' . $filePath));
            $longestPair = $this->getLongestWorkingPair($employeePairs);

            return view('result', compact('longestPair', 'employeePairs'));

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * @param $file
     * @return mixed
     */
    private function storeUploadedFile($file)
    {
        return $file->storeAs('uploads', $file->getClientOriginalName());
    }

    /**
     * Extract employee pairs and calculate their total working days
     *
     * @param $filePath
     * @return array
     */
    private function extractEmployeePairsFromCsv($filePath)
    {
        $csvData = array_map('str_getcsv', file($filePath));
        array_shift($csvData);

        $pairs = [];

        foreach ($csvData as $row) {
            list($empId, $projectId, $dateFrom, $dateTo) = $row;

            // Parse dates
            $dateFrom = $this->parseDate($dateFrom);
            $dateTo = $this->parseDate($dateTo === "NULL" ? now()->toDateString() : $dateTo);

            foreach ($csvData as $otherRow) {
                list($otherEmpId, $otherProjectId, $otherDateFrom, $otherDateTo) = $otherRow;

                // Skip if employee IDs match or projects don't match
                if ($empId === $otherEmpId || $projectId !== $otherProjectId) {
                    continue;
                }

                // Parse the other employee's dates
                $otherDateFrom = $this->parseDate($otherDateFrom);
                $otherDateTo = $this->parseDate($otherDateTo === 'NULL' ? now()->toDateString() : $otherDateTo);

                // Calculate the overlapping period
                $overlapStart = $this->getLatestDate($dateFrom, $otherDateFrom);
                $overlapEnd = $this->getEarliestDate($dateTo, $otherDateTo);

                // Calculate the days worked
                if ($overlapStart < $overlapEnd) {
                    $daysWorked = $this->calculateDaysWorked($overlapStart, $overlapEnd);
                    $pairKey = $this->generatePairKey($empId, $otherEmpId, $projectId);

                    $pairs[$pairKey] = $daysWorked;
                }
            }
        }

        return $pairs;
    }

    /**
     * Parse a date
     *
     * @param string $date
     * @return Carbon|null
     */
    private function parseDate($date)
    {
        if (!$date || $date === 'NULL') {
            return null;
        }

        return Carbon::parse($date);
    }

    /**
     * Get the latest date between two dates
     *
     * @param Carbon $date1
     * @param Carbon $date2
     * @return Carbon
     */
    private function getLatestDate($date1, $date2)
    {
        return $date1->gt($date2) ? $date1 : $date2;
    }

    /**
     * Get the earliest date between two dates
     *
     * @param Carbon $date1
     * @param Carbon $date2
     * @return Carbon
     */
    private function getEarliestDate($date1, $date2)
    {
        return $date1->lt($date2) ? $date1 : $date2;
    }

    /**
     * Calculate the number of days worked between two dates
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return int
     */
    private function calculateDaysWorked($startDate, $endDate)
    {
        return $startDate->diffInDays($endDate);
    }

    /**
     * Generate a unique key for the pair of employees working together on a project
     *
     * @param $empId
     * @param $otherEmpId
     * @param $projectId
     * @return string
     */
    private function generatePairKey($empId, $otherEmpId, $projectId)
    {
        return implode('-', [min($empId, $otherEmpId), max($empId, $otherEmpId), $projectId]);
    }

    /**
     * Find the pair of employees who have worked together the longest
     *
     * @param $pairs
     * @return array|null
     */
    private function getLongestWorkingPair($pairs)
    {
        $longestPair = null;
        $maxDays = 0;

        foreach ($pairs as $pair => $daysWorked) {
            if ($daysWorked > $maxDays) {
                $maxDays = $daysWorked;
                $longestPair = $pair;
            }
        }

        if ($longestPair) {
            list($employee1, $employee2, $projectId) = explode('-', $longestPair);
            return compact('employee1', 'employee2', 'projectId', 'maxDays');
        }

        return null;
    }
}
