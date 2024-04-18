<?php

$directory_api_keys = [];
if (env('DIRECTORY_TYPE', 'repair') == 'reuse') {
    $directory_api_keys['customField1'] = 'deviceAcceptanceCriteria';
    $directory_api_keys['customField2'] = 'collectionArea';
    $directory_api_keys['warrantyOffered'] = 'hasDataErasurePolicy';
    $directory_api_keys['warranty'] = 'dataErasurePolicyDetails';
} else {
    $directory_api_keys['customField1'] = 'customField1';
    $directory_api_keys['customField2'] = 'customField2';
    $directory_api_keys['warrantyOffered'] = 'warrantyOffered'; // keep as-is
    $directory_api_keys['warranty'] = 'warranty'; // keep as-is
}

return [

    // This lets you rename the fields returned by API calls.
    // @see lang/en/admin.php for labels for the admin form
    'field_mapping' => [
        'customField1' => env('BUSINESS_FIELD_MAP_CUSTOM_FIELD1', $directory_api_keys['customField1']),
        'customField2' => env('BUSINESS_FIELD_MAP_CUSTOM_FIELD2', $directory_api_keys['customField2']),
        'warrantyOffered' => env('BUSINESS_FIELD_MAP_WARRANTY_OFFERED', $directory_api_keys['warrantyOffered']),
        'warranty' => env('BUSINESS_FIELD_MAP_WARRANTY', $directory_api_keys['warranty']),
    ]

];
