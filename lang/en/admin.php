<?php

if (env('DIRECTORY_TYPE', 'repair') == 'reuse') {
    // Reuse Directory config
    $categories_label = 'Types of donations received';
    $qualifications_label = 'How to donate';
    $community_endorsement_label = 'Who receives the devices';
    $custom_field1_label = 'Device Acceptance Criteria';
    $custom_field2_label = 'Collection Area';
    $custom_field3_label = 'Drop-off Locations';
    $warranty_offered_label = 'Has Data Erasure Policy';
    $warranty_details_label = 'Data Erasure Policy Details';
} else {
    // Repair Directory config
    $categories_label = 'Categories';
    $qualifications_label = 'Qualifications';
    $community_endorsement_label = 'Community Endorsement';
    $custom_field1_label = 'Custom Field 1 (Unused)';
    $custom_field2_label = 'Custom Field 2 (Unused)';
    $custom_field3_label = 'Custom Field 3 (Unused)';
    $warranty_offered_label = 'Warranty Offered';
    $warranty_details_label = 'Warranty Details';
}

return [

    'title' => 'Repair Directory Admin',
    'go_to_map' => 'Go to the Map',

    'form_title' => 'All Repair Businesses',
    'new_business' => 'New Business',
    'edit_business' => 'Edit Business',

    'name' => 'Name',
    'address' => 'Address',
    'city' => 'City',
    'postcode' => 'Postcode',
    'local_area' => 'Borough / Local Area',
    'description' => 'Description',
    'phone' => 'Landline',
    'mobile' => 'Mobile',
    'website' => 'Website',
    'email' => 'Email',
    'categories' => $categories_label,
    'products_repaired' => 'Products Repaired',
    'authorised_brands' => 'Authorised Brands',
    'qualifications' => $qualifications_label,
    'community_endorsement' => $community_endorsement_label,
    'notes' => 'Notes',
    'custom_field1' => $custom_field1_label,
    'custom_field2' => $custom_field2_label,
    'custom_field3' => $custom_field3_label,
    'positive_review_percentage' => 'Positive Review Percentage',
    'average_scores' => 'Average score',
    'review_source' => 'Review Source',
    'number_of_reviews' => 'Number of Reviews',
    'review_count' => 'Review Count',
    'review_percent' => 'Review %',
    'warranty_offered' => $warranty_offered_label,
    'warranty_details' => $warranty_details_label,
    'publishing_status' => 'Publishing Status',
    'business_check_mail_optout' => 'Avoid sending review emails',
    'hide_reason' => 'Hide Reason',

    'submissions' => 'Submissions',
    'submissions_via_gravity_forms' => 'Submissions via Gravity Forms',
    'submission' => 'Gravity Form submission',
    'submission_date' => 'Submission date',
    'submitted_by_employee' => 'Submitted by employee?',
    'submission_extra_info' => 'Anything else we should know about this business?',
    'submission_status' => 'Status',

    'website_invalid' => 'Please check and update the address:',

    'your_role_is' => 'Your role is',

    'save' => 'Save',
    'delete' => 'Delete',
    'cancel' => 'Cancel',

    'your_profile' => 'Your profile',
    'homepage' => 'Restarters Homepage',
    'logout' => 'Logout'
];
