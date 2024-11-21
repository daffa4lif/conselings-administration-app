<?php

namespace App\Services;

interface AbsentService
{
    function createNewAbsentsBySpreadsheetTemp(int $folderTemp, string $date): array;
}