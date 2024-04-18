<?php

// This lets you rename the fields returned by API calls.
// @see lang/en/admin.php for labels for the admin form

$directory_api_keys = [];

if (env('DIRECTORY_TYPE', 'repair') == 'reuse') {
    // Reuse Directory confif
    $directory_api_keys['customField1'] = 'deviceAcceptanceCriteria';
    $directory_api_keys['customField2'] = 'collectionArea';
    $directory_api_keys['customField3'] = 'dropoffLocations';
    $directory_api_keys['warrantyOffered'] = 'hasDataErasurePolicy';
    $directory_api_keys['warranty'] = 'dataErasurePolicyDetails';
} else {
    // Repair Directory confif
    $directory_api_keys['customField1'] = 'customField1';
    $directory_api_keys['customField2'] = 'customField2';
    $directory_api_keys['customField3'] = 'customField3';
    $directory_api_keys['warrantyOffered'] = 'warrantyOffered'; // keep as-is
    $directory_api_keys['warranty'] = 'warranty'; // keep as-is
}

return [

    'field_mapping' => [
        'customField1' => $directory_api_keys['customField1'],
        'customField2' => $directory_api_keys['customField2'],
        'customField3' => $directory_api_keys['customField3'],
        'warrantyOffered' => $directory_api_keys['warrantyOffered'],
        'warranty' => $directory_api_keys['warranty'],
    ]

];
