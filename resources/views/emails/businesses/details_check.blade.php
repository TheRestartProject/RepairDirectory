<html>
<head>
    <style type="text/css">
        body > * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

    <h2>Check business details</h2>

    <ul>
        <li><strong>{{ __('admin.name') }}:</strong>  {{ $business->getName() }}</li>
        <li><strong>{{ __('admin.address') }}:</strong> {{ $business->getAddress() }}</li>
        <li><strong>{{ __('admin.postcode') }}:</strong> {{ $business->getPostcode() }}</li>
        <li><strong>{{ __('admin.description') }}:</strong> {{ $business->getDescription() }}</li>

        <li><strong>{{ __('admin.phone') }}:</strong> {{ $business->getLandline() }}</li>
        <li><strong>{{ __('admin.mobile') }}:</strong> {{ $business->getMobile() }}</li>
        <li><strong>{{ __('admin.website') }}:</strong> {{ $business->getWebsite() }}</li>
        <li><strong>{{ __('admin.email') }}:</strong> {{ $business->getEmail() }}</li>

        <li><strong>{{ __('admin.categories') }}:</strong> {{ implode(', ', $business->getCategories()) }}</li>
        <li><strong>{{ __('admin.qualifications') }}:</strong> {{ $business->getQualifications() }}</li>
        <li><strong>{{ __('admin.community_endorsement') }}:</strong> {{ $business->getCommunityEndorsement() }}</li>

        <li><strong>{{ __('admin.custom_field1') }}:</strong> {{ $business->getCustomField1() }}</li>
        <li><strong>{{ __('admin.custom_field2') }}:</strong> {{ $business->getCustomField2() }}</li>
        <li><strong>{{ __('admin.custom_field3') }}:</strong> {{ $business->getCustomField3() }}</li>
        <li><strong>{{ __('admin.warranty_offered') }}:</strong> {{ $business->isWarrantyOffered() }}</li>
        <li><strong>{{ __('admin.warranty_details') }}:</strong> {{ $business->getWarranty() }}</li>

    </ul>

    <div>
        Please reply to this email with any amendments needed.
    </div>

</body>
</html>